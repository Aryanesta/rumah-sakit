# Product Requirement Document (PRD)
## Sistem Informasi Pelayanan Kesehatan Terpadu: Surgicon, Angsmart, ANSafe & Landing Page

| | |
|---|---|
| **Proyek** | Ekosistem Digital Pelayanan Bedah & Keperawatan (Surgicon, Angsmart, ANSafe) |
| **Status Dokumen** | Draft v4 — Terintegrasi Fitur Pasien & Monitoring Surgicon |
| **Tanggal** | 25 September 2026 |
| **Disusun untuk** | Tim Produk & Pengembang PK Kesehatan |

---

## Daftar Isi
1. Ringkasan Eksekutif
2. Latar Belakang & Tujuan
3. Ruang Lingkup Produk
4. Target Pengguna & Persona
5. Landing Page (Informasi Publik)
6. Spesifikasi Fitur Utama
   - 6.1 Surgicon (Perawat & Pasien)
   - 6.2 Angsmart
   - 6.3 ANSafe
7. Hak Akses Pengguna (RBAC)
8. Alur Pengguna (User Flow)
9. Skema Data & Relasi Antar Modul (Konsep ERD)
10. Kebutuhan Non-Fungsional
11. Catatan Logika & Arsitektur Teknis
12. Metrik Keberhasilan (KPI)
13. Asumsi & Batasan
14. Risiko & Mitigasi
15. Roadmap Pengembangan (MVP → Fase Lanjutan)
16. Glosarium
17. Lampiran

---

## 1. Ringkasan Eksekutif

Dokumen ini menjabarkan kebutuhan produk untuk tiga aplikasi yang saling terintegrasi di lingkungan pelayanan kesehatan:

- **Surgicon** — manajemen alur bedah (Pre-OP, Intra-OP, Post-OP) yang mendukung 2 aktor utama: **Perawat** (Beranda, List Pasien, Verifikasi Pre-OP, Verifikasi Post-OP, Monitoring Akun Pasien) dan **Pasien** (Persiapan Sebelum Operasi & Persiapan Pasca Operasi berbasis Guide dan Checklist Membaca).
- **Angsmart** — asuhan keperawatan, diagnosa keperawatan, rencana keperawatan, dan handover antar shift.
- **ANSafe** — asesmen risiko jatuh pasien (Morse Fall Scale) dan pusat edukasi keselamatan pasien.

Ketiganya berbagi **satu Master Data Pasien** sehingga data mengalir dari proses pra-bedah hingga asuhan rawat inap tanpa input ulang. Selain tiga modul aplikasi, proyek ini juga mencakup **Landing Page** publik sebagai pintu masuk informasi rumah sakit/klinik dan katalog edukasi.

Tujuan akhir: mengurangi kesalahan prosedural, meningkatkan edukasi dan keterlibatan pasien secara mandiri, mempercepat serah terima (handover), dan memberi visibilitas real-time atas status pasien kepada seluruh tim medis.

---

## 2. Latar Belakang & Tujuan

### 2.1 Latar Belakang
Layanan kesehatan modern memerlukan integrasi data yang erat antara tahap pra-operasi, intra-operasi, pasca-operasi, asuhan keperawatan rawat inap, hingga manajemen risiko keselamatan pasien. Proses manual (kertas, spreadsheet terpisah) rentan terhadap duplikasi data, keterlambatan informasi saat pergantian shift, dan kurangnya pemahaman pasien atas prosedur pra dan pasca operasi.

### 2.2 Tujuan Produk
1. Digitalisasi alur pendaftaran, rekam ringkas tindakan bedah, asuhan keperawatan, dan penilaian risiko pasien.
2. Meminimalkan risiko kesalahan prosedur pembedahan melalui pemantauan Pre-OP dan Post-OP yang terpisah dan sekuensial.
3. Memfasilitasi edukasi pra dan pasca bedah secara mandiri oleh pasien melalui panduan (*guide*) dan penandaan konfirmasi baca (*checklist*).
4. Menyediakan fitur *Monitoring Akun Pasien* bagi perawat untuk memantau keterbacaan panduan oleh pasien secara real-time.
5. Mempercepat dan menstandardisasi proses *handover* (operan jaga) antar perawat dengan ringkasan data otomatis.
6. Menyediakan pusat edukasi keselamatan pasien berbasis video yang mudah diakses pasien/keluarga.

