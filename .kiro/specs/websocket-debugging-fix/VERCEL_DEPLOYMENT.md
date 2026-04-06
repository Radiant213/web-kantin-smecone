# Vercel Deployment Guide - Production Setup

## Overview

Panduan lengkap deploy Laravel E-Kantin ke Vercel dengan Pusher untuk WebSocket production.

## Kredensial Pusher Production

```
App ID: 2137362
Key: f33de668f2cc65808239
Secret: 8f472d0c72b70d63caa3
Cluster: ap1
```

---

## Step 1: Update .env untuk Production

Buat file `.env.production` atau update `.env` sebelum push ke GitHub:

```env
APP_NAME="E-Kantin SMK"
APP_ENV=production
APP_KEY=base64:wmbUiQLN+wd6KiAeo2GPZm9WyX3iK5Zj2obwg7ChDr4=
APP_DEBUG=false
APP_URL=https://your-vercel-domain.vercel.app

# Broadcasting - PRODUCTION (Pusher)
BROADCAST_CONNECTION=pusher

# Pusher Configuration (Production)
PUSHER_APP_ID=2137362
PUSHER_APP_KEY=f33de668f2cc65808239
PUSHER_APP_SECRET=8f472d0c72b70d63caa3
PUSHER_APP_CLUSTER=ap1

# Database (Vercel Postgres atau external)
DB_CONNECTION=mysql
DB_HOST=your-database-host
DB_PORT=3306
DB_DATABASE=your-database-name
DB_USERNAME=your-database-user
DB_PASSWORD=your-database-password

# Session & Cache (gunakan database atau redis)
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# VAPID Keys (Web Push)
VAPID_PUBLIC_KEY="BM85zkAF0lYhfuPyQlZCIyrahWHZvCPnjnofxS83ErmLtvmEzLfTsipe0J-aptOZHID-14cWTkTSXxAe9l1bDm8"
VAPID_PRIVATE_KEY="8qmyDQQpsc0CNANMh5HLUCeg3zGgBLVFbdvJ2_82_yI"

# Disable debug logging in production
VITE_ECHO_DEBUG=false
```

---

## Step 2: Vercel Environment Variables

Di Vercel Dashboard → Settings → Environment Variables, tambahkan:

### Broadcasting & Pusher
```
BROADCAST_CONNECTION=pusher
PUSHER_APP_ID=2137362
PUSHER_APP_KEY=f33de668f2cc65808239
PUSHER_APP_SECRET=8f472d0c72b70d63caa3
PUSHER_APP_CLUSTER=ap1
```

### App Configuration
```
APP_NAME=E-Kantin SMK
APP_ENV=production
APP_KEY=base64:wmbUiQLN+wd6KiAeo2GPZm9WyX3iK5Zj2obwg7ChDr4=
APP_DEBUG=false
APP_URL=https://your-vercel-domain.vercel.app
```

### Database (sesuaikan dengan database lu)
```
DB_CONNECTION=mysql
DB_HOST=your-database-host
DB_PORT=3306
DB_DATABASE=your-database-name
DB_USERNAME=your-database-user
DB_PASSWORD=your-database-password
```

### Session & Cache
```
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

### VAPID Keys
```
VAPID_PUBLIC_KEY=BM85zkAF0lYhfuPyQlZCIyrahWHZvCPnjnofxS83ErmLtvmEzLfTsipe0J-aptOZHID-14cWTkTSXxAe9l1bDm8
VAPID_PRIVATE_KEY=8qmyDQQpsc0CNANMh5HLUCeg3zGgBLVFbdvJ2_82_yI
```

### Debug Mode (Production)
```
VITE_ECHO_DEBUG=false
```

---

## Step 3: Vercel Configuration Files

### 3.1 Create `vercel.json`

```json
{
  "version": 2,
  "builds": [
    {
      "src": "api/index.php",
      "use": "vercel-php@0.7.1"
    },
    {
      "src": "package.json",
      "use": "@vercel/static-build",
      "config": {
        "distDir": "public"
      }
    }
  ],
  "routes": [
    {
      "src": "/build/(.*)",
      "dest": "/public/build/$1"
    },
    {
      "src": "/storage/(.*)",
      "dest": "/public/storage/$1"
    },
    {
      "src": "/(.*\\.(css|js|json|ico|png|jpg|jpeg|gif|svg|woff|woff2|ttf|eot|mp3))",
      "dest": "/public/$1"
    },
    {
      "src": "/(.*)",
      "dest": "/api/index.php"
    }
  ],
  "env": {
    "APP_ENV": "production",
    "APP_DEBUG": "false",
    "APP_URL": "https://your-vercel-domain.vercel.app",
    "BROADCAST_CONNECTION": "pusher",
    "PUSHER_APP_ID": "@pusher_app_id",
    "PUSHER_APP_KEY": "@pusher_app_key",
    "PUSHER_APP_SECRET": "@pusher_app_secret",
    "PUSHER_APP_CLUSTER": "@pusher_app_cluster"
  }
}
```

### 3.2 Create `api/index.php`

```php
<?php

