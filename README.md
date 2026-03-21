<div align="center">
  <img src="public/favicon.jpg" alt="E-Kantin Logo" width="120" style="border-radius: 20px;">

  # E-Kantin SMKN 1 Purwokerto

  **Platform Pemesanan Makanan Digital & Terintegrasi untuk Lingkungan Sekolah**

  [![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
  [![Pusher](https://img.shields.io/badge/Pusher-300D4F.svg?style=for-the-badge&logo=pusher&logoColor=white)](https://pusher.com)
  [![Aiven](https://img.shields.io/badge/Aiven_MySQL-FF3554.svg?style=for-the-badge&logo=aiven&logoColor=white)](https://aiven.io)
  [![Vercel](https://img.shields.io/badge/Vercel-000000.svg?style=for-the-badge&logo=vercel&logoColor=white)](https://vercel.com)

  [![WebSockets](https://img.shields.io/badge/WebSockets-Real_Time-blue.svg?style=flat-square)]()
  [![Web Push](https://img.shields.io/badge/Web_Push-Notifications-green.svg?style=flat-square)]()
  [![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4.svg?style=flat-square&logo=php&logoColor=white)](https://php.net)
  [![License](https://img.shields.io/badge/License-MIT-yellow.svg?style=flat-square)](LICENSE)

  <br>

  🌐 **Live Production:** [kantin.radiantcode.web.id](https://kantin.radiantcode.web.id)

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
| **🛡️ Admin** | Memantau statistik keseluruhan platform, menyetujui/menolak pendaftaran kios baru, manajemen pengguna, dan melihat *activity log*. |
| **🏪 Penjual** | Mengelola katalog menu kios secara mandiri (CRUD), menerima pesanan masuk *real-time*, dan memperbarui status setiap *order*. |
| **🛒 Pembeli** | Mengeksplorasi daftar kantin & kios, memasukkan pesanan ke keranjang belanja, melakukan checkout, dan memantau status pesanan secara *live*. |

### ⚡ Notifikasi Real-Time & Auto-Refresh (WebSockets)
Menggunakan **Pusher Channels**, aplikasi ini mendukung komunikasi dua arah tanpa jeda:
- **Penjual** langsung mendapat peringatan suara dan *modal* visual (tanpa perlu me-*refresh* halaman) ketika pesanan baru masuk dari pembeli.
- Halaman pesanan **Pembeli & Penjual** otomatis me-*reload* (*auto-refresh*) ketika terjadi pergantian status pesanan.
- Semua event dikirim melalui server WebSocket Pusher di **region Asia Pacific (Singapore)** untuk latensi minimal.

### 🔔 Background Push Notifications (Native App Feel)
Pesanan masuk tidak akan pernah terlewat! Berkat integrasi **Service Worker** dan **Web Push API (VAPID)**:
- Penjual tetap menerima notifikasi native dari browser langsung ke *notification tray* OS HP/PC mereka.
- Notifikasi tetap aktif meskipun browser sedang ditutup, ter-*minimize*, atau perangkat dalam keadaan *standby*.

### 🎨 UI/UX Modern & Responsif
Dibangun dengan kombinasi **Tailwind CSS** dan **Alpine.js**, antarmuka E-Kantin sangat *fluid*:
- 🌓 Dukungan **Dark Mode** secara global (mengikuti sistem OS atau toggle manual).
- ✨ Transisi komponen dan animasi *micro-interactions* di setiap elemen interaktif.
- 📱 Desain **mobile-first** yang mulus diakses di smartphone, tablet, maupun desktop.

---

## 🛠️ Tech Stack

### Core Application
| Teknologi | Fungsi |
|-----------|--------|
| **Laravel 12** | Backend framework utama (PHP 8.2+) |
| **Blade Templates** | Server-side rendering untuk tampilan |
| **Tailwind CSS** | Utility-first CSS framework untuk styling |
| **Alpine.js** | Lightweight JS framework untuk interaktivitas |
| **Vite** | Asset bundler untuk kompilasi CSS & JS |

### Cloud Services & Infrastructure
| Service | Fungsi |
|---------|--------|
| **☁️ Vercel** | Hosting & Deployment (Serverless PHP) |
| **🗄️ Aiven MySQL** | Managed cloud database dengan SSL encryption |
| **📡 Pusher Channels** | Managed WebSocket server untuk real-time events |
| **🔒 Cloudflare** | DNS management & SSL certificates |

### Libraries & APIs
| Library | Fungsi |
|---------|--------|
| **Laravel Echo** | Client-side WebSocket listener |
| **pusher-js** | JavaScript SDK untuk koneksi ke Pusher |
| **pusher/pusher-php-server** | PHP SDK untuk broadcasting events |
| **minishlink/web-push** | Server-side Web Push Notification (VAPID) |

---

## 🏗️ Arsitektur Deployment

```
┌─────────────────────────────────────────────────────┐
│                     BROWSER                         │
│  ┌──────────────┐  ┌───────────────┐  ┌──────────┐ │
│  │  Blade Views  │  │  Laravel Echo  │  │  SW/Push │ │
│  │  + Alpine.js  │  │  + pusher-js   │  │  (VAPID) │ │
│  └──────┬───────┘  └───────┬───────┘  └────┬─────┘ │
└─────────┼──────────────────┼───────────────┼───────┘
          │ HTTPS            │ WSS           │ Push
          ▼                  ▼               ▼
  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐
  │   ☁️ Vercel   │  │  📡 Pusher   │  │  🔔 Browser  │
  │  Serverless   │──│  Channels    │  │  Push API    │
  │  PHP Runtime  │  │  (Singapore) │  │  (Native OS) │
  └──────┬───────┘  └──────────────┘  └──────────────┘
         │ SSL (TLS 1.2+)
         ▼
  ┌──────────────┐
  │  🗄️ Aiven    │
  │  MySQL Cloud  │
  │  (Managed DB) │
  └──────────────┘
```

---

## 🚀 Instalasi Lokal (Development)

Ikuti langkah-langkah berikut untuk menjalankan E-Kantin di environment lokal:

### Kebutuhan Sistem
- PHP >= 8.2 (Wajib aktifkan ekstensi `gmp` di `php.ini` untuk Web Push)
- Composer
- Node.js & NPM
- MySQL / MariaDB

### Setup Langkah demi Langkah
```bash
# 1. Clone repository
git clone https://github.com/Radiant213/web-kantin-smecone.git
cd web-kantin-smecone

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database
# Atur DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD di file .env
php artisan migrate --seed

# 5. Generate VAPID Keys untuk Push Notification
npx web-push generate-vapid-keys
# Copy Public & Private Key ke .env sebagai VAPID_PUBLIC_KEY dan VAPID_PRIVATE_KEY

# 6. Build frontend assets
npm run build
```

### Menjalankan Aplikasi
Buka **3 terminal** terpisah:
```bash
# Terminal 1: Server utama Laravel
php artisan serve

# Terminal 2: Vite dev server (hot reload CSS/JS)
npm run dev

# Terminal 3: Queue worker (untuk background push notifications)
php artisan queue:work
```

> **ℹ️ Catatan:** Untuk development lokal, WebSocket menggunakan Pusher cloud sehingga **tidak perlu** menjalankan server WebSocket secara manual. Cukup pastikan kredensial Pusher sudah diisi di `.env`.

Buka `http://localhost:8000` di browser Anda!

---

## ⚙️ Environment Variables

Berikut variabel penting yang perlu dikonfigurasi di file `.env`:

| Variabel | Keterangan |
|----------|------------|
| `APP_URL` | URL aplikasi (`http://localhost:8000` untuk lokal) |
| `DB_HOST`, `DB_DATABASE`, dll. | Kredensial koneksi MySQL |
| `DB_SSL_CA` | Path ke sertifikat CA (khusus Aiven: `database/aiven-ca.pem`) |
| `PUSHER_APP_ID` | App ID dari dashboard Pusher |
| `PUSHER_APP_KEY` | App Key dari dashboard Pusher |
| `PUSHER_APP_SECRET` | App Secret dari dashboard Pusher |
| `PUSHER_APP_CLUSTER` | Cluster region Pusher (contoh: `ap1`) |
| `BROADCAST_CONNECTION` | Set ke `pusher` |
| `VAPID_PUBLIC_KEY` | Public key untuk Web Push Notification |
| `VAPID_PRIVATE_KEY` | Private key untuk Web Push Notification |

---

## 📁 Struktur Direktori Penting

```
web-kantin-smecone/
├── api/
│   └── index.php          # Entry point Vercel Serverless Function
├── app/
│   ├── Events/            # Broadcasting events (real-time)
│   ├── Http/Controllers/  # Controller untuk setiap role
│   └── Providers/         # Service providers (HTTPS enforcement)
├── config/
│   ├── broadcasting.php   # Konfigurasi Pusher Channels
│   └── database.php       # Konfigurasi MySQL + SSL
├── database/
│   ├── aiven-ca.pem       # Sertifikat CA untuk koneksi Aiven SSL
│   ├── migrations/        # Skema tabel database
│   └── seeders/           # Data seeder awal
├── public/
│   ├── build/             # Compiled assets (Vite output)
│   ├── sw.js              # Service Worker untuk push notifications
│   └── sounds/            # File audio notifikasi
├── resources/
│   ├── css/app.css        # Source Tailwind CSS
│   ├── js/
│   │   ├── app.js         # Main JS entry point
│   │   └── echo.js        # Laravel Echo + Pusher config
│   └── views/             # Blade templates (layouts, pages)
├── vercel.json            # Konfigurasi deployment Vercel
└── .vercelignore          # Daftar file yang diabaikan saat deploy
```

---

## 🔒 Keamanan

- 🔐 **SSL/TLS Encryption** pada semua koneksi database (Aiven MySQL).
- 🛡️ **CSRF Protection** pada setiap form submission.
- 🔑 **VAPID Authentication** untuk verifikasi push notification.
- 🔒 **HTTPS Enforcement** otomatis di environment production.
- 👤 **Role-based Access Control** dengan middleware Laravel.

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
