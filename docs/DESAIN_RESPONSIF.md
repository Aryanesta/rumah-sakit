# Desain Responsif — RSUP Prof. dr. I.G.N.G. Ngoerah

Proyek: Platform web rumah sakit (landing publik, launcher staf, Surgicare, Angsmart, ANSafe)  
Stack: Laravel Blade, Tailwind CSS, Alpine.js jika dipakai  
Terkait: [`docs/PRD.md`](PRD.md) (NFR kompatibilitas), [`docs/COLOR_PALLETE.md`](COLOR_PALLETE.md) (token visual)

Dokumen ini menjelaskan **arti “responsif” di repositori ini**, **deliverable yang diharapkan**, **dukungan viewport**, serta **cara implementasi dan pengujian** layout. Melengkapi PRD; jika berbeda saat pengembangan aktif, utamakan PRD lalu perbarui file ini.

---

## 1. Tujuan dan cakupan

### 1.1 Tujuan produk (dari PRD)

| Permukaan | Harapan responsif |
|-----------|-------------------|
| **Landing publik** | Dapat dipakai di desktop, tablet, dan mobile; video edukasi dan CTA tanpa scroll horizontal |
| **Modul staf** (Surgicare, Angsmart, ANSafe) | Dioptimalkan untuk **desktop nurse station** dan **tablet di titik layanan / bedside** |
| **Di luar cakupan (v1)** | Aplikasi native iOS/Android — rilis awal berbasis **web responsif** |

### 1.2 Cakupan teknis

- **Satu dokumen HTML responsif per rute** — layout fluid, media query CSS (melalui breakpoint Tailwind), bukan situs mobile/desktop terpisah.
- **Meta viewport** wajib di semua layout (`width=device-width, initial-scale=1`). Sudah ada di `resources/views/layouts/*.blade.php`.
- **Jangan menonaktifkan zoom** (`maximum-scale=1`, `user-scalable=no`) kecuali review keamanan eksplisit mewajibkan; zoom adalah kebutuhan aksesibilitas.

---

## 2. Prinsip