// Forward Vercel requests to public/index.php
require __DIR__ . '/../public/index.php';
```

### 3.3 Update `package.json` - Add Build Script

```json
{
  "scripts": {
    "dev": "vite",
    "build": "vite build",
    "vercel-build": "npm run build"
  }
}
```

---

## Step 4: Update vite.config.js untuk Production

Pastikan `vite.config.js` sudah benar (udah gw update sebelumnya):

```javascript
import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), '');
    
    return {
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js'],
                refresh: true,
            }),
        ],
        build: {
            manifest: true,
            outDir: 'public/build',
            rollupOptions: {
                input: {
                    app: 'resources/js/app.js',
                    css: 'resources/css/app.css',
                }
            }
        },
        define: {
            'import.meta.env.VITE_BROADCAST_CONNECTION': JSON.stringify(env.BROADCAST_CONNECTION || 'pusher'),
            'import.meta.env.VITE_PUSHER_APP_KEY': JSON.stringify(env.PUSHER_APP_KEY || ''),
            'import.meta.env.VITE_PUSHER_APP_CLUSTER': JSON.stringify(env.PUSHER_APP_CLUSTER || ''),
            'import.meta.env.VITE_REVERB_APP_KEY': JSON.stringify(env.REVERB_APP_KEY || ''),
            'import.meta.env.VITE_REVERB_HOST': JSON.stringify(env.REVERB_HOST || ''),
            'import.meta.env.VITE_REVERB_PORT': JSON.stringify(env.REVERB_PORT || '8080'),
            'import.meta.env.VITE_REVERB_SCHEME': JSON.stringify(env.REVERB_SCHEME || 'https'),
            'import.meta.env.VITE_ECHO_DEBUG': JSON.stringify(env.VITE_ECHO_DEBUG || 'false'),
        },
    };
});
```

---

## Step 5: Update .gitignore

Pastikan file-file ini di-commit:

```gitignore
# JANGAN ignore ini (perlu untuk Vercel)
# /public/build
# /public/hot

# Tetap ignore ini
/node_modules
/vendor
.env
.env.backup
.env.production
```

**PENTING**: Uncomment `/public/build` di `.gitignore` agar build assets ke-commit ke GitHub.

---

## Step 6: Build Production Assets

Sebelum push ke GitHub:

```bash
# 1. Install dependencies
npm install

# 2. Build production assets
npm run build

# 3. Verify build folder exists
ls public/build
```

Harusnya ada folder `public/build` dengan file `manifest.json` dan assets lainnya.

---

## Step 7: Update .env Lokal ke Production Mode (Testing)

Sebelum push, test dulu di lokal dengan production config:

```env
# Ganti di .env lokal
BROADCAST_CONNECTION=pusher
PUSHER_APP_ID=2137362
PUSHER_APP_KEY=f33de668f2cc65808239
PUSHER_APP_SECRET=8f472d0c72b70d63caa3
PUSHER_APP_CLUSTER=ap1
VITE_ECHO_DEBUG=false

# Comment Reverb config
# REVERB_APP_ID=local-app-id
# REVERB_APP_KEY=local-app-key
# dst...
```

Test:
```bash
# 1. Rebuild assets
npm run build

# 2. Restart Laravel
php artisan serve

# 3. Test di browser - harusnya connect ke Pusher
```

---

## Step 8: Push ke GitHub

```bash
git add .
git commit -m "Production setup with Pusher for Vercel deployment"
git push origin main
```

---

## Step 9: Deploy ke Vercel

### Via Vercel Dashboard:
1. Login ke [vercel.com](https://vercel.com)
2. Import project dari GitHub: `Radiant213/web-kantin-smecone`
3. Configure project:
   - **Framework Preset**: Other
   - **Build Command**: `npm run build`
   - **Output Directory**: `public`
   - **Install Command**: `npm install`
4. Add Environment Variables (lihat Step 2)
5. Deploy!

### Via Vercel CLI:
```bash
# Install Vercel CLI
npm i -g vercel

# Login
vercel login

# Deploy
vercel --prod
```

---

## Step 10: Verifikasi Deployment

Setelah deploy sukses:

### 1. Cek Environment Variables
Di Vercel Dashboard → Settings → Environment Variables, pastikan semua variable ada.

### 2. Test WebSocket Connection
Buka browser ke `https://your-vercel-domain.vercel.app`:

