<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## 🚀 Instalasi

### 1. Clone repository

```bash
git clone https://github.com/MuhamadMatin/presensi.git
cd presensi
```

### 2. Install dependensi PHP

```bash
composer install
```

### 3. Install dependensi Node.js

```bash
npm install
```

### 4. Salin file environment

```bash
cp .env.example .env
```

### 5. Generate application key

```bash
php artisan key:generate
```

### 6. Konfigurasi database

Edit file `.env` dan sesuaikan dengan konfigurasi database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Jalankan migrasi dan seeder

```bash
php artisan migrate --seed
```

### 8. Buat symbolic link storage

```bash
php artisan storage:link
```

### 9. Build asset frontend

```bash
# Development
npm run dev
```

### 10. Jalankan server

```bash
php artisan serve
```

Akses `http://localhost:8000`

---

## 🔑 Akun Default

Setelah menjalankan seeder, akun berikut tersedia:

| Role       | Username     | Password             |
| ---------- | ------------ | -------------------- |
| Admin      | `admin`      | `passwordadmin`      |
| Karyawan   | `karyawan`   | `passwordkaryawan`   |
| freelance  | `freelance`  | `passwordfreelance`  |
| internship | `internship` | `passwordinternship` |

---

## 🔄 Alur Aplikasi

### Autentikasi

```
Akses Halaman → Cek Session Login
    ├── Belum login → Redirect ke /login
    └── Sudah login → Lanjut ke Dashboard
```

### Alur Presensi Karyawan

```
Dashboard
    ├── Belum presensi hari ini
    │       └── Klik "Presensi Masuk" → Form Create Presensi
    │               ├── Isi Status, Lokasi, Deskripsi, Foto (jika Hadir)
    │               └── Submit → Simpan ke DB
    │
    ├── Sudah presensi masuk, belum keluar
    │       └── Klik "Presensi Keluar" → Update kolom `out` dengan waktu sekarang
    │
    └── Sudah presensi masuk & keluar
            └── Tampil badge "Anda sudah presensi keluar"
```

### Alur Validasi Presensi

```
Status = Hadir  → Lokasi WAJIB + Foto WAJIB (min 1, maks 3, max 2MB/foto)
Status = Izin   → Lokasi & Foto tidak wajib
Status = Sakit  → Lokasi & Foto tidak wajib
Status = Cuti   → Lokasi & Foto tidak wajib
```

### Alur Role

```
Admin
    ├── Melihat semua presensi seluruh karyawan
    ├── CRUD User
    ├── CRUD Presensi
    └── Update Setting (nama & logo aplikasi)

Karyawan
    ├── Hanya melihat presensi milik sendiri
    ├── Membuat presensi sendiri
    └── Update profile & password sendiri
```

### Alur Setting

```
Admin → Halaman Setting
    ├── Update nama aplikasi
    └── Upload logo/favicon (PNG/JPG, maks 2MB)
            └── Disimpan sebagai favicon.ico di storage/public
```

---

## 🛠️ Tech Stack

| Layer     | Teknologi                   |
| --------- | --------------------------- |
| Backend   | Laravel 12                  |
| Frontend  | Blade + Tailwind CSS        |
| Database  | MySQL                       |
| DataTable | DataTables.js (Server Side) |
| Alert     | SweetAlert2                 |
| jQuery    | jQuery 4.0.0                |
| Icon      | Heroicons                   |
