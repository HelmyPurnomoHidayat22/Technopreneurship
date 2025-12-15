# DigitalCreativeHub

![License](https://img.shields.io/badge/license-MIT-blue.svg)
![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.3%2B-purple.svg)

**Digital Product Marketplace** - Platform jual beli produk digital dengan fitur custom design dan chat real-time.

## 🚀 Features

### User Features
- 🛒 **Product Catalog** - Browse dan beli produk digital
- 💳 **Manual Payment** - Upload bukti pembayaran
- 📦 **Order Management** - Track status pesanan
- 🎨 **Custom Design Request** - Pesan desain custom
- 💬 **Real-time Chat** - Komunikasi dengan admin
- 👤 **Profile Management** - Kelola profil dan order history

### Admin Features
- 📊 **Dashboard** - Statistik penjualan dan reports
- 🏷️ **Product Management** - CRUD produk dengan preview
- ✅ **Payment Verification** - Verifikasi bukti pembayaran
- 🎨 **Custom Design Workflow** - Upload design, revision, mark completed
- 💬 **Chat Management** - Komunikasi dengan customer
- 📈 **Sales Reports** - Laporan per status dan produk terlaris

## 🛠️ Tech Stack

### Backend
- **Laravel 11.x** - PHP Framework
- **MySQL** - Database
- **Sanctum** - API Authentication

### Frontend
- **Bootstrap 5.3** - CSS Framework
- **Bootstrap Icons** - Icon library
- **Vanilla JavaScript** - Client-side interactions

### Additional
- **File Storage** - Private & public disk
- **Real-time Features** - Order notifications, chat

## 📋 Requirements

- PHP >= 8.3
- Composer
- MySQL >= 8.0
- Node.js & NPM (for assets)
- XAMPP atau Laravel Valet (local development)

## ⚙️ Installation

### 1. Clone Repository
```bash
git clone https://github.com/YOUR_USERNAME/digitalcreativehub.git
cd digitalcreativehub
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Environment Setup
```bash
# Copy .env file
copy .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Configuration
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=digitalcreativehub
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Run Migrations & Seeders
```bash
php artisan migrate --seed
```

### 6. Storage Link
```bash
php artisan storage:link
```

### 7. Build Assets
```bash
npm run dev
```

### 8. Run Development Server
```bash
php artisan serve
```

Akses aplikasi di: `http://127.0.0.1:8000`

## 👥 Default Accounts

### Admin
- Email: `admin@email.com`
- Password: `password`

### User
- Email: `bimo@email.com`
- Password: `password`

## 📁 Project Structure

```
digitalcreativehub/
├── app/
│   ├── Http/Controllers/     # Controllers
│   │   ├── Admin/           # Admin controllers
│   │   └── ...
│   └── Models/              # Eloquent models
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/             # Database seeders
├── public/
│   ├── images/              # Public images
│   └── ...
├── resources/
│   └── views/               # Blade templates
│       ├── admin/           # Admin views
│       ├── user/            # User views
│       └── partials/        # Reusable components
├── routes/
│   └── web.php              # Web routes
└── storage/
    ├── app/private/         # Private file storage
    └── app/public/          # Public file storage
```

## 🔒 Security

- `.env` file tidak di-commit ke repository
- File uploads di-validasi (type & size)
- Private files hanya accessible via controller
- CSRF protection enabled
- Password hashing dengan bcrypt

## 📝 Order Status Flow

### Standard Products
1. `pending` - Order dibuat
2. `waiting_verification` - Bukti pembayaran uploaded
3. `paid` - Pembayaran verified
4. `rejected` - Pembayaran ditolak

### Custom Design Products
1. `pending` - Order dibuat
2. `waiting_verification` - Bukti pembayaran uploaded
3. `approved` - Custom design approved (chat aktif)
4. `in_progress` - Admin upload design file
5. `revision` - User request revisi (chat aktif)
6. `completed` - Design final

## 🤝 Contributing

1. Fork repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📄 License

This project is licensed under the MIT License.

## 👨‍💻 Developer

Created with ❤️ by **DigitalCreativeHub Team**

---

**Need Help?** Open an issue atau hubungi admin@digitalcreativehub.com
