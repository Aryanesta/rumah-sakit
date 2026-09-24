# Rumah Sakit - Laravel & Alpine.js

Aplikasi web Laravel modern yang dibangun menggunakan **Alpine.js**, **Tailwind CSS**, dan **MySQL**.

Repositori ini mendukung dua opsi lingkungan pengembangan (*local development*):
1. **[Docker Compose / Laravel Sail](#-opsi-a-docker-compose--laravel-sail-macos--linux--windows-dengan-docker)** — Tanpa perlu menginstal PHP, Composer, atau MySQL di komputer lokal Anda (sangat direkomendasikan untuk macOS/Linux).
2. **[Laragon](#-opsi-b-laragon-khusus-windows-native)** — Lingkungan pengembangan lokal native untuk pengguna Windows.

---

## 🛠 Tech Stack

- **Backend:** Laravel (PHP 8.4)
- **Database:** MySQL 8.0
- **Frontend:** Alpine.js + Tailwind CSS (via Laravel Breeze)
- **Asset Bundler & HMR:** Vite

---

## 🐳 Opsi A: Docker Compose / Laravel Sail (macOS / Linux / Windows dengan Docker)

Gunakan metode ini jika Anda menginginkan lingkungan yang terisolasi dan bersih tanpa mengotori sistem operasi dengan instalasi PHP, Composer, atau MySQL.

### Prasyarat
- Pastikan aplikasi **[Docker Desktop](https://www.docker.com/products/docker-desktop/)** sudah terpasang dan sedang berjalan.

### Langkah Setup Cepat (Otomatis)
Cukup jalankan script setup di terminal:

```bash
./setup.sh
```

#### Apa yang dilakukan oleh `./setup.sh` secara otomatis:
1. Memeriksa apakah Docker Desktop aktif.
2. Mengunduh dan menyiapkan file project Laravel langsung di folder ini.
3. Mengonfigurasi file `.env` dengan kredensial database MySQL Docker.
4. Memasang **Laravel Breeze** dengan **Blade & Alpine.js**.
5. Menjalankan container Docker (`app` pada port `8000` dan `mysql` pada port `3306`).
6. Membuat *application key* dan menjalankan migrasi database.
7. Menginstal dependensi `npm` untuk frontend.

---

### 💻 Perintah Sehari-hari (`./dev-docker.sh`)

Gunakan script helper `./dev-docker.sh` agar tidak perlu mengetik perintah `docker compose` yang panjang:

#### 1. Menjalankan & Menghentikan Container
```bash
./dev-docker.sh up        # Menjalankan container di background
./dev-docker.sh down      # Menghentikan semua container
./dev-docker.sh restart   # Me-restart container
./dev-docker.sh logs      # Melihat log aplikasi secara realtime
```

#### 2. Menjalankan Hot-Reload Frontend (Vite + Alpine.js)
Untuk mengaktifkan fitur *hot-reload* pada tampilan Blade dan Alpine.js:
```bash
./dev-docker.sh npm run dev
```
Buka **[http://localhost](http://localhost)** di browser. Setiap perubahan pada file Blade atau Alpine.js akan langsung ter-update secara otomatis tanpa perlu refresh manual.

#### 3. Perintah Laravel Artisan
```bash
./dev-docker.sh artisan migrate
./dev-docker.sh artisan make:model Pasien -m
./dev-docker.sh artisan route:list
```

#### 4. Mengelola Paket (Composer & NPM)
```bash
./dev-docker.sh composer require <nama-paket>
./dev-docker.sh npm install <nama-paket>
```

#### 5. Masuk ke Terminal Container
```bash
./dev-docker.sh shell       # Masuk sebagai user 'sail'
./dev-docker.sh root-shell  # Masuk dengan hak akses root
```

---

### 🗄️ Konfigurasi Database Docker (MySQL)

Database MySQL berjalan di dalam container dengan penyimpanan data yang persisten.

| Parameter | Nilai |
| :--- | :--- |
| **Host** | `127.0.0.1` (dari komputer Mac/Host) / `mysql` (dari dalam container) |
| **Port** | `3306` |
| **Database** | `rumah_sakit` |
| **Username** | `sail` |
| **Password** | `secret` |

#### Akses via Terminal CLI:
```bash
./dev-docker.sh mysql
```

#### Akses via GUI Database (TablePlus, DBeaver, Beekeeper Studio):
Buat koneksi MySQL baru dengan rincian:
- **Host:** `127.0.0.1`
- **Port:** `3306`
- **User:** `sail`
- **Password:** `secret`
- **Database:** `rumah_sakit`

---

## 🐉 Opsi B: Laragon (Khusus Windows Native)

Gunakan metode ini jika Anda atau rekan tim Anda mengembangkan aplikasi di sistem operasi Windows menggunakan [Laragon](https://laragon.org/).

### Prasyarat
- **Laragon** sudah terinstal (pastikan PHP 8.2+, MySQL, Composer, dan Node.js sudah aktif di Laragon).

### Langkah-langkah Setup:

1. **Clone repository** ke folder web root Laragon:
   ```bash
   cd C:\laragon\www
   git clone <repo-url> rumah-sakit
   cd rumah-sakit
   ```

2. **Buka Terminal Laragon** (klik tombol **Terminal** pada Laragon atau tekan `Ctrl + Alt + T`).

3. **Install dependensi PHP dan Node:**
   ```bash
   composer install
   npm install
   ```

4. **Siapkan File Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Sesuaikan Konfigurasi Database untuk Laragon:**
   Buka file `.env` dan ubah konfigurasi database agar sesuai dengan default MySQL Laragon:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=rumah_sakit
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Buat Database & Jalankan Migrasi:**
   - Di Laragon, klik tombol **Database** (akan membuka HeidiSQL), lalu buat database baru dengan nama `rumah_sakit`.
   - Jalankan migrasi di terminal:
     ```bash
     php artisan migrate
     ```

7. **Jalankan Frontend Dev Server:**
   ```bash
   npm run dev
   ```

8. **Buka Aplikasi:**
   - Laragon akan otomatis membuat domain virtual host: **`http://rumah-sakit.test`**
   - Atau Anda juga bisa menjalankan `php artisan serve` dan membuka **`http://127.0.0.1:8000`**.

---

## 📁 Struktur File Utama

```text
.
├── docker-compose.yml   # Definisi multi-container (App & MySQL)
├── setup.sh             # Script otomatisasi instalasi pertama kali
├── dev-docker.sh        # Script helper CLI untuk Docker (Artisan, Composer, NPM, Shell)
├── .env.example         # Template konfigurasi environment
├── README.md            # Dokumentasi panduan instalasi & pengembangan
├── app/                 # Kode logika aplikasi Laravel
├── resources/
│   ├── js/              # Script frontend & konfigurasi Alpine.js
│   └── views/           # Template Blade
└── ...
```
