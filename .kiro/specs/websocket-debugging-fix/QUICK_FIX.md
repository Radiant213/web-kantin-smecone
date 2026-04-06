# Quick Fix - Error "You must pass your app key when you instantiate Pusher"

## Masalah
Error masih muncul karena Vite dev server belum reload environment variables yang baru.

## Solusi - WAJIB DILAKUKAN:

### 1. Stop Vite Dev Server
Tekan `Ctrl+C` di terminal yang running `npm run dev`

### 2. Restart Vite Dev Server
```bash
npm run dev
```

### 3. Hard Refresh Browser
- Windows/Linux: `Ctrl + Shift + R` atau `Ctrl + F5`
- Mac: `Cmd + Shift + R`

### 4. Clear Browser Cache (Optional tapi recommended)
- Buka DevTools (F12)
- Klik kanan tombol refresh
- Pilih "Empty Cache and Hard Reload"

## Verifikasi

Setelah restart, buka browser console dan ketik:

```javascript
console.log('Broadcaster:', import.meta.env.VITE_BROADCAST_CONNECTION);
console.log('Reverb Key:', import.meta.env.VITE_REVERB_APP_KEY);
console.log('Reverb Host:', import.meta.env.VITE_REVERB_HOST);
console.log('Pusher Key:', import.meta.env.VITE_PUSHER_APP_KEY);
```

**Expected Output:**
```
Broadcaster: reverb
Reverb Key: local-app-key
Reverb Host: localhost
Pusher Key: (empty string)
```

## Jika Masih Error

### Cek 1: Pastikan Reverb Server Running
```bash
php artisan reverb:start
```

Harusnya muncul:
```
INFO  Reverb server started on http://localhost:8080
```

### Cek 2: Pastikan .env Benar
File `.env` harus punya:
```env
BROADCAST_CONNECTION=reverb
REVERB_APP_ID=local-app-id
REVERB_APP_KEY=local-app-key
REVERB_APP_SECRET=local-app-secret
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http
VITE_ECHO_DEBUG=true

# Pusher harus empty atau commented
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=
```

### Cek 3: Clear Laravel Cache
```bash
php artisan config:clear
php artisan cache:clear
```

### Cek 4: Rebuild Vite
```bash
# Stop npm run dev (Ctrl+C)

# Windows PowerShell:
Remove-Item -Recurse -Force node_modules\.vite -ErrorAction SilentlyContinue

# Atau pake File Explorer:
# Hapus folder node_modules\.vite secara manual

# Restart
npm run dev
```

## Debug Mode

Dengan `VITE_ECHO_DEBUG=true`, lu harusnya liat di console:

```
[Echo Debug] Initializing Echo { broadcaster: 'reverb', hasKey: true, retryCount: 0 }
[Echo Debug] Echo configuration { broadcaster: 'reverb', key: 'local-app-key', wsHost: 'localhost', ... }
[Echo Debug] Echo initialized successfully
[Echo Debug] WebSocket connected
```

## Catatan Penting

⚠️ **WAJIB RESTART VITE** setiap kali ganti .env file!

Vite cuma baca environment variables saat startup. Kalo lu ganti .env tapi gak restart Vite, dia masih pake nilai lama.

## Troubleshooting Tambahan

### Error: "WebSocket connection failed"
- Pastikan Reverb server running: `php artisan reverb:start`
- Cek port 8080 gak dipake aplikasi lain

### Error: "VITE_REVERB_APP_KEY is not defined"
- Restart Vite dev server
- Clear browser cache
- Cek vite.config.js ada `define` section

### Modal muncul tapi subtotal kosong
- Ini normal kalo WebSocket belum connect
- Tunggu sampai console show "WebSocket connected"
- Coba create order lagi
