# Product Requirement Document (PRD)
## Sistem Informasi Pelayanan Kesehatan Terpadu: Surgicon, Angsmart, ANSafe & Landing Page

| | |
|---|---|
| **Proyek** | Ekosistem Digital Pelayanan Bedah & Keperawatan (Surgicon, Angsmart, ANSafe) |
| **Status Dokumen** | Draft v3 — Komprehensif |
| **Tanggal** | 24 September 2026 |
| **Disusun untuk** | Tim Produk & Pengembang PK Kesehatan |

---

## Daftar Isi
1. Ringkasan Eksekutif
2. Latar Belakang & Tujuan
3. Ruang Lingkup Produk
4. Target Pengguna & Persona
5. Landing Page (Informasi Publik)
6. Spesifikasi Fitur Utama
   - 6.1 Surgicon
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

- **Surgicon** — manajemen alur bedah (Pre-OP, Intra-OP, Post-OP) beserta checklist keselamatan.
- **Angsmart** — asuhan keperawatan, diagnosa keperawatan, rencana keperawatan, dan handover antar shift.
- **ANSafe** — asesmen risiko jatuh pasien (Morse Fall Scale) dan pusat edukasi keselamatan pasien.

Ketiganya berbagi **satu Master Data Pasien** sehingga data mengalir dari proses pra-bedah hingga asuhan rawat inap tanpa input ulang. Selain tiga modul aplikasi, proyek ini juga mencakup **Landing Page** publik sebagai pintu masuk informasi rumah sakit/klinik dan katalog edukasi.

Tujuan akhir: mengurangi kesalahan prosedural, mempercepat serah terima (handover), dan memberi visibilitas real-time atas status pasien kepada seluruh tim medis.

---

## 2. Latar Belakang & Tujuan

### 2.1 Latar Belakang
Layanan kesehatan modern memerlukan integrasi data yang erat antara tahap pra-operasi, intra-operasi, pasca-operasi, asuhan keperawatan rawat inap, hingga manajemen risiko keselamatan pasien. Proses manual (kertas, spreadsheet terpisah) rentan terhadap duplikasi data, keterlambatan informasi saat pergantian shift, dan sulit diaudit.

### 2.2 Tujuan Produk
1. Digitalisasi alur pendaftaran, rekam ringkas tindakan bedah, asuhan keperawatan, dan penilaian risiko pasien.
2. Meminimalkan risiko kesalahan prosedur pembedahan melalui pemantauan Pre-OP dan Post-OP yang terpisah dan sekuensial.
3. Mempercepat dan menstandardisasi proses *handover* (operan jaga) antar perawat dengan ringkasan data otomatis.
4. Menyediakan pusat edukasi keselamatan pasien berbasis video yang mudah diakses pasien/keluarga.
5. Memberikan visibilitas lintas modul (dashboard) bagi kepala ruangan/manajemen untuk pengambilan keputusan cepat.

### 2.3 Masalah yang Dipecahkan
| Masalah Saat Ini | Dampak | Solusi dalam Produk |
|---|---|---|
| Checklist Pre-OP/Post-OP manual di kertas | Rawan hilang, sulit diaudit | Checklist digital per halaman, tersimpan sebagai log |
| Data pasien diinput ulang di tiap unit | Duplikasi, inkonsistensi | Master Data Pasien + Foreign Key otomatis |
| Handover lisan/tidak terdokumentasi | Informasi hilang antar shift | Fitur Handover dengan ringkasan otomatis + catatan terkunci |
| Asesmen risiko jatuh manual & subjektif | Skor tidak konsisten | Form MFS dengan kalkulasi skor otomatis & badge risiko |

---

## 3. Ruang Lingkup Produk

### 3.1 Dalam Lingkup (In-Scope)
- Landing page publik + katalog video edukasi.
- Modul Surgicon: dashboard, list pasien, Pre-OP checklist, Post-OP checklist.
- Modul Angsmart: dashboard, list pasien, asuhan keperawatan, handover, diagnosa keperawatan, rencana keperawatan.
- Modul ANSafe: dashboard, list pasien & asesmen MFS, education center.
- Sinkronisasi data pasien lintas modul (Foreign Key / Master Data).

