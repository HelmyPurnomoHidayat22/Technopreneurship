# Environment Variables Setup

Copy file `.env.example` menjadi `.env` dan sesuaikan konfigurasi berikut:

## Konfigurasi Dasar

```env
APP_NAME="DigitalCreativeHub"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost
```

Jalankan `php artisan key:generate` untuk generate APP_KEY.

## Database Configuration

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=digitalcreativehub
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan dengan konfigurasi database MySQL Anda.

## Session Configuration

```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
```

## Filesystem Configuration

```env
FILESYSTEM_DISK=local
```

File private (produk dan payment proof) disimpan di `storage/app/private/`.

## Mail Configuration (Optional)

Jika ingin menggunakan email notification:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@digitalcreativehub.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## Cache & Queue Configuration

```env
CACHE_STORE=database
QUEUE_CONNECTION=database
```

Setelah mengubah `.env`, jalankan:

```bash
php artisan config:clear
php artisan cache:clear
```



