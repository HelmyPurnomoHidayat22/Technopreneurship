# Setup Database - DigitalCreativeHub

## 📋 Cara Membuat Database

### Metode 1: Via phpMyAdmin (Recommended)

1. **Buka phpMyAdmin:**
   ```
   http://localhost/phpmyadmin
   ```

2. **Klik "New" di sidebar kiri** untuk membuat database baru

3. **Buat database dengan nama:**
   ```
   digitalcreativehub
   ```

4. **Pilih Collation:**
   - Pilih: `utf8mb4_unicode_ci`
   - Atau biarkan default

5. **Klik "Create"**

### Metode 2: Via MySQL Command Line

1. **Buka MySQL Command Line** atau Terminal:
   ```bash
   mysql -u root -p
   ```

2. **Masukkan password MySQL** (jika ada)

3. **Buat database:**
   ```sql
   CREATE DATABASE digitalcreativehub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

4. **Keluar dari MySQL:**
   ```sql
   exit;
   ```

### Metode 3: Via XAMPP MySQL (Command Prompt)

1. **Buka Command Prompt/PowerShell**

2. **Masuk ke folder MySQL XAMPP:**
   ```bash
   cd C:\xampp\mysql\bin
   ```

3. **Login ke MySQL:**
   ```bash
   mysql -u root
   ```

4. **Buat database:**
   ```sql
   CREATE DATABASE digitalcreativehub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

5. **Keluar:**
   ```sql
   exit;
   ```

## ⚙️ Konfigurasi .env

Setelah database dibuat, pastikan file `.env` sudah dikonfigurasi:

1. **Buka file `.env`** di root project

2. **Pastikan konfigurasi database:**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=digitalcreativehub
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   
   **Catatan:** Jika MySQL Anda punya password, isi di `DB_PASSWORD=yourpassword`

## 🚀 Jalankan Migration & Seeder

Setelah database dibuat dan `.env` dikonfigurasi:

1. **Jalankan migration** untuk membuat tabel-tabel:
   ```bash
   php artisan migrate
   ```

2. **Jalankan seeder** untuk membuat data awal (categories, products, admin):
   ```bash
   php artisan db:seed
   ```

## ✅ Verifikasi

Cek apakah database sudah dibuat dengan benar:

1. Buka phpMyAdmin
2. Lihat di sidebar kiri, database `digitalcreativehub` sudah ada
3. Setelah migration, akan ada tabel-tabel:
   - `users`
   - `categories`
   - `products`
   - `orders`
   - `password_reset_tokens`
   - `cache`
   - `jobs`
   - `sessions`

## 📝 Struktur Database

Setelah migration berhasil, database akan memiliki struktur:

- **users** - Data user (admin & customer)
- **categories** - Kategori produk
- **products** - Produk digital
- **orders** - Pesanan/transaksi

## ⚠️ Troubleshooting

### Error: Access denied
- Pastikan username dan password MySQL benar di `.env`
- Default XAMPP: username = `root`, password = kosong

### Error: Database doesn't exist
- Pastikan sudah membuat database `digitalcreativehub` terlebih dahulu
- Cek nama database di `.env` sesuai dengan yang dibuat

### Error: Table already exists
- Database mungkin sudah pernah di-migrate
- Gunakan `php artisan migrate:fresh` untuk reset (HATI-HATI: akan menghapus semua data)
- Atau gunakan `php artisan migrate:refresh` untuk reset dan re-seed

---

**Selamat! Database sudah siap digunakan.** 🎉