### 3.2 Di Luar Lingkup (Out-of-Scope) — untuk fase ini
- Integrasi penuh dengan SIMRS/BPJS/klaim asuransi.
- Modul billing/keuangan.
- Aplikasi mobile native (versi awal berbasis web responsif).
- Rekam medis elektronik (RME) lengkap di luar cakupan tiga modul di atas.

> Catatan: item di luar lingkup dapat menjadi bahan diskusi roadmap Fase 2 (lihat Bab 15).

---

## 4. Target Pengguna & Persona

| Persona | Peran | Kebutuhan Utama |
|---|---|---|
| **Perawat Ruang OK (Bedah)** | Mengelola pasien di Surgicon | Input cepat, checklist jelas per fase, minim klik |
| **Perawat Ruangan (Rawat Inap)** | Mengelola asuhan & handover di Angsmart | Ringkasan pasien cepat, form asuhan mudah diisi tiap shift |
| **Perawat Penilai Risiko (ANSafe)** | Melakukan asesmen MFS berkala | Form skor otomatis, riwayat asesmen mudah dilihat |
| **Kepala Ruangan / Supervisor** | Memantau seluruh unit | Dashboard ringkas, indikator risiko & status real-time |
| **Pasien / Keluarga Pasien** | Mengakses edukasi | Video mudah dicari berdasarkan kategori |
| **Admin/IT Rumah Sakit** | Mengelola master data & hak akses | RBAC, audit log, kemudahan maintenance |

---

## 5. Landing Page (Informasi Publik)

### 5.1 Tujuan
Menjadi *hub* informasi publik yang memperkenalkan ekosistem aplikasi dan menyediakan akses edukasi bagi pasien/keluarga, sekaligus pintu masuk (login) bagi staf medis.

### 5.2 Struktur & Komponen
1. **Hero Section**
   - Headline: "Presisi, Keselamatan, dan Intelijen dalam Satu Ekosistem Medis."
   - Sub-headline: penjelasan singkat integrasi Surgicon, Angsmart, ANSafe.
   - CTA: "Masuk ke Aplikasi" / "Lihat Edukasi Keselamatan".
2. **Profil Pusat Kesehatan** — visi, misi, sejarah singkat, fasilitas penunjang.
3. **Tiga Pilar Utama (Card Fitur)**
   - Card Surgicon — ringkasan fungsi manajemen bedah.
   - Card Angsmart — ringkasan fungsi asuhan keperawatan & handover.
   - Card ANSafe — ringkasan fungsi asesmen risiko jatuh.
4. **Dokter & Tenaga Medis** — daftar dokter spesialis, jadwal praktik.
5. **Education Hub (Publik)** — katalog video edukasi keselamatan (sinkron dengan Education Center ANSafe), difilter 4 kategori: Semua, Pasien, Keluarga, Tips Keselamatan.
6. **Testimoni & Mitra** — ulasan dan kerja sama.
7. **Footer** — kontak, alamat, tautan login staf, media sosial.

### 5.3 Kebutuhan Fungsional Landing Page
- Responsif (desktop, tablet, mobile).
- Video edukasi dapat diputar langsung (embedded player) tanpa perlu login.
- Tombol login terpisah untuk staf (mengarah ke portal Surgicon/Angsmart/ANSafe sesuai hak akses).

---

## 6. Spesifikasi Fitur Utama

### 6.1 Modul Surgicon (Manajemen Pelayanan Bedah)