### 2.3 Masalah yang Dipecahkan
| Masalah Saat Ini | Dampak | Solusi dalam Produk |
|---|---|---|
| Checklist Pre-OP/Post-OP manual di kertas | Rawan hilang, sulit diaudit | Checklist digital per halaman untuk perawat & log keterbacaan pasien |
| Pasien kurang paham persiapan/pemulihan bedah | Komplikasi, risiko penundaan operasi | Modul Pasien berisi Guide & Checklist konfirmasi membaca |
| Perawat tidak tahu pasien sudah baca panduan atau belum | Harus konfirmasi berulang kali secara lisan | Fitur *Monitoring Akun Pasien* dengan status real-time & indikator peringatan |
| Data pasien diinput ulang di tiap unit | Duplikasi, inkonsistensi | Master Data Pasien + Foreign Key otomatis |
| Handover lisan/tidak terdokumentasi | Informasi hilang antar shift | Fitur Handover dengan ringkasan otomatis + catatan terkunci |
| Asesmen risiko jatuh manual & subjektif | Skor tidak konsisten | Form MFS dengan kalkulasi skor otomatis & badge risiko |

---

## 3. Ruang Lingkup Produk

### 3.1 Dalam Lingkup (In-Scope)
- Landing page publik + katalog video edukasi.
- **Modul Surgicon (2 Aktor)**:
  - *Aktor Pasien*: Portal akses panduan & checklist persiapan sebelum operasi (Pre-OP) dan pasca operasi (Post-OP).
  - *Aktor Perawat*: Beranda (Dashboard), List Pasien, Verifikasi Sebelum Operasi (Pre-OP Checklist), Verifikasi Pasca Bedah (Post-OP Checklist), dan Monitoring Akun Pasien.
- **Modul Angsmart**: dashboard, list pasien, asuhan keperawatan, handover, diagnosa keperawatan, rencana keperawatan.
- **Modul ANSafe**: dashboard, list pasien & asesmen MFS, education center.
- **Sinkronisasi Data**: Master Data Pasien terpusat yang terhubung lintas modul.

### 3.2 Di Luar Lingkup (Out-of-Scope) — untuk fase ini
- Integrasi penuh dengan SIMRS/BPJS/klaim asuransi.
- Modul billing/keuangan.
- Aplikasi mobile native (versi awal berbasis web responsif).
- Rekam medis elektronik (RME) lengkap di luar cakupan tiga modul di atas.

---

## 4. Target Pengguna & Persona

| Persona | Peran | Kebutuhan Utama |
|---|---|---|
| **Perawat Ruang OK (Surgicon Nurse)** | Mengelola verifikasi bedah & memantau akun pasien | Verifikasi cepat Pre-OP/Post-OP, memantau status checklist guide pasien secara real-time |
| **Pasien Bedah (Surgicon Patient)** | Mengakses edukasi pra & pasca operasi mandiri | Antarmuka intuitif untuk membaca panduan operasi dan men-checklist konfirmasi membaca |
| **Perawat Ruangan (Rawat Inap)** | Mengelola asuhan & handover di Angsmart | Ringkasan pasien cepat, form asuhan mudah diisi tiap shift |
| **Perawat Penilai Risiko (ANSafe)** | Melakukan asesmen MFS berkala | Form skor otomatis, riwayat asesmen mudah dilihat |
| **Kepala Ruangan / Supervisor** | Memantau seluruh unit | Dashboard ringkas, indikator risiko & status real-time |
| **Admin/IT Rumah Sakit** | Mengelola master data & hak akses | RBAC, audit log, kemudahan maintenance |

---

## 5. Landing Page (Informasi Publik)

### 5.1 Tujuan
Menjadi *hub* informasi publik yang memperkenalkan ekosistem aplikasi dan menyediakan akses edukasi bagi pasien/keluarga, sekaligus pintu masuk (*login*) bagi staf medis maupun akses mandiri pasien.

### 5.2 Struktur & Komponen
1. **Hero Section**
   - Headline: "Presisi, Keselamatan, dan Intelijen dalam Satu Ekosistem Medis."
   - Sub-headline: penjelasan singkat integrasi Surgicon, Angsmart, ANSafe.
   - CTA: "Masuk Staf Medis" / "Portal Pasien" / "Lihat Edukasi Keselamatan".
