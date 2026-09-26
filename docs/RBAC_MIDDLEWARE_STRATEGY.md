# SIMRS RBAC & Middleware Privilege Strategy

## 1. Executive Summary & Security Philosophy

Dalam Sistem Informasi Manajemen Rumah Sakit (SIMRS), kerahasiaan (*confidentiality*), integritas (*integrity*), dan ketersediaan (*availability*) data medis pasien merupakan mandat regulasi (UU Kesehatan, Permenkes Rekam Medis Elektronik / RME, dan standar HIPAA / ISO 27001).

Sistem autentikasi menerapkan prinsip **Natural Role Identification**:
- Pengguna masuk menggunakan satu pintu (*unified login form*) menggunakan identitas unik (email atau username) dan kata sandi.
- Sistem mengidentifikasi peran pengguna (**Perawat**, **Pasien**, **Dokter**, **Superadmin**, dll.) langsung dari database entitas terverifikasi, bukan melalui input seleksi manual di sisi klien. Hal ini mencegah manipulasi peran (*privilege spoofing*).

Strategi otorisasi menggunakan pendekatan **Defence-in-Depth**:
1. **Coarse-Grained Gatekeeping (HTTP Middleware)**: Memvalidasi apakah peran pengguna diizinkan mengakses kluster rute tertentu (misal: rute perawat tidak boleh dimasuki pasien).
2. **Fine-Grained Data Scoping (Eloquent Model Policies)**: Memvalidasi kepemilikan data pada level rekaman spesifik (misal: pasien hanya boleh melihat rekam medis milik dirinya sendiri: `auth()->id() === $record->patient_id`).

---

## 2. Definisi Peran (Roles) & Tanggung Jawab

| Peran | Enum (`UserRole`) | Deskripsi Tanggung Jawab Operasional |
| :--- | :--- | :--- |
| **Nurse (Perawat)** | `UserRole::Nurse` (`nurse`) | Pemantauan tanda-tanda vital harian pasien, pelaksanaan asuhan keperawatan, verifikasi pemberian obat (*Medication Administration Record*), triase gawat darurat, dan serah terima shift jaga (*shift handover*). |
| **Patient (Pasien)** | `UserRole::Patient` (`patient`) | Pasien rawat jalan / rawat inap yang mengakses portal mandiri untuk melihat rekam medis pribadi, jadwal temu dokter, antrean poliklinik, e-resep, dan rincian biaya perawatan. |
| **Doctor (Dokter)** | `UserRole::Doctor` (`doctor`) | Dokter spesialis / umum yang menegakkan diagnosis (ICD-10), meresepkan terapi obat, meminta tes penunjang (lab/rontgen), dan menandatangani resume medis. |
| **Superadmin** | `UserRole::Superadmin` (`superadmin`) | Manajemen sistem rumah sakit menyeluruh: akun staf, audit log keamanan, hak akses, integrasi SatuSehat / BPJS, dan master data kamar/bangsal. |

---

## 3. Matriks Hak Akses Tindakan (Action Privileges Matrix)

Tabel berikut merangkum tindakan operasional klinis dan administratif beserta tingkat proteksi middleware yang dibutuhkan:

| Modul / Tindakan Klinis | Nurse | Patient | Doctor | Admin / Super | Strategi Proteksi | Audit Level |
| :--- | :---: | :---: | :---: | :---: | :--- | :---: |
| **Login & Dashboard Profil** | ✅ | ✅ | ✅ | ✅ | `auth` | Basic |
| **Melihat Antrean Bangsal Rawat Inap** | ✅ | ❌ | ✅ | ✅ | `middleware('role:nurse,doctor,superadmin')` | Normal |
| **Input & Edit Tanda Vital Pasien** | ✅ | ❌ | ✅ | ✅ | `middleware('role:nurse,doctor')` | High |
| **Input Asuhan & Observasi Keperawatan**| ✅ | ❌ | ❌ | ✅ | `middleware('role:nurse,superadmin')` | High |
| **Validasi Pemberian Obat (MAR)** | ✅ | ❌ | ❌ | ✅ | `middleware('role:nurse')` | Critical |
| **Input Operan Jaga (Shift Handover)** | ✅ | ❌ | ❌ | ❌ | `middleware('role:nurse')` | Normal |
| **Melihat Ringkasan Rekam Medis Pribadi**| ❌ | ✅ (Own) | ❌ | ❌ | `middleware('role:patient')` + `MedicalRecordPolicy` | High |
| **Booking Jadwal Konsultasi Dokter** | ❌ | ✅ | ❌ | ✅ | `middleware('role:patient,superadmin')` | Normal |
| **Melihat Hasil Lab & Radiologi Pribadi**| ❌ | ✅ (Own) | ❌ | ❌ | `middleware('role:patient')` + `LabResultPolicy` | Critical |
| **Melihat & Membayar Tagihan Perawatan** | ❌ | ✅ (Own) | ❌ | ✅ | `middleware('role:patient,superadmin')` + `InvoicePolicy` | High |
| **Input Diagnosis & Resep Obat Medis** | ❌ | ❌ | ✅ | ❌ | `middleware('role:doctor')` | Critical |
| **Manajemen Pengguna & Konfigurasi SIMRS**| ❌ | ❌ | ❌ | ✅ | `middleware('role:superadmin')` | Critical |