| ID | Fitur | Elemen UI | Deskripsi & Logika Bisnis | Acceptance Criteria |
|---|---|---|---|---|
| SURG-01 | Dashboard | Stat cards, tabel list pasien | Cards: Total Pasien, Pre-OP, Sedang OP, Post-OP. Tabel: Nama, No. RM, Jenis Tindakan, Fase OP | Angka pada card selalu sinkron real-time dengan status fase pasien |
| SURG-02 | List Pasien | Tabel data, modal tambah pasien | Kolom: Nama, Umur, No. RM, Jenis Tindakan, Diagnosa, Fase OP, Aksi. Tambah pasien otomatis membuat record Foreign Key di tabel `asuhan_keperawatan` | Setelah simpan, record baru muncul di Angsmart tanpa input ulang |
| SURG-03 | Pre-OP Checklist *(halaman terpisah)* | Tabel pasien Pre-OP, form checklist | Verifikasi pra-bedah: identitas, puasa, tanda vital, persetujuan tindakan, marka lokasi operasi, kesiapan alat | Semua item tercentang sebelum status pasien dapat berubah ke "Sedang OP" |
| SURG-04 | Post-OP Checklist *(halaman terpisah)* | Tabel pasien Post-OP, form checklist | Verifikasi pasca-bedah: kondisi recovery room, instruksi pasca-operasi, kelengkapan spesimen, kondisi pasca-anestesi | Checklist harus lengkap sebelum pasien dapat dipindah ke ruang rawat inap |

### 6.2 Modul Angsmart (Asuhan & Handover Keperawatan)

| ID | Fitur | Elemen UI | Deskripsi & Logika Bisnis | Acceptance Criteria |
|---|---|---|---|---|
| ANG-01 | Dashboard | Stat cards, pie chart, tabel | Cards: Total Pasien, Dalam Asuhan, Menunggu Tindakan, Perlu Handover. Pie chart: distribusi status asuhan. Tabel: Nama, No. RM, Kamar/Bed | Pie chart otomatis update saat status asuhan berubah |
| ANG-02 | List Pasien | Tabel ringkas | Kolom: Nama, Umur, No. RM, Bed, Diagnosa, Jenis Tindakan, Status Asuhan, Aksi (Update) | Data pasien identik dengan Master Data (read-only untuk identitas dasar) |
| ANG-03 | Asuhan Keperawatan | Tabel asuhan | Kolom: Nama, Daftar Tindakan, Shift, Tanggal Update, Catatan Pasien, Aksi | Setiap update tersimpan dengan timestamp & nama perawat pengisi |
| ANG-04 | Fitur Handover | Select pasien, ringkasan dinamis, form catatan | Memilih pasien menampilkan agregasi data Pasien + Asuhan Keperawatan + kolom catatan tambahan handover | Tersedia tombol "Kunci/Finalisasi Handover" — setelah terkunci data menjadi log riwayat (read-only, teraudit) |
| ANG-05 | Diagnosa Keperawatan | Tabel master diagnosa | Kolom: Diagnosa, Tujuan, Intervensi, Aksi (CRUD) — sebagai pustaka referensi | Dipakai sebagai dropdown pencarian di fitur Rencana Keperawatan |
| ANG-06 | Rencana Keperawatan | Tabel rencana | Kolom: Nama Pasien, Diagnosa Perawat, Status, Tanggal Update, Aksi | Memilih diagnosa dari master (ANG-05) otomatis mengisi Tujuan & Intervensi |

### 6.3 Modul ANSafe (Asesmen Keselamatan & Risiko Jatuh)

| ID | Fitur | Elemen UI | Deskripsi & Logika Bisnis | Acceptance Criteria |
|---|---|---|---|---|
| ANS-01 | Dashboard | Stat cards, tabel monitoring | Cards: Total Pasien, Risiko Rendah, Sedang, Tinggi. Tabel: Nama, No. RM, Bed, Tingkat Risiko, Asesmen Terakhir (tanggal & waktu) | Badge warna risiko konsisten di seluruh modul (merah/kuning/hijau) |
| ANS-02 | List Pasien & Asesmen MFS | Tabel pasien, form radio button MFS | Form Morse Fall Scale via select pasien → radio button per indikator → skor dijumlahkan otomatis | Skor 0–24 = Rendah, 25–44 = Sedang, ≥45 = Tinggi (dihitung otomatis, tidak bisa diedit manual) |
| ANS-03 | Education Center | Filter kategori, grid video | 4 kategori: Semua, Pasien, Keluarga, Tips Keselamatan | Filter berfungsi tanpa reload halaman penuh |