2. **Profil Pusat Kesehatan** — visi, misi, sejarah singkat, fasilitas penunjang.
3. **Tiga Pilar Utama (Card Fitur)**
   - Card Surgicon — ringkasan fungsi manajemen bedah & edukasi pasien.
   - Card Angsmart — ringkasan fungsi asuhan keperawatan & handover.
   - Card ANSafe — ringkasan fungsi asesmen risiko jatuh.
4. **Dokter & Tenaga Medis** — daftar dokter spesialis, jadwal praktik.
5. **Education Hub (Publik)** — katalog video edukasi keselamatan, difilter 4 kategori: Semua, Pasien, Keluarga, Tips Keselamatan.
6. **Testimoni & Mitra** — ulasan dan kerja sama.
7. **Footer** — kontak, alamat, tautan login, media sosial.

---

## 6. Spesifikasi Fitur Utama

### 6.1 Modul Surgicon (Manajemen Pelayanan Bedah & Edukasi Pasien)

Modul Surgicon dirancang untuk 2 aktor utama, yaitu **Perawat** dan **Pasien**.

#### A. Aktor Perawat
| ID | Fitur | Elemen UI | Deskripsi & Logika Bisnis | Acceptance Criteria |
|---|---|---|---|---|
| SURG-01 | Beranda (Dashboard) | Stat cards, tabel ringkasan | Cards: Total Pasien, Pre-OP, Sedang OP, Post-OP, Pasien Sudah Baca Guide. Ringkasan status keterbacaan guide pasien. | Angka pada card sinkron real-time dengan status fase pasien & aktivitas pasien. |
| SURG-02 | List Pasien | Tabel data, modal tambah pasien | Kolom: Nama, Umur, No. RM, Jenis Tindakan, Diagnosa, Fase OP, Status Guide Pasien, Aksi. Tambah pasien otomatis membuat record FK di `asuhan_keperawatan`. | Data tersimpan & terhubung ke modul Angsmart serta membuat kredensial portal pasien. |
| SURG-03 | Verifikasi Sebelum Operasi (Pre-OP Checklist) | Tabel pasien Pre-OP, form verifikasi perawat | Verifikasi medis pra-bedah oleh perawat: identitas, puasa, tanda vital, persetujuan tindakan, marka lokasi operasi, kesiapan alat. | Semua item verifikasi terisi sebelum status berubah ke "Sedang OP". |
| SURG-04 | Verifikasi Pasca Bedah (Post-OP Checklist) | Tabel pasien Post-OP, form verifikasi perawat | Verifikasi medis pasca-bedah oleh perawat: kondisi recovery room, instruksi pasca-operasi, kelengkapan spesimen, kondisi pasca-anestesi. | Checklist lengkap sebelum pasien dipindah ke ruang rawat inap. |
| SURG-05 | Monitoring Akun Pasien | Tabel pemantauan status guide | Memantau seluruh akun pasien yang telah/belum men-checklist guide. Kolom: Nama, No. RM, Status Guide Pre-OP (Sudah/Belum + Tanggal/Waktu), Status Guide Post-OP (Sudah/Belum + Tanggal/Waktu), Badge Peringatan. | Tampilan pemantauan terbarui otomatis ketika pasien men-checklist guide. Menampilkan indikator jika guide belum dibaca mendekati jam operasi. |

#### B. Aktor Pasien
| ID | Fitur | Elemen UI | Deskripsi & Logika Bisnis | Acceptance Criteria |
|---|---|---|---|---|
| SURG-P01 | Persiapan Sebelum Operasi (Pre-OP Guide & Checklist) | Tampilan artikel/guide persiapan, Checkbox konfirmasi | Berisi panduan persiapan sebelum operasi (persyaratan puasa, kebersihan, dokumen). Pasien men-checklist konfirmasi *"Saya telah membaca dan memahami panduan ini"*. | Checkbox mengirimkan log *timestamp* dan memperbarui status pada menu Monitoring Akun Pasien milik perawat. |
| SURG-P02 | Persiapan Pasca Operasi (Post-OP Guide & Checklist) | Tampilan artikel/guide pemulihan, Checkbox konfirmasi | Berisi panduan pemulihan pasca operasi (perawatan luka, aktivitas, manajemen nyeri). Pasien men-checklist konfirmasi membaca. | Checkbox mencatat *timestamp* dan memperbarui status pemantauan perawat. |

---

### 6.2 Modul Angsmart (Asuhan & Handover Keperawatan)