1. **Mobile-first** — Gaya default untuk lebar viewport terkecil. Tambah kompleksitas dengan `sm:`, `md:`, `lg:`, bukan sebaliknya.
2. **Breakpoint berdasarkan konten** — Breakpoint ditempatkan saat **layout atau keterbacaan rusak** (panjang baris, tabel terjepit, label tumpang tindih), bukan daftar fixed model ponsel. Lihat [MDN — Media queries](https://developer.mozilla.org/en-US/docs/Learn_web_development/Core/CSS_layout/Media_queries).
3. **Tugas sama, layout berbeda** — Pengguna harus menyelesaikan alur inti di tablet dan desktop; menyembunyikan aksi sekunder boleh, menyembunyikan tugas utama tidak.
4. **Token, bukan nilai acak** — Warna dan jarak mengikuti [`COLOR_PALLETE.md`](COLOR_PALLETE.md) dan skala Tailwind; hindari hex atau spacing piksel ad hoc di view.
5. **Konteks klinis** — Asumsikan sarung tangan, tap cepat, dan gangguan; utamakan target sentuh besar dan hierarki jelas di tablet.

---

## 3. Viewport yang didukung (bukan katalog perangkat)

Platform web mendukung **lebar viewport CSS**, bukan SKU handset individual. Tidak ada daftar resmi “setiap ponsel yang didukung”; QA memakai **rentang lebar** plus browser nyata.

### 3.1 Minimum dan maksimum

| Batasan | Nilai | Catatan |
|---------|-------|---------|
| **Lebar minimum** | **320px** | Tanpa scroll horizontal pada konten utama; alur kritis harus berfungsi |
| **Pita klinis utama** | **768px – 1280px** | Tablet portrait/landscape dan layar nurse station umum |
| **Desktop besar** | **1280px – 1920px+** | Dashboard multi-kolom; teks panjang dengan max-width wajar |

### 3.2 Checklist lebar QA (uji semua rute kritis)

Uji **tepat di**, **20px di bawah**, dan **20px di atas** setiap ambang perubahan layout ([Sizzy breakpoint checklist](https://sizzy.co/blog/responsive-breakpoint-checklist)).

| Lebar | Peran |
|-------|--------|
| 320px | Ponsel kecil umum |
| 375px | Referensi desain / ponsel |
| 768px | Tablet portrait; Tailwind `md` |
| 1024px | Tablet landscape / laptop; Tailwind `lg`; tablet bedside landscape |
| 1280px | Desktop; Tailwind `xl` |
| 1440px | Artboard desktop lebar |
| 1920px | Nurse station Full HD |

Verifikasi juga **portrait ↔ landscape** pada lebar tablet dan **zoom browser 200%** pada minimal satu dashboard dan satu layar form padat.

### 3.3 Browser (matriks minimum)

| Lingkungan | Browser |
|------------|---------|
| Desktop (nurse station) | **Chrome** atau **Edge** terbaru; **Firefox** untuk spot-check regresi |
| Tablet (bedside) | **Safari (iPadOS)** dan/atau **Chrome (tablet Android)** — sesuaikan perangkat pilot RS |
| Mobile (landing / login staf) | **iOS Safari**, **Android Chrome** |

---

## 4. Breakpoint di proyek ini

### 4.1 Default Tailwind (sumber kebenaran di kode)

`tailwind.config.js` **tidak** menimpa `theme.screens`. Gunakan prefiks berikut ([Tailwind — Responsive design](https://tailwindcss.com/docs/responsive-design)):

| Prefiks | Lebar min | Penggunaan tipikal di aplikasi ini |
|---------|-----------|-------------------------------------|
| *(tanpa prefiks)* | 0 | Ponsel: stack, nav collapsed, kartu satu kolom |
| `sm:` | 640px | Ponsel besar; grid kartu 2 kolom opsional |
| `md:` | 768px | Tablet: panel berdampingan, kolom sekunder tampil |
| `lg:` | 1024px | Chrome modul penuh, dashboard multi-kolom, tabel lebar |
| `xl:` | 1280px | Ruang horizontal ekstra; container max-width |
| `2xl:` | 1536px | Ultra-wide; cegah baris teks tanpa batas |

**Penting:** Utility tanpa prefiks berlaku untuk **semua** ukuran. `md:flex` berarti “dari 768px ke atas,” bukan “hanya di tablet.”

Untuk gaya hanya di rentang tertentu: gabungkan `md:` dengan `max-lg:` (lihat dokumentasi Tailwind).

### 4.2 Pemetaan handoff desain (Figma / spesifikasi)

Saat desainer mendokumentasikan artboard, selaraskan nama dengan Tailwind:

| Label desain | Lebar artboard disarankan | Jangkar Tailwind |
|--------------|---------------------------|------------------|
| Mobile | 375px (uji stres 320px) | Base + `sm:` jika perlu |
| Tablet | 768px | `md:` |
| Desktop | 1024px – 1280px | `lg:` / `xl:` |
| Wide | 1440px+ | `xl:` / `2xl:` + `max-w-*` pada konten |

Referensi opsional layout **pane** (list + detail): [Material Design 3 breakpoints](https://m3.material.io/foundations/layout/breakpoints) (compact &lt; 600, medium 600–839, expanded 840+).

### 4.3 Catatan layout per modul

| Modul | Prioritas layout |
|-------|------------------|
| **Landing** | Kejelasan marketing; hero dan education hub terbaca di mobile; login staf selalu terjangkau |
| **Launcher** | Grid kartu: 1 → 2 → 3+ kolom; `rs-launcher` / `rs-background` sesuai dokumen warna |
| **ANSafe / Angsmart / Surgicare** | UI padat data: tabel boleh scroll horizontal **di dalam** container sebelum seluruh halaman scroll horizontal; form dan badge risiko tetap terbaca di tablet |
| **Auth (guest)** | Satu kolom, panel tengah; keyboard tidak menutup tombol submit utama di mobile |

---

## 5. Deliverable

### 5.1 Deliverable desain (sebelum build atau perubahan UI besar)

- [ ] **Inventaris layar** — alur, state default dan edge (kosong, loading, error, akses ditolak).
- [ ] **Layout per breakpoint** untuk shell, navigasi, dashboard, minimal satu form kompleks dan satu tabel data — bukan desktop saja dengan catatan “buat responsif.”
- [ ] **Matriks perilaku breakpoint** — per lebar: kolom, aturan stack, region hidden/shown, perlakuan tabel vs kartu.
- [ ] **Skala spacing** — ritme 4/8px; dokumentasikan pengecualian.
- [ ] **Tipografi** — ukuran heading dan kepadatan tabel tablet vs desktop jika berbeda.
- [ ] **Spesifikasi interaksi** — pola nav mobile, modal/drawer, urutan fokus.
- [ ] **Target sentuh** — lihat §6.
- [ ] **Token** — petakan ke warna Tailwind `rs-*`; tanpa hex ad hoc di mockup tanpa nama token.

Inspirasi template: [Design-to-dev handoff checklist](https://www.desisle.com/resources/design-to-dev-handoff-checklist).

### 5.2 Deliverable engineering (implementasi)

- [ ] Layout memuat meta viewport (sudah standar di proyek).
- [ ] Kelas Tailwind mobile-first di Blade di bawah `resources/views/`.
- [ ] **Max-width** pada teks panjang (`max-w-prose` atau konvensi proyek) di layar besar.
- [ ] Gambar: ukuran wajar; hindari layout shift; pertahankan aspect ratio.
- [ ] **Tanpa scroll horizontal tingkat halaman** di 320px untuk konten utama (kecuali tabel lebar terembed jika didokumentasikan).
- [ ] Reuse shell layout yang ada (`layouts/ansafe.blade.php`, `angsmart.blade.php`, dll.) sebelum chrome baru.
- [ ] Feature test atau bukti QA manual untuk jalur kritis di 320, 768, dan 1024px saat perilaku berubah.

---

## 6. Sentuh, pointer, dan aksesibilitas

| Persyaratan | Target |
|-------------|--------|
| **Target tap minimum (disarankan)** | Area interaktif **44×44 px CSS** ([Apple Design Tips](https://developer.apple.com/design/tips/)) |
| **Minimum WCAG 2.2 (AA)** | **24×24 px CSS** untuk target pointer ([WCAG 2.5.8](https://www.w3.org/WAI/WCAG22/Understanding/target-size-minimum.html)) — anggap 44px sebagai default UX rumah sakit |
| **Jarak antar kontrol** | Cukup renggang agar tombol berdekatan tidak salah tap di tablet |
| **Warna** | Badge risiko dan status: ikon + warna ([PRD §10 aksesibilitas](PRD.md)); lihat [`COLOR_PALLETE.md`](COLOR_PALLETE.md) |
| **Zoom** | Layout tetap usable pada zoom 200% |
| **Fokus** | Ring fokus terlihat untuk navigasi keyboard (`focus:ring-*` dengan `rs-primary` jika sesuai) |

Gunakan `@media (hover: hover)` dan `pointer: fine` secukupnya untuk hover desktop tanpa merusak perangkat sentuh saja.

---

## 7. Pola umum (implementasi)

### 7.1 Navigasi

- **Compact:** hamburger atau menu terjangkau jempol; pengalih modul utama reachable dengan satu tangan di tablet.
- **Expanded (`lg:`+):** sidebar persisten atau top nav sesu layout modul; rute aktif jelas.

Reuse `resources/views/components/responsive-nav-link.blade.php` dan partial navigasi modul jika ada.

### 7.2 Grid dan kartu

```html
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
```

Sesuaikan jumlah kolom dengan konten layar, bukan nama perangkat.

### 7.3 Tabel di viewport sempit

Urutan pilihan:

1. Sembunyikan kolom non-esensial di `md:` / `lg:` dengan `hidden md:table-cell`.
2. Izinkan **scroll horizontal di dalam** `<div class="overflow-x-auto">` yang membungkus tabel.
3. Beralih ke **daftar kartu** hanya jika didesain dan dispesifikasi — jangan hilangkan kolom klinis diam-diam.

### 7.4 Modal dan drawer

- Hampir full-screen di mobile/tablet jika konten form padat.
- Pastikan tutup/submit di zona jempol dan tetap terlihat saat keyboard on-screen terbuka.

---

## 8. Definition of done (penerimaan)

Layar atau fitur **selesai responsif** jika:

1. User story utama berfungsi di **320px, 768px, dan 1024px** tanpa scroll horizontal tingkat halaman (kecuali container tabel yang didokumentasikan).
2. Layout sesuai matriks breakpoint yang disepakati atau deviasi intentional terdokumentasi.
3. Kontrol interaktif memenuhi panduan **target sentuh 44px** di rute tablet dan mobile.
4. Desain visual memakai **token `rs-*`** dan konvensi layout modul.
5. Perubahan orientasi di tablet tidak kehilangan konteks (posisi scroll atau pasien/tab terpilih jika relevan).

---

## 9. Referensi

| Topik | Tautan |
|-------|--------|
| Dasar responsif | [MDN — Responsive design](https://developer.mozilla.org/en-US/docs/Learn_web_development/Core/CSS_layout/Responsive_Design) |
| Meta viewport | [MDN — viewport](https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/meta/name/viewport) |
| Breakpoint Tailwind | [Tailwind — Responsive design](https://tailwindcss.com/docs/responsive-design) |
| Layout adaptif (pane) | [Material Design 3 — Breakpoints](https://m3.material.io/foundations/layout/breakpoints) |
| Mindset kualitas/uji | [arc42 — Responsive design](https://quality.arc42.org/approaches/responsive-design) |
| Checklist handoff | [Desisle — Design-to-dev handoff](https://www.desisle.com/resources/design-to-dev-handoff-checklist) |

---

## 10. Pemeliharaan dokumen

- **Pemilik:** Product + lead frontend (tetapkan dalam proses tim).
- **Perbarui saat:** NFR PRD berubah, `screens` Tailwind dikustom, atau pilot RS menetapkan resolusi tablet wajib.
- **Versi Inggris:** [`RESPONSIVE_DESIGN.md`](RESPONSIVE_DESIGN.md) — jaga struktur kedua file tetap selaras.