---

## 7. Hak Akses Pengguna (RBAC)

| Peran | Surgicon | Angsmart | ANSafe | Landing Page (Admin) |
|---|---|---|---|---|
| Perawat OK/Bedah | Full akses (CRUD pasien, checklist) | Lihat saja | Lihat saja | — |
| Perawat Ruangan | Lihat saja | Full akses (asuhan, handover, rencana) | Lihat & isi asesmen | — |
| Kepala Ruangan | Lihat semua dashboard | Lihat semua dashboard | Lihat semua dashboard | Lihat laporan |
| Admin/IT | Kelola user & master data | Kelola user & master data | Kelola user & master data | Full akses |
| Pasien/Keluarga | — | — | Education Center (publik) | Lihat konten publik |

> Rekomendasi: gunakan satu sistem SSO/login terpadu agar staf tidak perlu login berulang ke tiap modul.

---

## 8. Alur Pengguna (User Flow)

### 8.1 Flow Global
```
[ Landing Page ] → [ Login Staf ] → [ Dashboard Utama ]
                                          │
        ┌─────────────────────────────────┼─────────────────────────────────┐
        ▼                                 ▼                                 ▼
  [ SURGICON ]                     [ ANGSMART ]                       [ ANSAFE ]
```

### 8.2 Flow Surgicon
```
Dashboard Surgicon
  └─ List Pasien
       └─ Tambah Pasien → (auto-create FK ke Asuhan Keperawatan)
  └─ Halaman Pre-OP Checklist (terpisah)
       └─ Pilih pasien → centang tahapan persiapan bedah
  └─ Halaman Post-OP Checklist (terpisah)
       └─ Pilih pasien → centang tahapan pemulihan pasca-bedah
```

### 8.3 Flow Angsmart
```
Dashboard Angsmart
  └─ List Pasien → update status asuhan
  └─ Asuhan Keperawatan → isi tindakan, shift, catatan
  └─ Diagnosa Keperawatan → kelola master (CRUD)
  └─ Rencana Keperawatan → pilih diagnosa dari master → auto-isi tujuan/intervensi
  └─ Handover
       └─ Pilih pasien (select box)
       └─ Sistem tampilkan ringkasan gabungan (Pasien + Asuhan)
       └─ Isi catatan tambahan → Kunci/Finalisasi → tersimpan sebagai log
```

### 8.4 Flow ANSafe
```
Dashboard ANSafe
  └─ List Pasien & Asesmen
       └─ Pilih pasien → isi form MFS (radio button)
       └─ Sistem hitung skor otomatis → tentukan kategori risiko
       └─ Badge & dashboard ter-update otomatis
  └─ Education Center
       └─ Filter kategori (Semua/Pasien/Keluarga/Tips Keselamatan)
       └─ Putar video edukasi
```

---

## 9. Skema Data & Relasi Antar Modul (Konsep ERD)

### 9.1 Entitas Utama
- **Pasien** *(Master Data)* — id, nama, umur, no. RM, kamar/bed, diagnosa, jenis tindakan.
- **Asuhan Keperawatan** — pasien_id (FK), daftar tindakan, shift, tanggal update, catatan.
- **Handover Log** — pasien_id (FK), ringkasan gabungan, catatan shift, status kunci, timestamp, perawat pengisi.
- **Diagnosa Keperawatan (Master)** — id, diagnosa, tujuan, intervensi.
- **Rencana Keperawatan** — pasien_id (FK), diagnosa_id (FK ke master), status, tanggal update.
- **Checklist Pre-OP / Post-OP** — pasien_id (FK), daftar item checklist, status per item, timestamp.
- **Asesmen MFS** — pasien_id (FK), jawaban per indikator, skor total, kategori risiko, timestamp, perawat penilai.
- **Video Edukasi** — id, judul, kategori, url/embed, durasi.

