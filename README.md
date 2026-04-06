<div align="center">
  <img src="public/favicon.jpg" alt="E-Kantin Logo" width="120" style="border-radius: 20px;">

  # E-Kantin SMKN 1 Purwokerto

  **Platform Pemesanan Makanan Digital & Terintegrasi untuk Lingkungan Sekolah**

  [![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
  [![MySQL](https://img.shields.io/badge/MySQL-4479A1.svg?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
  [![WebSockets](https://img.shields.io/badge/Reverb-WebSockets-8B5CF6.svg?style=for-the-badge&logo=laravel&logoColor=white)](https://reverb.laravel.com)
  [![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-06B6D4.svg?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)

  [![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4.svg?style=flat-square&logo=php&logoColor=white)](https://php.net)
  [![Alpine.js](https://img.shields.io/badge/Alpine.js-8BC0D0.svg?style=flat-square&logo=alpine.js&logoColor=white)](https://alpinejs.dev)
  [![Web Push](https://img.shields.io/badge/Web_Push-Notifications-green.svg?style=flat-square)]()
  [![License](https://img.shields.io/badge/License-MIT-yellow.svg?style=flat-square)](LICENSE)

</div>

---

## 📖 Tentang Aplikasi

**E-Kantin** adalah aplikasi *e-commerce* modern berbasis web yang dirancang khusus untuk mendigitalisasi proses pemesanan makanan dan minuman di lingkungan **SMKN 1 Purwokerto**. Aplikasi ini menghubungkan **Siswa/Guru** (Pembeli), **Pemilik Kios** (Penjual), dan **Admin Sekolah** dalam satu platform terpadu yang efisien dan *real-time*.

Seluruh transaksi pemesanan dilakukan secara digital — mulai dari memilih menu, memasukkan ke keranjang, checkout, hingga penjual menerima notifikasi pesanan secara instan. Tidak ada lagi antrian panjang dan pesanan yang terlewat!

---

## ✨ Fitur Utama

### 🔐 Multi-Role System (3 Hak Akses)
Setiap pengguna memiliki *dashboard* dan fungsi yang disesuaikan dengan perannya:

| Role | Kemampuan Utama |
|------|----------------|
| **Admin** | Memantau statistik keseluruhan platform, menyetujui/menolak pendaftaran kios baru, manajemen pengguna, dan melihat *activity log*. |
| **Penjual** | Mengelola katalog menu kios secara mandiri (CRUD), menerima pesanan masuk *real-time*, dan memperbarui status setiap *order*. |
| **Pembeli** | Mengeksplorasi daftar kantin & kios, memasukkan pesanan ke keranjang belanja, melakukan checkout, dan memantau status pesanan secara *live*. |

### ⚡ Notifikasi Real-Time & Auto-Refresh (WebSockets)
Menggunakan **Laravel Reverb** sebagai mesin WebSocket lokal:
- **Penjual** langsung mendapat peringatan suara dan *modal* visual (tanpa perlu me-*refresh* halaman) ketika pesanan baru masuk dari pembeli.
- Halaman pesanan **Pembeli & Penjual** otomatis me-*reload* (*auto-refresh*) ketika terjadi pergantian status pesanan.
- Semua komunikasi berjalan secara lokal tanpa memerlukan layanan pihak ketiga.

### 🔔 Background Push Notifications (Native App Feel)
Pesanan masuk tidak akan pernah terlewat! Berkat integrasi **Service Worker** dan **Web Push API (VAPID)**:
- Penjual tetap menerima notifikasi native dari browser langsung ke *notification tray* OS HP/PC mereka.
- Notifikasi tetap aktif meskipun browser sedang ditutup, ter-*minimize*, atau perangkat dalam keadaan *standby*.

### 🎨 UI/UX Modern & Responsif
Dibangun dengan kombinasi **Tailwind CSS** dan **Alpine.js**, antarmuka E-Kantin sangat *fluid*:
- Dukungan **Dark Mode** secara global (mengikuti sistem OS atau toggle manual).
- Transisi komponen dan animasi *micro-interactions* di setiap elemen interaktif.
- Desain **mobile-first** yang mulus diakses di smartphone, tablet, maupun desktop.

---

## 🛠️ Tech Stack

| Teknologi | Fungsi |
|-----------|--------|
| **Laravel 12** | Backend framework utama (PHP 8.2+) |
| **Blade Templates** | Server-side rendering untuk tampilan |
| **Tailwind CSS** | Utility-first CSS framework untuk styling |
| **Alpine.js** | Lightweight JS framework untuk interaktivitas |
| **Vite** | Asset bundler untuk kompilasi CSS & JS |
| **MySQL / MariaDB** | Database relasional lokal |
| **Laravel Reverb** | WebSocket server lokal untuk real-time events |
| **Laravel Echo** | Client-side WebSocket listener |
| **Minishlink Web Push** | Server-side Web Push Notification (VAPID) |

---

## 🏗️ Arsitektur Aplikasi

```
┌────────────────────────────────────────────────────┐
│                     BROWSER                        │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────┐ │
│  │  Blade Views  │  │ Laravel Echo  │  │  SW/Push │ │
│  │  + Alpine.js  │  │ + pusher-js   │  │  (VAPID) │ │
│  └──────┬───────┘  └──────┬───────┘  └────┬─────┘ │
└─────────┼─────────────────┼───────────────┼───────┘
          │ HTTP             │ WS            │ Push
          ▼                  ▼               ▼
  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐
  │  🖥️ Laravel   │  │  📡 Reverb   │  │  🔔 Browser  │
  │  php artisan  │──│  WebSocket   │  │  Push API    │
  │    serve      │  │  Server      │  │  (Native OS) │
  └──────┬───────┘  └──────────────┘  └──────────────┘
         │
         ▼
  ┌──────────────┐
  │  🗄️ MySQL    │
  │  (Lokal)     │
  │  Laragon     │
  └──────────────┘
```

> **Semua berjalan 100% lokal** — tidak memerlukan koneksi internet atau layanan cloud apapun.

---

## 🚀 Instalasi & Konfigurasi (Versi Evaluasi)

Panduan ini dibuat khusus agar aplikasi dapat langsung dijalankan oleh penilai tanpa perlu menyetel layanan *cloud* atau *websockets* secara manual. Kredensial Pusher (WebSockets) dan Web Push (VAPID) **sudah disisipkan di dalam file `.env`**. Anda hanya perlu mengatur database.

### Kebutuhan Sistem
- **PHP >= 8.2** (Wajib aktifkan ekstensi `gmp` di `php.ini` untuk Web Push)
- **Composer** (PHP dependency manager)
- **MySQL / MariaDB** (disarankan menggunakan **Laragon/XAMPP** untuk kemudahan)

### Langkah Instalasi Mudah

```bash
# 1. Ekstrak file ZIP E-Kantin lalu masuk ke foldernya di terminal
cd web-kantin-smecone

# 2. Install dependensi PHP
composer install
```

### Konfigurasi Database Lokal
1. Buka aplikasi **Laragon / XAMPP**.
2. Buat database baru bernama `db_kantin` di phpMyAdmin / HeidiSQL / terminal MySQL.
3. Buka file `.env` dan pastikan konfigurasi database sudah benar (secara *default* sudah diset ke akses root lokal):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_kantin
DB_USERNAME=root
DB_PASSWORD=
```
4. Jalankan perintah migrasi beserta data *seeder*:
```bash
php artisan migrate:fresh --seed
```

> **Aset Frontend & Real-time WebSockets sudah dikonfigurasi!**
> Folder `public/build` sudah disiapkan sehingga tidak perlu menginstall Node.js. Fitur *notifikasi real-time* sudah terhubung otomatis ke Pusher Cloud.

---

## ▶️ Menjalankan Aplikasi

Anda hanya perlu membuka **2 terminal** terpisah:

```bash
# Terminal 1: Menjalankan Server Aplikasi Web
php artisan serve

# Terminal 2: Menjalankan Worker Antrian (Untuk Push Notifications Background)
php artisan queue:work
```

Buka **http://localhost:8000** di browser Anda! 🎉

---

## 🔐 Kredensial Akun Bawaan (Seeder)

Jika Anda menjalankan `php artisan migrate:fresh --seed`, akun percobaan berikut tersedia:

| Role | Email | Password |
|------|-------|----------|
| **🛡️ Admin** | admin@example.com | `password` |
| **🏪 Penjual** | penjual@example.com | `password` |
| **🛒 Pembeli** | pembeli@example.com | `password` |

---

## 📁 Struktur Direktori Penting

```
web-kantin-smecone/
├── app/
│   ├── Events/            # Broadcasting events (real-time)
│   ├── Http/Controllers/  # Controller untuk setiap role
│   ├── Models/            # Eloquent models
│   └── Services/          # Business logic (WebPush, dll)
├── config/
│   ├── broadcasting.php   # Konfigurasi Laravel Reverb
│   └── database.php       # Konfigurasi MySQL
├── database/
│   ├── migrations/        # Skema tabel database
│   └── seeders/           # Data awal (akun, kantin, menu)
├── public/
│   ├── build/             # Compiled assets (Vite output)
│   ├── sw.js              # Service Worker untuk push notifications
│   └── sounds/            # File audio notifikasi
├── resources/
│   ├── css/app.css        # Source Tailwind CSS
│   ├── js/
│   │   ├── app.js         # Main JS entry point
│   │   └── echo.js        # Laravel Echo + Reverb config
│   └── views/             # Blade templates (layouts, pages)
└── routes/
    ├── web.php            # Route definisi halaman web
    └── channels.php       # Broadcasting channel authorization
```

---

## ⚙️ Environment Variables

| Variabel | Keterangan | Default |
|----------|------------|---------|
| `DB_DATABASE` | Nama database MySQL | `db_kantin` |
| `DB_USERNAME` | Username MySQL | `root` |
| `DB_PASSWORD` | Password MySQL | _(kosong)_ |
| `BROADCAST_CONNECTION` | Driver broadcasting | `reverb` |
| `QUEUE_CONNECTION` | Driver antrian | `database` |
| `REVERB_HOST` | Host WebSocket server | `localhost` |
| `REVERB_PORT` | Port WebSocket server | `8080` |
| `VAPID_PUBLIC_KEY` | Public key push notification | _(generate manual)_ |
| `VAPID_PRIVATE_KEY` | Private key push notification | _(generate manual)_ |

---

## 🔒 Keamanan

- 🛡️ **CSRF Protection** pada setiap form submission.
- 🔑 **VAPID Authentication** untuk verifikasi push notification.
- 👤 **Role-based Access Control** dengan middleware Laravel.
- 🔐 **Bcrypt Hashing** untuk penyimpanan password aman.

---

## 👨‍💻 Developer

<div align="center">

  Dikembangkan oleh **Radiant213**

  [![GitHub](https://img.shields.io/badge/GitHub-Radiant213-181717.svg?style=for-the-badge&logo=github)](https://github.com/Radiant213)

</div>

---

<div align="center">


  &copy; 2026 E-Kantin. All rights reserved.

</div>
