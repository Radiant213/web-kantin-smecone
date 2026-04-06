# Aiven MySQL SSL Setup untuk Vercel

## Overview

Aiven MySQL requires SSL/TLS connection. Panduan ini menjelaskan cara setup CA certificate untuk production deployment di Vercel.

---

## Kredensial Aiven MySQL

```
Host: database-projek-web-kantin-smecone-radianceofglow.i.aivencloud.com
Port: 21985
Database: defaultdb
User: avnadmin
Password: [REDACTED - Check Aiven Dashboard]
SSL Mode: REQUIRED
```

---

## Step 1: Download CA Certificate dari Aiven

### Via Aiven Dashboard:
1. Login ke [console.aiven.io](https://console.aiven.io)
2. Pilih project: **database-projek-web-kantin-smecone**
3. Klik service MySQL lu
4. Di tab "Overview", scroll ke bawah ke section "Connection information"
5. Klik tombol **"Show"** di sebelah "CA certificate"
6. Copy seluruh isi certificate (dari `-----BEGIN CERTIFICATE-----` sampai `-----END CERTIFICATE-----`)

### Paste ke File:
Buka file `database/aiven-ca.pem` dan paste certificate yang lu copy:

```
-----BEGIN CERTIFICATE-----
MIIEQTCCAqmgAwIBAgIUPYKEKJEKJEKJEKJEKJEKJEKJEKJEKJEKJEKJEKJEKJEK
... (isi certificate dari Aiven)
-----END CERTIFICATE-----
```

**PENTING**: File ini HARUS di-commit ke GitHub agar Vercel bisa akses!

---

## Step 2: Update config/database.php

File `config/database.php` udah gw update dengan SSL options:

```php
'mysql' => [
    'driver' => 'mysql',
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '3306'),
    'database' => env('DB_DATABASE', 'laravel'),
    'username' => env('DB_USERNAME', 'root'),
    'password' => env('DB_PASSWORD', ''),
    // ... other options
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('DB_SSL_CA'),
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => env('DB_SSL_VERIFY_SERVER_CERT', true),
    ]) : [],
],
```

---

## Step 3: Environment Variables untuk Vercel

Di Vercel Dashboard → Settings → Environment Variables, tambahkan:

### Database Configuration:
```
DB_CONNECTION=mysql
DB_HOST=database-projek-web-kantin-smecone-radianceofglow.i.aivencloud.com
DB_PORT=21985
DB_DATABASE=defaultdb
DB_USERNAME=avnadmin
DB_PASSWORD=[YOUR_AIVEN_PASSWORD]
```

### SSL Configuration:
```
DB_SSL_CA=/var/task/database/aiven-ca.pem
DB_SSL_VERIFY_SERVER_CERT=true
```

**CATATAN**: Path `/var/task/` adalah root directory di Vercel serverless functions.

---

## Step 4: Test Connection di Local

Sebelum deploy, test dulu di local:

### Update .env lokal:
```env
DB_CONNECTION=mysql
DB_HOST=database-projek-web-kantin-smecone-radianceofglow.i.aivencloud.com
DB_PORT=21985
DB_DATABASE=defaultdb
DB_USERNAME=avnadmin
DB_PASSWORD=[YOUR_AIVEN_PASSWORD]
DB_SSL_CA=D:/laragon/www/web-kantin-smecone/database/aiven-ca.pem
DB_SSL_VERIFY_SERVER_CERT=true
```

**PENTING**: Path `DB_SSL_CA` di local harus absolute path ke file `aiven-ca.pem`.

### Test Connection:
```bash
php artisan migrate:status
```

Kalo berhasil connect, harusnya muncul list migrations.

---

## Step 5: Commit & Push

```bash
# 1. Pastikan aiven-ca.pem udah diisi dengan certificate dari Aiven
git add database/aiven-ca.pem
git add config/database.php
git add .env.vercel

# 2. Commit
git commit -m "Add Aiven MySQL SSL configuration"

# 3. Push
git push origin main
```

---

## Step 6: Run Migrations di Production

Setelah deploy ke Vercel, run migrations via Vercel CLI atau create API endpoint:

### Option 1: Via Vercel CLI
```bash
vercel env pull .env.production
php artisan migrate --env=production --force
```

### Option 2: Create Migration Endpoint (Recommended)

Buat route khusus buat run migrations (HARUS PROTECTED!):

**routes/web.php**:
```php
Route::get('/migrate-production', function () {
    // IMPORTANT: Add authentication/secret key check here!
    if (request()->input('secret') !== env('MIGRATION_SECRET')) {
        abort(403);
    }
    
    Artisan::call('migrate', ['--force' => true]);
    return 'Migrations completed: ' . Artisan::output();
})->middleware('web');
```

Add `MIGRATION_SECRET` ke Vercel env vars, terus akses:
```
https://your-vercel-domain.vercel.app/migrate-production?secret=your-secret-key
```

---

## Troubleshooting

### Error: "SQLSTATE[HY000] [2002] Connection refused"

**Cause**: Vercel tidak bisa connect ke Aiven.

**Solution**:
1. Verify Aiven service is running (check dashboard)
2. Verify credentials benar
3. Verify `DB_SSL_CA` path benar: `/var/task/database/aiven-ca.pem`
4. Check Vercel deployment logs untuk error details

### Error: "SSL connection error"

**Cause**: CA certificate tidak ditemukan atau invalid.

**Solution**:
1. Verify `database/aiven-ca.pem` exists dan ter-commit ke GitHub
2. Verify isi certificate lengkap (dari BEGIN sampai END)
3. Verify `DB_SSL_CA` path di Vercel env vars: `/var/task/database/aiven-ca.pem`

### Error: "Access denied for user"

**Cause**: Username atau password salah.

**Solution**:
1. Verify credentials di Aiven dashboard
2. Copy-paste credentials langsung (jangan ketik manual)
3. Check Aiven user permissions

### Error: "Unknown database 'defaultdb'"

**Cause**: Database name salah atau belum dibuat.

**Solution**:
1. Verify database name di Aiven dashboard
2. Default database name untuk Aiven MySQL adalah `defaultdb`
3. Kalo mau ganti, create database baru di Aiven dulu

---

## Security Best Practices

### 1. Jangan Hardcode Credentials
- ❌ JANGAN commit `.env` dengan credentials
- ✅ Gunakan Vercel environment variables
- ✅ Commit `.env.example` atau `.env.vercel` sebagai template (tanpa sensitive data)

### 2. Protect Migration Endpoints
- ❌ JANGAN expose migration endpoint tanpa authentication
- ✅ Gunakan secret key atau middleware authentication
- ✅ Atau run migrations via Vercel CLI

### 3. Use Strong Passwords
- ✅ Aiven auto-generate strong password
- ✅ Jangan share password di public repo
- ✅ Rotate password secara berkala

### 4. Enable SSL/TLS
- ✅ Aiven requires SSL by default (good!)
- ✅ Set `DB_SSL_VERIFY_SERVER_CERT=true` untuk verify certificate
- ✅ Jangan disable SSL verification di production

---

## Vercel Environment Variables Checklist

Copy-paste ini ke Vercel Dashboard:

```
# App
APP_NAME=E-Kantin SMK
APP_ENV=production
APP_KEY=base64:wmbUiQLN+wd6KiAeo2GPZm9WyX3iK5Zj2obwg7ChDr4=
APP_DEBUG=false
APP_URL=https://your-vercel-domain.vercel.app

# Broadcasting
BROADCAST_CONNECTION=pusher
PUSHER_APP_ID=2137362
PUSHER_APP_KEY=f33de668f2cc65808239
PUSHER_APP_SECRET=8f472d0c72b70d63caa3
PUSHER_APP_CLUSTER=ap1

# Database - Aiven MySQL
DB_CONNECTION=mysql
DB_HOST=database-projek-web-kantin-smecone-radianceofglow.i.aivencloud.com
DB_PORT=21985
DB_DATABASE=defaultdb
DB_USERNAME=avnadmin
DB_PASSWORD=[YOUR_AIVEN_PASSWORD]
DB_SSL_CA=/var/task/database/aiven-ca.pem
DB_SSL_VERIFY_SERVER_CERT=true

# Session & Cache
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# VAPID
VAPID_PUBLIC_KEY=BM85zkAF0lYhfuPyQlZCIyrahWHZvCPnjnofxS83ErmLtvmEzLfTsipe0J-aptOZHID-14cWTkTSXxAe9l1bDm8
VAPID_PRIVATE_KEY=8qmyDQQpsc0CNANMh5HLUCeg3zGgBLVFbdvJ2_82_yI

# Debug
VITE_ECHO_DEBUG=false

# Migration Secret (optional, for migration endpoint)
MIGRATION_SECRET=your-random-secret-key-here
```

---

## Additional Resources

- [Aiven MySQL Documentation](https://docs.aiven.io/docs/products/mysql)
- [Laravel Database SSL](https://laravel.com/docs/database#configuration)
- [Vercel Environment Variables](https://vercel.com/docs/concepts/projects/environment-variables)

---

## Summary

✅ Download CA certificate dari Aiven dashboard
✅ Paste ke `database/aiven-ca.pem`
✅ Update `config/database.php` dengan SSL options (udah gw lakuin)
✅ Add database credentials ke Vercel environment variables
✅ Set `DB_SSL_CA=/var/task/database/aiven-ca.pem` di Vercel
✅ Commit `aiven-ca.pem` ke GitHub
✅ Test connection di local dulu
✅ Deploy ke Vercel
✅ Run migrations di production

Selesai! Database Aiven MySQL dengan SSL udah siap dipake di production! 🚀
