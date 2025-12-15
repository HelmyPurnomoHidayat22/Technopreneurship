# Cara Akses Admin Dashboard

## Login Sebagai Admin

### Kredensial Default Admin

Berdasarkan seeder yang sudah dibuat, kredensial admin adalah:

```
Email: admin@digitalcreativehub.com
Password: password
```

### Langkah-langkah Login:

1. **Buka halaman login:**
   ```
   http://127.0.0.1:8000/login
   ```

2. **Masukkan kredensial:**
   - Email: `admin@digitalcreativehub.com`
   - Password: `password`

3. **Klik tombol "Sign In"**

4. **Anda akan di-redirect otomatis ke:**
   ```
   http://127.0.0.1:8000/admin/dashboard
   ```

## Jika Admin Belum Ada

Jika admin belum dibuat, jalankan seeder:

```bash
php artisan db:seed
```

Atau buat admin secara manual melalui Tinker:

```bash
php artisan tinker
```

Kemudian jalankan:

```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@digitalcreativehub.com',
    'password' => \Illuminate\Support\Facades\Hash::make('password'),
    'role' => 'admin',
]);
```

## Fitur Admin Dashboard

Setelah login sebagai admin, Anda dapat mengakses:

1. **Dashboard** (`/admin/dashboard`)
   - Total Users
   - Total Transactions
   - Total Revenue
   - Best Selling Products

2. **Manage Products** (`/admin/products`)
   - Create, Read, Update, Delete produk
   - Upload preview image dan file template

3. **Manage Orders** (`/admin/orders`)
   - Lihat semua pesanan
   - Verifikasi pembayaran manual
   - Reject pembayaran

4. **Manage Users** (`/admin/users`)
   - Lihat daftar semua user
   - Lihat detail user dan order history

5. **Reports** (`/admin/reports`)
   - Laporan penjualan
   - Produk terlaris
   - Statistik transaksi

## Cara Membuat Admin Baru (Alternatif)

Jika ingin membuat admin baru dengan email berbeda:

```bash
php artisan tinker
```

```php
\App\Models\User::create([
    'name' => 'Nama Admin Anda',
    'email' => 'your-admin@email.com',
    'password' => \Illuminate\Support\Facades\Hash::make('password-anda'),
    'role' => 'admin',
]);
```

## Keamanan

⚠️ **PENTING:** 
- Ganti password default setelah pertama kali login
- Jangan gunakan password yang sama di production
- Pastikan kredensial admin aman dan tidak di-share

---

**Selamat menggunakan Admin Dashboard!** 🎉