### 9.2 Relasi Kunci
- `Pasien (1) — (N) Asuhan Keperawatan` (dibuat otomatis saat pasien ditambahkan di Surgicon).
- `Pasien (1) — (N) Checklist Pre-OP/Post-OP`.
- `Pasien (1) — (N) Asesmen MFS` (riwayat asesmen dari waktu ke waktu, bukan overwrite).
- `Diagnosa Keperawatan (1) — (N) Rencana Keperawatan`.
- `Pasien + Asuhan Keperawatan → Handover Log` (agregasi, bukan tabel FK langsung, tapi query gabungan saat handover dibuat).

> Rekomendasi teknis: gunakan `pasien_id` sebagai kunci federasi tunggal di seluruh modul agar tidak terjadi data pasien ganda antar Surgicon/Angsmart/ANSafe.

---

## 10. Kebutuhan Non-Fungsional

| Kategori | Kebutuhan |
|---|---|
| **Keamanan Data** | Data pasien adalah data sensitif — wajib enkripsi at-rest & in-transit, mematuhi regulasi perlindungan data pribadi yang berlaku (mis. UU PDP) |
| **Audit Trail** | Setiap perubahan checklist, asesmen MFS, dan handover harus tercatat (siapa, kapan, apa yang diubah) dan tidak dapat dihapus |
| **Performa** | Dashboard harus memuat data dalam <2 detik untuk hingga ~500 pasien aktif |
| **Ketersediaan** | Target uptime 99.5% mengingat penggunaan di lingkungan klinis 24/7 |
| **Kompatibilitas** | Responsif di desktop (nurse station) dan tablet (mobile bedside) |
| **Skalabilitas** | Struktur data mendukung penambahan modul/rumah sakit baru tanpa migrasi besar |
| **Aksesibilitas** | Kontras warna badge risiko harus tetap terbaca (color-blind friendly, gunakan ikon + warna) |

---

## 11. Catatan Logika & Arsitektur Teknis

1. **Pemisahan Pre-OP & Post-OP Checklist**
   Dipisah menjadi dua halaman agar validasi tahap operasi berjalan sekuensial dan mengurangi kebingungan petugas di lapangan. Status pasien tidak bisa "lompat fase" tanpa checklist fase sebelumnya lengkap.

2. **Sinkronisasi Data Pasien Bedah & Keperawatan**
   Saat pasien baru ditambahkan di Surgicon, sistem otomatis membuat record kosong di `asuhan_keperawatan` via `pasien_id` (Foreign Key), menjamin *continuity of care* tanpa input ulang identitas.

3. **Sinkronisasi Skor MFS ke Modul Lain**
   Skor & kategori risiko dari ANSafe sebaiknya tampil sebagai badge di list pasien Angsmart dan Surgicon, agar tim medis selalu waspada terhadap pasien berisiko tinggi meski sedang bekerja di modul lain.

4. **Mekanisme Kunci Handover**
   Setelah "Kunci/Finalisasi Handover" ditekan, data menjadi read-only dan tersimpan sebagai log riwayat beraudit — mencegah manipulasi laporan shift setelah serah terima selesai.

5. **Perhitungan Otomatis MFS**
   Setiap radio button memiliki bobot skor. Total dihitung real-time di sisi client sebelum submit ke server, lalu divalidasi ulang di server-side untuk mencegah manipulasi skor dari front-end:
   - Skor 0–24 → Risiko Rendah
   - Skor 25–44 → Risiko Sedang
   - Skor ≥45 → Risiko Tinggi

6. **Master Diagnosa Keperawatan sebagai Pustaka**
   Fitur Rencana Keperawatan memanfaatkan dropdown/search dari master Diagnosa Keperawatan (Angsmart) untuk auto-isi Tujuan & Intervensi, mempercepat input data harian.

---

## 12. Metrik Keberhasilan (KPI)

