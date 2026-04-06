# Vercel Deployment Checklist

## ✅ Pre-Deployment Checklist

### 1. Build Production Assets
```bash
npm run build
```
Verify: `public/build/manifest.json` exists

### 2. Test Pusher Locally (Optional)
Update `.env`:
```env
BROADCAST_CONNECTION=pusher
PUSHER_APP_ID=2137362
PUSHER_APP_KEY=f33de668f2cc65808239
PUSHER_APP_SECRET=8f472d0c72b70d63caa3
PUSHER_APP_CLUSTER=ap1
VITE_ECHO_DEBUG=false
```

Rebuild & test:
```bash
npm run build
php artisan serve
```

### 3. Commit & Push
```bash
git add .
git commit -m "Production setup for Vercel with Pusher"
git push origin main
```

---

## 🚀 Vercel Dashboard Setup

### Environment Variables to Add:

Copy-paste ini ke Vercel Dashboard → Settings → Environment Variables:

```
BROADCAST_CONNECTION=pusher
PUSHER_APP_ID=2137362
PUSHER_APP_KEY=f33de668f2cc65808239
PUSHER_APP_SECRET=8f472d0c72b70d63caa3
PUSHER_APP_CLUSTER=ap1
APP_ENV=production
APP_DEBUG=false
VITE_ECHO_DEBUG=false
```

**IMPORTANT**: Jangan lupa set environment untuk "Production", "Preview", dan "Development"

---

## 📋 Files Created/Updated

✅ `vercel.json` - Vercel configuration
✅ `api/index.php` - Entry point for Vercel
✅ `package.json` - Added `vercel-build` script
✅ `vite.config.js` - Added production build config
✅ `.env.production.example` - Production environment template
✅ `VERCEL_DEPLOYMENT.md` - Full deployment guide

---

## 🔍 Post-Deployment Verification

### 1. Check Deployment Logs
Vercel Dashboard → Deployments → Latest → View Function Logs

### 2. Test WebSocket Connection
Open browser console di production URL:
```javascript
console.log('Broadcaster:', import.meta.env.VITE_BROADCAST_CONNECTION);
console.log('Pusher Key:', import.meta.env.VITE_PUSHER_APP_KEY);
```

Expected:
```
Broadcaster: pusher
Pusher Key: f33de668f2cc65808239
```

### 3. Test Order Flow
1. Login as kiosk owner
2. Create order from another browser
3. Verify notification received via Pusher

### 4. Check Pusher Dashboard
https://dashboard.pusher.com → Your App → Debug Console
- Should see connection events
- Should see message broadcasts

---

## 🐛 Common Issues & Solutions

### Issue: "You must pass your app key"
**Solution**: Add `PUSHER_APP_KEY` to Vercel environment variables and redeploy

### Issue: Assets not loading (404)
**Solution**: 
```bash
npm run build
git add public/build
git commit -m "Add build assets"
git push origin main
```

### Issue: Database connection failed
**Solution**: Setup external database (PlanetScale, Railway, Aiven) and update `DB_*` env vars in Vercel

---

## 📚 Documentation

Full guide: `.kiro/specs/websocket-debugging-fix/VERCEL_DEPLOYMENT.md`

---

## 🎯 Quick Deploy Commands

```bash
# 1. Build
npm run build

# 2. Commit
git add .
git commit -m "Production build"
git push origin main

# 3. Vercel will auto-deploy from GitHub
```

---

## ✨ Success Indicators

- ✅ Vercel deployment status: "Ready"
- ✅ Browser console shows Pusher connection
- ✅ Order notifications work in production
- ✅ Pusher Dashboard shows activity
- ✅ No JavaScript errors in console
