<div align="center">
  <img src="public/favicon.jpg" alt="E-Kantin Logo" width="100">
  
  # E-Kantin SMKN 1 Purwokerto
  
  **Platform Pemesanan Makanan Digital & Terintegrasi untuk Lingkungan Sekolah**
  
  [![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20.svg?style=flat&logo=laravel)](https://laravel.com)
  [![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.x-38B2AC.svg?style=flat&logo=tailwind-css)](https://tailwindcss.com)
  [![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0.svg?style=flat&logo=alpine.js)](https://alpinejs.dev)
  [![Pusher](https://img.shields.io/badge/WebSockets-RealTime-informational.svg?style=flat)](https://reverb.laravel.com)
</div>

---

## 📖 Tentang Aplikasi
E-Kantin SMKN 1 Purwokerto adalah aplikasi e-commerce modern berbasis web yang dirancang khusus untuk mendigitalisasi proses pemesanan makanan dan minuman di lingkungan sekolah. Aplikasi ini menghubungkan Siswa/Guru (Pembeli), Pemilik Kios (Penjual), dan Admin Sekolah dalam satu platform terpadu yang sangat efisien dan *real-time*.

## ✨ Fitur Utama

### 1. Multi-Role System
Aplikasi ini menampung 3 hak akses pengguna dengan *dashboard* yang disesuaikan:
- **Admin:** Memantau statistik web, menyetujui pendaftaran kios baru, manajemen pengguna, dan melihat *activity log*.
- **Penjual:** Mengelola katalog menu kios secara mandiri, menerima pesanan masuk, dan memperbarui status *order*.
- **Pembeli:** Mengeksplorasi pilihan kantin & kios, memasukkan pesanan ke keranjang, checkout, dan memantau pesanan.

### 2. Notifikasi Real-Time & Auto-Refresh (WebSockets)
Menggunakan mesin **Laravel Reverb**, aplikasi ini mendukung komunikasi dua arah tanpa jeda:
- Penjual langsung mendapat peringatan suara dan modal visual (tanpa perlu me-refresh halaman) ketika pesanan baru ditekan oleh pembeli.
- Halaman pesanan Pembeli & Penjual otomatis me-reload (*auto-refresh*) ketika ada pergantian status pada pesanan.

### 3. Background Push Notifications (Native App Feel)
Pesanan masuk tidak akan pernah terlewat oleh penjual! Berkat integrasi **Service Worker** dan **Web Push API**, penjual akan tetap menerima notifikasi native dari browser langsung ke layer OS HP/PC mereka, meskipun browser sedang ditutup, terminimize, atau HP dalam keadaan standby.

### 4. UI/UX Modern & Responsif
Dibangun dengan kombinasi **Tailwind CSS** dan **Alpine.js**, antarmuka E-Kantin sangat *fluid* dengan membawa fitur-fitur seperti:
- Dukungan **Dark Mode** secara global (mengikuti sistem OS atau pengaturan toggle manual).
- Transisi komponen dan animasi *micro-interactions* di setiap tombol.
- Desain *mobile-first* yang mulus diakses di perangkat manapun.

---

## 🛠️ Tech Stack
- **Backend:** Laravel 11 (PHP 8.2+)
- **Frontend:** Laravel Blade, Tailwind CSS, Alpine.js
- **Database:** MySQL / SQLite
- **Real-time Engine:** Laravel Reverb & Laravel Echo
- **Push Notification:** Minishlink Web Push
- **Asset Bundler:** Vite

---

## 🚀 Instalasi & Konfigurasi Lokal

Ikuti langkah-langkah di bawah ini untuk menjalankan E-Kantin di server lokal Anda:

### 1. Kebutuhan Sistem
Pastikan Anda telah menginstal/menyiapkan:
- PHP >= 8.2 (**Wajib:** Aktifkan ekstensi `gmp` di `php.ini` untuk Web Push / Enkripsi ECDSA)
- Composer
- Node.js & NPM
- MySQL/MariaDB (atau SQLite)

### 2. Clone & Setup Awal
```bash
# Clone repository
git clone https://github.com/username/e-kantin-smecone.git
cd e-kantin-smecone

# Install dependencies PHP & Javascript
composer install
npm install

# Setup environment variables
cp .env.example .env
php artisan key:generate
```

### 3. Setup VAPID Keys (Untuk Push Notification)
Karena aplikasi menggunakan Web Push Notification, Anda wajib meng-generate key enkripsi:
```bash
npx web-push generate-vapid-keys
```
Silakan *copy* `Public Key` dan `Private Key` yang muncul di terminal, lalu buka file `.env` dan tambahkan di bagian terbawah:
```env
VAPID_PUBLIC_KEY="paste_public_key_disini"
VAPID_PRIVATE_KEY="paste_private_key_disini"
```

### 4. Database & Migrasi
Atur koneksi database Anda (misal `DB_DATABASE=kantin_smecone`) pada file `.env`. Jalankan migrasi dan seeder untuk memasukkan data dummy (Kantin Utama, Kios, Menu, & Akun):
```bash
php artisan migrate:fresh --seed
```

### 5. Menjalankan Aplikasi
Aplikasi ini memiliki fitur *background process* dan *websockets* yang intens. Disarankan membuka 4 terminal (*tab*) yang berbeda untuk me-*run* layanan:

```bash
# Terminal 1: Menjalankan Server Utama
php artisan serve

# Terminal 2: Mem-build aset Javascript & CSS 
npm run dev

# Terminal 3: Menjalankan WebSocket Server (Laravel Reverb)
php artisan reverb:start --debug

# Terminal 4: Menjalankan Worker Antrian (Untuk Push Notifications Background)
php artisan queue:work
```

Buka `http://localhost:8000` di browser Anda!

---

## 🔐 Kredensial Akun (Dummy Data Seeder)
Jika Anda menggunakan perintah `--seed`, Anda dapat masuk menggunakan akun percobaan berikut:

| Role Akses | Alamat Email | Kata Sandi |
|------|-------|----------|
| **Admin Pusat** | admin@example.com | `password` |
| **Penjual (Pemilik Kios)** | penjual@example.com | `password` |
| **Pembeli (Siswa)** | pembeli@example.com | `password` |

---

<div align="center">
  Dibuat dengan ❤️ untuk kemajuan digitalisasi <b>SMKN 1 Purwokerto</b>.
</div>
