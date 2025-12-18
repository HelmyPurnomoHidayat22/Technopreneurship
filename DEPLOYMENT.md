# 🚀 Deployment Guide - Railway.app

Panduan lengkap untuk deploy aplikasi **DigitalCreativeHub** ke Railway.app dengan hosting dan domain gratis.

## 📋 Prerequisites

- ✅ Akun GitHub (gratis) - [Daftar di sini](https://github.com/signup)
- ✅ Akun Railway (gratis) - [Daftar di sini](https://railway.app)
- ✅ Git terinstall di komputer

---

## 🎯 Step 1: Push Kode ke GitHub

### 1.1 Buat Repository Baru di GitHub

1. Buka [github.com/new](https://github.com/new)
2. Isi nama repository: `digitalcreativehub` (atau nama lain)
3. Pilih **Private** atau **Public**
4. **JANGAN** centang "Add README" atau file lainnya
5. Klik **Create repository**

### 1.2 Push Kode dari Komputer

Buka terminal/PowerShell di folder project (`c:\xampp\htdocs\Technoprenership\Technopreneurship`), lalu jalankan:

```powershell
# Initialize git (jika belum)
git init

# Add semua file
git add .

# Commit
git commit -m "Initial commit - ready for deployment"

# Add remote (ganti USERNAME dan REPO_NAME dengan milik Anda)
git remote add origin https://github.com/USERNAME/REPO_NAME.git

# Push ke GitHub
git branch -M main
git push -u origin main
```

> **Note**: Jika diminta login, masukkan username dan **Personal Access Token** GitHub (bukan password).

---

## 🚂 Step 2: Deploy ke Railway

### 2.1 Login ke Railway

1. Buka [railway.app](https://railway.app)
2. Klik **Login** → pilih **Login with GitHub**
3. Authorize Railway untuk akses GitHub

### 2.2 Buat Project Baru

1. Klik **New Project**
2. Pilih **Deploy from GitHub repo**
3. Pilih repository `digitalcreativehub` yang tadi dibuat
4. Klik **Deploy Now**

### 2.3 Tambah Database PostgreSQL

1. Di project Railway, klik **New** → **Database** → **Add PostgreSQL**
2. Railway akan otomatis membuat database dan set environment variables

### 2.4 Set Environment Variables

1. Klik service aplikasi Anda (bukan database)
2. Buka tab **Variables**
3. Klik **Raw Editor** dan paste konfigurasi berikut:

```env
APP_NAME=DigitalCreativeHub
APP_ENV=production
APP_DEBUG=false
APP_URL=https://${{RAILWAY_PUBLIC_DOMAIN}}

# Database (Railway auto-set dari PostgreSQL service)
DB_CONNECTION=pgsql
DB_HOST=${{Postgres.PGHOST}}
DB_PORT=${{Postgres.PGPORT}}
DB_DATABASE=${{Postgres.PGDATABASE}}
DB_USERNAME=${{Postgres.PGUSER}}
DB_PASSWORD=${{Postgres.PGPASSWORD}}

# Session & Cache
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# Mail (gunakan log untuk testing, atau setup SMTP)
MAIL_MAILER=log

# File Storage
FILESYSTEM_DISK=local

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=error
```

4. Klik **Save** (akan auto-redeploy)

### 2.5 Generate APP_KEY

1. Setelah deployment selesai, buka tab **Deployments**
2. Klik deployment yang sedang running
3. Scroll ke bawah, cari bagian **Logs**
4. Jika ada error "No application encryption key", lakukan:
   - Kembali ke tab **Variables**
   - Tambahkan variable baru:
     - **Name**: `APP_KEY`
     - **Value**: Generate di [generate-random.org/laravel-key-generator](https://generate-random.org/laravel-key-generator) atau jalankan `php artisan key:generate --show` di lokal
   - Paste hasilnya (format: `base64:...`)
   - Save (akan redeploy)

---

## 🗄️ Step 3: Setup Database

### 3.1 Run Migrations & Seeders

Railway sudah otomatis run migrations saat deploy (lihat `Procfile`). Tapi untuk run seeders:

1. Di Railway, klik service aplikasi
2. Buka tab **Settings** → scroll ke **Deploy**
3. Ubah **Custom Start Command** menjadi:

```bash
php artisan migrate --force && php artisan db:seed --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
```

4. Save dan tunggu redeploy
5. **PENTING**: Setelah seeding berhasil, **kembalikan** start command ke yang original (tanpa `db:seed`) agar tidak seeding ulang setiap deploy:

```bash
php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
```

### 3.2 Verifikasi Database

Cek logs untuk memastikan migrations & seeders berhasil:
- Tab **Deployments** → klik deployment terbaru → lihat **Logs**
- Cari pesan: "Database seeding completed successfully"

---

## 🌐 Step 4: Setup Domain

### 4.1 Dapatkan Domain Gratis Railway

1. Di service aplikasi, buka tab **Settings**
2. Scroll ke **Networking** → **Public Networking**
3. Klik **Generate Domain**
4. Railway akan memberikan domain gratis seperti: `technopreneurship-production.up.railway.app`
5. Klik domain untuk buka aplikasi

### 4.2 Custom Domain (Opsional)

Jika punya domain sendiri (dari Niagahoster, Namecheap, dll):

1. Di Railway, klik **Custom Domain**
2. Masukkan domain Anda (contoh: `myapp.com`)
3. Railway akan memberikan CNAME record
4. Login ke provider domain Anda
5. Tambahkan CNAME record:
   - **Type**: CNAME
   - **Name**: `@` atau `www`
   - **Value**: (dari Railway)
   - **TTL**: 3600
6. Tunggu propagasi DNS (5-60 menit)
7. SSL otomatis aktif setelah domain terhubung

---

## ✅ Step 5: Testing & Verification

### 5.1 Test Akses Aplikasi

Buka domain Railway Anda, pastikan:
- ✅ Homepage loading dengan benar
- ✅ CSS/JS ter-load (tidak ada error 404)
- ✅ Bisa akses halaman login

### 5.2 Test Login Admin

1. Buka `/login`
2. Login dengan:
   - **Email**: `admin@email.com`
   - **Password**: `password`
3. Pastikan bisa masuk ke admin dashboard

### 5.3 Test Login User

1. Logout dari admin
2. Login dengan:
   - **Email**: `bimo@email.com`
   - **Password**: `password`
3. Pastikan bisa masuk ke user dashboard

### 5.4 Test Fitur Utama

- ✅ Admin: CRUD products
- ✅ Admin: Upload product images
- ✅ User: Browse products
- ✅ User: Create order
- ✅ User: Upload payment proof
- ✅ Admin: Verify payment
- ✅ Chat functionality

---

## 🔧 Troubleshooting

### Error: "500 Internal Server Error"

**Solusi**:
1. Cek logs di Railway (tab Deployments → Logs)
2. Pastikan `APP_KEY` sudah di-set
3. Pastikan database variables benar
4. Set `APP_DEBUG=true` sementara untuk lihat error detail

### Error: "SQLSTATE[08006] Connection refused"

**Solusi**:
1. Pastikan PostgreSQL service sudah running
2. Cek database variables di tab Variables
3. Pastikan format: `DB_HOST=${{Postgres.PGHOST}}` (dengan `Postgres.` prefix)

### Error: "Class not found"

**Solusi**:
1. Redeploy aplikasi
2. Atau tambahkan di start command: `composer dump-autoload &&` sebelum `php artisan migrate`

### File Upload Tidak Berfungsi

**Solusi**:
1. Railway menggunakan ephemeral storage (file hilang saat redeploy)
2. Untuk production, gunakan cloud storage (AWS S3, Cloudinary)
3. Atau gunakan Railway Volumes (berbayar)

### CSS/JS Tidak Loading

**Solusi**:
1. Pastikan `npm run build` berhasil (cek logs)
2. Cek `APP_URL` di variables sudah benar
3. Run `php artisan config:clear` via Railway CLI

---

## 📊 Monitoring & Maintenance

### Cek Resource Usage

1. Di Railway dashboard, lihat **Metrics**
2. Monitor CPU, Memory, Network usage
3. Free tier: $5 credit/bulan (~500 jam runtime)

### Update Aplikasi

Untuk deploy perubahan baru:

```powershell
# Di lokal, setelah edit kode
git add .
git commit -m "Update: deskripsi perubahan"
git push origin main
```

Railway akan otomatis detect push dan redeploy.

### Backup Database

1. Di Railway, klik PostgreSQL service
2. Tab **Data** → **Backups**
3. Klik **Create Backup**
4. Atau export via CLI:

```bash
railway run pg_dump -U $PGUSER -h $PGHOST $PGDATABASE > backup.sql
```

---

## 🎉 Selesai!

Aplikasi Anda sekarang sudah live di internet dengan:
- ✅ Hosting gratis di Railway
- ✅ Database PostgreSQL gratis
- ✅ Domain gratis (.railway.app)
- ✅ SSL/HTTPS otomatis
- ✅ Auto-deploy dari GitHub

**Domain Anda**: `https://[your-app].up.railway.app`

---

## 📞 Support

Jika ada masalah:
- Railway Docs: [docs.railway.app](https://docs.railway.app)
- Railway Discord: [discord.gg/railway](https://discord.gg/railway)
- Laravel Docs: [laravel.com/docs](https://laravel.com/docs)

---

**Happy Deploying! 🚀**