> **Keterangan:**
> - `(Own)`: Wajib diperkuat oleh Laravel Policy yang membatasi query ke pemilik sah data (`$user->id === $model->user_id`).

---

## 4. Arsitektur Middleware yang Direkomendasikan

### 4.1. Desain Middleware `EnsureUserHasRole`

Mengacu pada konvensi Laravel 12 dan aturan proyek `.cursor/rules/http-middleware.mdc`:
- Menggunakan parameter variadic `string ...$roles` sehingga rute dapat menerima satu atau banyak peran: `role:nurse`, `role:nurse,doctor`.
- Mengembalikan HTTP `403 Forbidden` jika pengguna terautentikasi tidak memiliki peran yang diizinkan.

```php
<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $userRoleValue = $user->role instanceof UserRole 
            ? $user->role->value 
            : (string) $user->role;

        // Superadmin bypass: Superadmin memiliki akses administratif darurat
        if ($userRoleValue === UserRole::Superadmin->value) {
            return $next($request);
        }

        if (! in_array($userRoleValue, $roles, true)) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki otoritas peran untuk tindakan ini.');
        }

        return $next($request);
    }
}
```

### 4.2. Registrasi Middleware di `bootstrap/app.php`

Dalam Laravel 12, middleware didaftarkan melalui closure `withMiddleware()`:

```php
use App\Http\Middleware\EnsureUserHasRole;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => EnsureUserHasRole::class,
        ]);
    })
    ->create();
```

### 4.3. Struktur Grup Rute Berbasis Peran (`routes/web.php`)

```php
use App\Http\Controllers\Nurse\NursingCareController;
use App\Http\Controllers\Nurse\VitalSignController;
use App\Http\Controllers\Patient\AppointmentController;
use App\Http\Controllers\Patient\PatientMedicalRecordController;

// 1. Kluster Rute Perawat (Nurse Cluster)
Route::middleware(['auth', 'verified', 'role:nurse'])->prefix('nurse')->name('nurse.')->group(function () {
    Route::get('/patients', [NursingCareController::class, 'index'])->name('patients.index');
    Route::post('/patients/{patient}/vitals', [VitalSignController::class, 'store'])->name('vitals.store');
    Route::post('/patients/{patient}/medications/administer', [NursingCareController::class, 'administerMedication'])->name('meds.administer');
    Route::post('/shift-handover', [NursingCareController::class, 'storeHandover'])->name('handover.store');
});

// 2. Kluster Rute Pasien (Patient Portal)
Route::middleware(['auth', 'verified', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/records', [PatientMedicalRecordController::class, 'index'])->name('records.index');
    Route::get('/records/{record}', [PatientMedicalRecordController::class, 'show'])->name('records.show');
});

// 3. Kluster Rute Bersama Staf Medis (Nurse & Doctor)
Route::middleware(['auth', 'role:nurse,doctor'])->prefix('clinical')->name('clinical.')->group(function () {
    Route::get('/wards', [WardController::class, 'index'])->name('wards.index');
    Route::get('/triage', [TriageController::class, 'index'])->name('triage.index');
});
```

---

## 5. Integrasi Audit Trail untuk Regulasi Medis

Mengacu pada standar Rekam Medis Elektronik, setiap akses data medis kritis harus dicatat dalam audit trail. Middleware dapat memanfaatkan method `terminate()` untuk pencatatan asinkron tanpa membebani latensi respons pengguna:

```php
namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

final class AuditClinicalAccess
{
    public function handle(Request $request, \Closure $next): Response
    {
        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        if ($request->isMethodSafe()) {
            return;
        }

        Log::channel('clinical_audit')->info('Clinical Action Executed', [
            'user_id'    => $request->user()?->id,
            'role'       => $request->user()?->role?->value,
            'action'     => $request->route()?->getName(),
            'ip_address' => $request->ip(),
            'status'     => $response->getStatusCode(),
            'timestamp'  => now()->toISOString(),
        ]);
    }
}
```

---

## 6. Ringkasan Keselarasan Fitur

1. **Natural Identification**: Pasien dan Perawat tidak memilih peran manual di antarmuka login; peran terikat permanen pada akun di database dan diverifikasi saat `Auth::attempt()`.
2. **Zero Trust Boundary**: Rute dilindungi di lapisan perimeter oleh `EnsureUserHasRole` middleware, dan diproteksi di lapisan data oleh Laravel Policies.
3. **Penyajian UI Khusus Peran**: Dasbor secara otomatis menampilkan pintasan tugas klinis untuk Perawat dan layanan mandiri kesehatan untuk Pasien setelah login berhasil.