| Metrik | Target Awal |
|---|---|
| Waktu rata-rata pengisian checklist Pre-OP | < 3 menit per pasien |
| Waktu proses handover per pasien | < 5 menit |
| Kepatuhan pengisian asesmen MFS (setiap shift) | > 95% pasien rawat inap ter-asesmen |
| Insiden pasien jatuh pasca-implementasi | Turun dibanding baseline sebelum sistem |
| Adopsi Education Center oleh pasien/keluarga | > 50% pasien risiko sedang-tinggi mengakses video edukasi |

---

## 13. Asumsi & Batasan

**Asumsi:**
- Setiap pasien hanya memiliki satu identitas aktif (no. RM unik) di Master Data.
- Perawat memiliki perangkat (komputer/tablet) di titik layanan (point of care).
- Koneksi internet/intranet rumah sakit stabil di seluruh unit terkait.

**Batasan:**
- Fase awal belum terintegrasi dengan SIMRS/BPJS.
- Video edukasi di-host di platform pihak ketiga (bukan self-hosted) pada fase MVP.

---

## 14. Risiko & Mitigasi

| Risiko | Dampak | Mitigasi |
|---|---|---|
| Duplikasi input pasien di lebih dari satu modul | Data pasien tidak konsisten | Terapkan Master Data terpusat + validasi no. RM unik |
| Petugas lupa mengunci handover | Data bisa berubah setelah shift selesai | Reminder otomatis / auto-lock setelah jangka waktu tertentu |
| Skor MFS dimanipulasi dari sisi client | Kategori risiko salah, membahayakan pasien | Validasi ulang perhitungan skor di server-side |
| Resistensi perubahan dari staf (masih terbiasa manual) | Adopsi rendah | Pelatihan bertahap + UI yang meniru alur kerja existing |

---

## 15. Roadmap Pengembangan

### Fase 1 — MVP (Prioritas Tinggi)
- Landing page dasar + Education Hub.
- Surgicon: Dashboard, List Pasien, Pre-OP & Post-OP Checklist.
- Angsmart: Dashboard, List Pasien, Asuhan Keperawatan, Handover.
- ANSafe: Dashboard, List Pasien & Asesmen MFS.
- Master Data Pasien terpusat + sinkronisasi Foreign Key.

### Fase 2 — Penyempurnaan
- Angsmart: Diagnosa Keperawatan (master) & Rencana Keperawatan.
- ANSafe: Education Center dengan filter kategori penuh.
- RBAC granular + audit log lengkap.
- Notifikasi/reminder (mis. checklist belum lengkap, handover belum dikunci).

### Fase 3 — Integrasi Lanjutan
- Integrasi SIMRS/BPJS.
- Aplikasi mobile native.
- Analitik lanjutan (tren risiko jatuh, waktu tunggu OP, dsb).

---

## 16. Glosarium

| Istilah | Penjelasan |
|---|---|
| **Pre-OP** | Fase sebelum tindakan operasi (persiapan) |
| **Post-OP** | Fase setelah tindakan operasi (pemulihan) |
| **MFS (Morse Fall Scale)** | Instrumen standar untuk menilai risiko jatuh pasien |
| **Handover** | Proses serah terima informasi pasien antar shift perawat |
| **Foreign Key (FK)** | Relasi basis data yang menghubungkan record antar tabel |
| **RBAC** | Role-Based Access Control, pengaturan hak akses berdasarkan peran pengguna |

---

## 17. Lampiran

- Lampiran A: Referensi tangkapan layar (snapshot) aplikasi existing dari folder *PK Kesehatan* (Surgicon, Angsmart, ANSafe) — untuk dijadikan acuan wireframe/UI.
- Lampiran B: Rencana pengembangan lanjutan — Desain ERD detail, Wireframe/High-Fidelity UI, penetapan RBAC final.

---

*Dokumen ini merupakan hasil konsolidasi dan penyempurnaan dari diskusi PRD sebelumnya, dengan penambahan bab Persona, RBAC, Skema Data, Kebutuhan Non-Fungsional, KPI, Risiko, dan Roadmap agar lebih komprehensif dan siap dipakai sebagai acuan pengembangan.*
