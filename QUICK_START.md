# 🚀 Quick Start - Deploy ke Railway

Panduan singkat untuk deploy aplikasi dalam 5 langkah!

## Prerequisites
- ✅ Akun GitHub: [github.com/signup](https://github.com/signup)
- ✅ Akun Railway: [railway.app](https://railway.app) (login dengan GitHub)

---

## 📝 Langkah Deploy

### 1️⃣ Push ke GitHub

```powershell
# Di folder project (c:\xampp\htdocs\Technoprenership\Technopreneurship)
git init
git add .
git commit -m "Initial commit"

# Ganti USERNAME dan REPO dengan milik Anda
git remote add origin https://github.com/USERNAME/REPO.git
git branch -M main
git push -u origin main
```

> **Alternatif**: Gunakan script helper
> ```powershell
> .\deploy-railway.ps1
> ```

### 2️⃣ Deploy di Railway

1. Buka [railway.app](https://railway.app) → Login dengan GitHub
2. **New Project** → **Deploy from GitHub repo**
3. Pilih repository Anda → **Deploy Now**

### 3️⃣ Tambah Database

1. Di project Railway, klik **New** → **Database** → **Add PostgreSQL**
2. Tunggu database selesai dibuat

### 4️⃣ Set Environment Variables

1. Klik service aplikasi (bukan database)
2. Tab **Variables** → **Raw Editor**
3. Paste konfigurasi ini:

```env
APP_NAME=DigitalCreativeHub
APP_ENV=production
APP_DEBUG=false
APP_URL=https://${{RAILWAY_PUBLIC_DOMAIN}}

DB_CONNECTION=pgsql
DB_HOST=${{Postgres.PGHOST}}
DB_PORT=${{Postgres.PGPORT}}
DB_DATABASE=${{Postgres.PGDATABASE}}
DB_USERNAME=${{Postgres.PGUSER}}
DB_PASSWORD=${{Postgres.PGPASSWORD}}

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
MAIL_MAILER=log
FILESYSTEM_DISK=local
LOG_CHANNEL=stack
LOG_LEVEL=error
```

4. **PENTING**: Tambahkan `APP_KEY`
   - Generate di: [generate-random.org/laravel-key-generator](https://generate-random.org/laravel-key-generator)
   - Atau jalankan `php artisan key:generate --show` di lokal
   - Tambahkan variable `APP_KEY` dengan value hasil generate (format: `base64:...`)

5. Klik **Save**

### 5️⃣ Run Database Seeder

1. Tab **Settings** → scroll ke **Deploy**
2. **Custom Start Command**, paste:

```bash
php artisan migrate --force && php artisan db:seed --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
```

3. Save → tunggu redeploy selesai
4. **Setelah seeding berhasil**, kembalikan command ke:

```bash
php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
```

### 6️⃣ Dapatkan Domain

1. Tab **Settings** → **Networking** → **Public Networking**
2. **Generate Domain**
3. Klik domain untuk buka aplikasi

---

## ✅ Test Aplikasi

### Login Admin
- URL: `https://[your-domain].up.railway.app/login`
- Email: `admin@email.com`
- Password: `password`

### Login User
- Email: `bimo@email.com`
- Password: `password`

---

## 🔄 Update Aplikasi

Setiap kali ada perubahan kode:

```powershell
git add .
git commit -m "Update: deskripsi perubahan"
git push origin main
```

Railway akan otomatis redeploy!

---

## 📚 Dokumentasi Lengkap

Lihat [DEPLOYMENT.md](DEPLOYMENT.md) untuk:
- Troubleshooting
- Custom domain setup
- Database backup
- Monitoring

---

## 🎉 Selesai!

Aplikasi Anda sekarang live di internet dengan hosting, database, dan domain GRATIS!

**Need help?** Baca [DEPLOYMENT.md](DEPLOYMENT.md) atau cek Railway docs.