| ID | Fitur | Elemen UI | Deskripsi & Logika Bisnis | Acceptance Criteria |
|---|---|---|---|---|
| ANG-01 | Dashboard | Stat cards, pie chart, tabel | Cards: Total Pasien, Dalam Asuhan, Menunggu Tindakan, Perlu Handover. Pie chart: distribusi status asuhan. | Pie chart otomatis update saat status asuhan berubah. |
| ANG-02 | List Pasien | Tabel ringkas | Kolom: Nama, Umur, No. RM, Bed, Diagnosa, Jenis Tindakan, Status Asuhan, Aksi. | Data pasien read-only dari Master Data Pasien. |
| ANG-03 | Asuhan Keperawatan | Tabel asuhan | Kolom: Nama, Daftar Tindakan, Shift, Tanggal Update, Catatan Pasien, Aksi. | Tersimpan dengan timestamp & nama perawat pengisi. |
| ANG-04 | Fitur Handover | Select pasien, ringkasan dinamis, form catatan | Agregasi data Pasien + Asuhan Keperawatan + catatan tambahan handover. | Tombol "Kunci/Finalisasi Handover" mengubah data menjadi log riwayat read-only. |
| ANG-05 | Diagnosa Keperawatan | Tabel master diagnosa | CRUD Diagnosa, Tujuan, Intervensi sebagai pustaka referensi. | Digunakan sebagai pencarian di Rencana Keperawatan. |
| ANG-06 | Rencana Keperawatan | Tabel rencana | Memilih diagnosa master otomatis mengisi Tujuan & Intervensi. | Form terisi otomatis sesuai referensi master. |

---

### 6.3 Modul ANSafe (Asesmen Keselamatan & Risiko Jatuh)

| ID | Fitur | Elemen UI | Deskripsi & Logika Bisnis | Acceptance Criteria |
|---|---|---|---|---|
| ANS-01 | Dashboard | Stat cards, tabel monitoring | Cards: Total Pasien, Risiko Rendah, Sedang, Tinggi. Tabel data asesmen. | Badge warna risiko konsisten di seluruh modul. |
| ANS-02 | List Pasien & Asesmen MFS | Tabel pasien, form radio button MFS | Form Morse Fall Scale → kalkulasi skor otomatis. | Skor 0–24 = Rendah, 25–44 = Sedang, ≥45 = Tinggi. Dihitung otomatis. |
| ANS-03 | Education Center | Filter kategori, grid video | 4 kategori: Semua, Pasien, Keluarga, Tips Keselamatan. | Filter berfungsi tanpa reload halaman. |

---

## 7. Hak Akses Pengguna (RBAC)

| Peran | Surgicon | Angsmart | ANSafe | Landing Page (Admin) |
|---|---|---|---|---|
| **Perawat Surgicon** | Full Akses (Beranda, List Pasien, Verifikasi Pre-OP, Verifikasi Post-OP, Monitoring Akun Pasien) | Lihat saja | Lihat saja | — |
| **Pasien** | Akses Portal Pasien (Persiapan Pre-OP Guide & Checklist, Persiapan Post-OP Guide & Checklist) | — | — | Lihat konten publik |
| **Perawat Ruangan** | Lihat saja | Full akses (asuhan, handover, rencana) | Lihat & isi asesmen | — |
| **Kepala Ruangan** | Lihat semua dashboard | Lihat semua dashboard | Lihat semua dashboard | Lihat laporan |
| Admin/IT | Kelola user & master data | Kelola user & master data | Kelola user & master data | Full akses |

---

## 8. Alur Pengguna (User Flow)

### 8.1 Flow Surgicon - Perawat
```
[ Login Perawat ] → [ Beranda Surgicon ]
                         │
        ┌────────────────┼────────────────┬────────────────┐
        ▼                ▼                ▼                ▼
  [ List Pasien ]  [ Verifikasi ]   [ Verifikasi ]   [ Monitoring ]
  (Tambah Pasien)    (Pre-OP)         (Post-OP)     (Akun Pasien)
```

### 8.2 Flow Surgicon - Pasien
```
[ Akses Portal Pasien ] (Login No. RM / Token)
         │
         ├─► [ Persiapan Sebelum Operasi ] ─► Baca Guide ─► Centang Checklist
         │                                                      │
         └─► [ Persiapan Pasca Operasi ]   ─► Baca Guide ─► Centang Checklist
                                                                │
                                                                ▼
                                                 (Kirim Log Real-Time ke Perawat)
```