```javascript
// Buka Console (F12)
console.log('Broadcaster:', import.meta.env.VITE_BROADCAST_CONNECTION);
console.log('Pusher Key:', import.meta.env.VITE_PUSHER_APP_KEY);
console.log('Pusher Cluster:', import.meta.env.VITE_PUSHER_APP_CLUSTER);
```

Expected output:
```
Broadcaster: pusher
Pusher Key: f33de668f2cc65808239
Pusher Cluster: ap1
```

### 3. Test Order Notification
1. Login sebagai kiosk owner
2. Di browser lain, login sebagai customer
3. Create order
4. Verify kiosk owner receives notification via Pusher

### 4. Check Pusher Dashboard
Login ke [dashboard.pusher.com](https://dashboard.pusher.com) dan cek:
- Connection count
- Message activity
- Debug console

---

## Troubleshooting

### Error: "You must pass your app key"

**Cause**: Environment variables tidak terbaca di Vercel.

**Solution**:
1. Cek Vercel Dashboard → Settings → Environment Variables
2. Pastikan `PUSHER_APP_KEY` dan `PUSHER_APP_CLUSTER` ada
3. Redeploy: Vercel Dashboard → Deployments → ... → Redeploy

### Error: "Failed to load module"

**Cause**: Build assets tidak ter-generate atau tidak ke-commit.

**Solution**:
```bash
# 1. Build ulang
npm run build

# 2. Commit build folder
git add public/build
git commit -m "Add production build assets"
git push origin main
```

### Error: "WebSocket connection failed"

**Cause**: Pusher credentials salah atau Pusher app tidak aktif.

**Solution**:
1. Verify credentials di Pusher Dashboard
2. Cek Pusher app status (active/suspended)
3. Verify `PUSHER_APP_CLUSTER` benar (ap1)

### Error: "SQLSTATE[HY000] [2002] Connection refused"

**Cause**: Database tidak accessible dari Vercel.

**Solution**:
1. Gunakan external database (PlanetScale, Railway, Aiven)
2. Whitelist Vercel IP addresses
3. Update `DB_HOST`, `DB_USERNAME`, `DB_PASSWORD` di Vercel env vars

### Assets tidak load (404)

**Cause**: Vite manifest tidak ditemukan.

**Solution**:
1. Pastikan `public/build/manifest.json` exists
2. Commit build folder ke GitHub
3. Verify `vercel.json` routes benar

---

## Production Checklist

Sebelum deploy production:

- [ ] Update `.env` dengan Pusher credentials
- [ ] Set `APP_DEBUG=false`
- [ ] Set `VITE_ECHO_DEBUG=false`
- [ ] Build production assets: `npm run build`
- [ ] Test Pusher connection di lokal
- [ ] Commit `public/build` folder
- [ ] Create `vercel.json` configuration
- [ ] Create `api/index.php` entry point
- [ ] Add all environment variables di Vercel Dashboard
- [ ] Setup production database
- [ ] Test deployment di Vercel preview
- [ ] Verify WebSocket connection works
- [ ] Test order notification flow
- [ ] Check Pusher Dashboard for activity

---

## Switching Between Local (Reverb) and Production (Pusher)

### Local Development (Reverb):
```env
BROADCAST_CONNECTION=reverb
REVERB_APP_ID=local-app-id
REVERB_APP_KEY=local-app-key
REVERB_APP_SECRET=local-app-secret
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http
VITE_ECHO_DEBUG=true

# Pusher empty
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=
```

Commands:
```bash
php artisan reverb:start
npm run dev
php artisan serve
```

### Production (Pusher):
```env
BROADCAST_CONNECTION=pusher
PUSHER_APP_ID=2137362
PUSHER_APP_KEY=f33de668f2cc65808239
PUSHER_APP_SECRET=8f472d0c72b70d63caa3
PUSHER_APP_CLUSTER=ap1
VITE_ECHO_DEBUG=false

# Reverb empty atau commented
# REVERB_APP_ID=
# REVERB_APP_KEY=
# dst...
```

Commands:
```bash
npm run build
git push origin main
# Vercel auto-deploy
```

---

## Additional Resources

- [Vercel PHP Runtime](https://vercel.com/docs/runtimes#official-runtimes/php)
- [Laravel Deployment](https://laravel.com/docs/deployment)
- [Pusher Documentation](https://pusher.com/docs)
- [Vite Production Build](https://vitejs.dev/guide/build.html)

---

## Support

Jika ada error saat deployment:
1. Check Vercel deployment logs
2. Check Pusher Dashboard debug console
3. Check browser console for JavaScript errors
4. Verify all environment variables di Vercel
5. Test dengan `vercel dev` di lokal dulu