### 8.3 Flow Angsmart & ANSafe
```
[ Login Staf ] ──► [ Dashboard Angsmart ] ──► Asuhan / Handover / Rencana
               └──► [ Dashboard ANSafe ]   ──► Asesmen MFS / Education Center
```

---

## 9. Skema Data & Relasi Antar Modul (Konsep ERD)

### 9.1 Entitas Utama
- **Pasien** *(Master Data)* — id, nama, umur, no_rm, kamar_bed, diagnosa, jenis_tindakan, kode_akses_pasien.
- **Patient_Guide_Log** *(Baru)* — id, pasien_id (FK), guide_type ('PRE_OP' / 'POST_OP'), is_read (Boolean), read_at (Timestamp).
- **Verifikasi_PreOP_Nurse** — id, pasien_id (FK), perawat_id (FK), items_checked (JSON), status, timestamp.
- **Verifikasi_PostOP_Nurse** — id, pasien_id (FK), perawat_id (FK), items_checked (JSON), status, timestamp.
- **Asuhan Keperawatan** — pasien_id (FK), daftar_tindakan, shift, tanggal_update, catatan.
- **Handover Log** — pasien_id (FK), ringkasan_gabungan, catatan_shift, status_kunci, timestamp, perawat_id.
- **Diagnosa Keperawatan (Master)** — id, diagnosa, tujuan, intervensi.
- **Rencana Keperawatan** — pasien_id (FK), diagnosa_id (FK), status, tanggal_update.
- **Asesmen MFS** — pasien_id (FK), jawaban_indikator (JSON), skor_total, kategori_risiko, timestamp.
- **Video Edukasi** — id, judul, kategori, url_embed, durasi.

### 9.2 Relasi Kunci
- `Pasien (1) — (N) Patient_Guide_Log` (Mencatat konfirmasi pembacaan panduan pra dan pasca operasi oleh pasien).
- `Pasien (1) — (N) Verifikasi_PreOP_Nurse` & `Verifikasi_PostOP_Nurse`.
- `Pasien (1) — (N) Asuhan Keperawatan` (Otomatis terbuat saat pasien baru ditambahkan).
- `Pasien (1) — (N) Asesmen MFS`.

---

## 10. Kebutuhan Non-Fungsional

| Kategori | Kebutuhan |
|---|---|
| **Keamanan Data** | Enkripsi data sensitif (UU PDP). Otentikasi pasien menggunakan No. RM + Token / Tanggal Lahir. |
| **Audit Trail** | Setiap checklist perawat dan konfirmasi baca pasien tercatat dengan timestamp presisi & ID pengguna. |
| **Performa & Real-Time** | Monitoring Akun Pasien memperbarui status keterbacaan guide secara instan (< 2 detik) tanpa perlu reload halaman penuh. |
| **Kompatibilitas Tampilan** | Portal pasien sangat responsif untuk layar smartphone/tablet; portal perawat optimal untuk Nurse Station (desktop/tablet). |
| **Aksesibilitas Pasien** | Tampilan panduan pasien menggunakan font berukuran jelas, kontras memadai, dan petunjuk langkah demi langkah yang mudah dipahami orang awam. |

---

## 11. Catatan Logika & Arsitektur Teknis

1. **Logika Monitoring Keterbacaan Guide**:
   Ketika pasien mencentang checkbox *"Saya telah membaca dan memahami panduan ini"* pada modul Pre-OP atau Post-OP Guide, sistem akan menyimpan log ke tabel `Patient_Guide_Log`. Fitur *Monitoring Akun Pasien* di portal perawat menarik data log ini untuk menampilkan badge hijau "Sudah Dibaca" beserta jam & tanggalnya.

2. **Indikator Peringatan (Alert Badge)**:
   Jika status Pre-OP guide pasien masih "Belum Dibaca" saat jam tindakan operasi kurang dari 2 jam, tabel *Monitoring Akun Pasien* dan *Beranda Perawat* akan menampilkan badge peringatan berwarna kuning/merah.

3. **Pemisahan Verifikasi Perawat & Checklist Pasien**:
   - Checklist Pasien berfokus pada edukasi dan pemahaman mandiri.
   - Verifikasi Perawat (Pre-OP & Post-OP) berfokus pada persetujuan medis, pemeriksaan fisik, kesiapan alat, dan keselamatan klinis.

4. **Integrasi Master Data**:
   Penambahan pasien baru oleh perawat di Surgicon secara otomatis meregistrasikan ID pasien ke Master Data dan menyiapkan slot record di modul Angsmart dan ANSafe.

---

## 12. Metrik Keberhasilan (KPI)

| Metrik | Target Awal |
|---|---|
| Kepatuhan Pasien Membaca Pre-OP Guide | > 85% pasien men-checklist guide sebelum tindakan bedah |
| Respons Perawat terhadap Peringatan Pasien Belum Baca | < 15 menit setelah alert muncul di halaman Monitoring |
| Waktu Rata-rata Verifikasi Pre-OP/Post-OP Perawat | < 3 menit per pasien |
| Waktu Proses Handover Per Pasien | < 5 menit |
| Kepatuhan Pengisian Asesmen MFS | > 95% pasien rawat inap ter-asesmen tiap shift |

---

## 13. Asumsi & Batasan

**Asumsi:**
- Pasien/keluarga pasien memiliki perangkat smartphone/tablet untuk mengakses portal panduan pasien.
- Perawat memiliki akses komputer/tablet di titik layanan (nurse station / ruang pemulihan / OK).

**Batasan:**
- Otentikasi pasien versi MVP menggunakan kombinasi No. RM dan Tanggal Lahir / Token Akses Singkat tanpa pendaftaran akun rumit.
- Materi panduan (guide) disimpan dalam bentuk konten teks interaktif, gambar, atau video embedded.

---

## 14. Risiko & Mitigasi

| Risiko | Dampak | Mitigasi |
|---|---|---|
| Pasien tidak memiliki smartphone / tidak paham cara centang checklist | Status monitoring perawat tidak ter-update | Perawat dapat membantu memandu atau melakukan centang atas konfirmasi lisan pasien melalui modul perawat |
| Pasien langsung men-checklist tanpa benar-benar membaca | Pemahaman pasien kurang | Buat tampilan guide interaktif dengan poin-poin ringkas & beri jeda waktu sebelum tombol checklist aktif |
| Duplikasi data pasien antar modul | Data tidak konsisten | Validasi No. RM unik di seluruh ekosistem |

---

## 15. Roadmap Pengembangan

### Fase 1 — MVP (Prioritas Tinggi)
- Landing page + Login terpisah (Perawat/Staf & Akses Pasien).
- Surgicon:
  - Portal Perawat: Beranda, List Pasien, Verifikasi Pre-OP, Verifikasi Post-OP, Monitoring Akun Pasien.
  - Portal Pasien: Persiapan Pre-OP Guide & Checklist, Persiapan Post-OP Guide & Checklist.
- Angsmart: Dashboard, List Pasien, Asuhan Keperawatan, Handover.
- ANSafe: Dashboard, List Pasien & Asesmen MFS.
- Master Data Pasien terpusat.

### Fase 2 — Penyempurnaan
- Angsmart: Master Diagnosa Keperawatan & Rencana Keperawatan.
- ANSafe: Education Center penuh dengan filter video.
- Notifikasi terintegrasi (misal: pengingat otomatis ke perawat jika pasien belum membaca guide Pre-OP).

### Fase 3 — Integrasi Lanjutan
- Integrasi SIMRS / BPJS / RME.
- Aplikasi mobile native untuk pasien dan perawat.

---

## 16. Glosarium

| Istilah | Penjelasan |
|---|---|
| **Pre-OP Guide** | Panduan persiapan sebelum tindakan operasi khusus untuk pasien |
| **Post-OP Guide** | Panduan perawatan dan pemulihan pasca operasi khusus untuk pasien |
| **Verifikasi Pre-OP/Post-OP** | Form verifikasi medis yang diisi oleh perawat untuk memastikan keselamatan bedah |
| **Monitoring Akun Pasien** | Fitur perawat untuk memantau status keterbacaan panduan oleh pasien |
| **MFS (Morse Fall Scale)** | Skala penilaian standar risiko jatuh pasien |
| **Handover** | Serah terima tugas dan kondisi pasien antar shift perawat |

---

## 17. Lampiran

- Lampiran A: Referensi desain antarmuka Surgicon, Angsmart, dan ANSafe.
- Lampiran B: Draft materi edukasi Pre-OP dan Post-OP Guide untuk Pasien.

---

*Dokumen PRD ini telah disesuaikan secara menyeluruh dengan struktur 2 aktor pengguna pada Surgicon.*