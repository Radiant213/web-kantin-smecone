# WebSocket Setup Guide

This guide explains how to configure and troubleshoot WebSocket connections in the E-Kantin system. The application supports two broadcasters: **Reverb** (recommended for development) and **Pusher** (for production).

## Table of Contents

1. [Overview](#overview)
2. [Development Setup (Reverb)](#development-setup-reverb)
3. [Production Setup (Pusher)](#production-setup-pusher)
4. [Environment Variables](#environment-variables)
5. [Testing WebSocket Functionality](#testing-websocket-functionality)
6. [Troubleshooting](#troubleshooting)
7. [Debugging Tools](#debugging-tools)

## Overview

The E-Kantin system uses WebSocket connections for real-time notifications:
- **OrderMasuk**: Notifies kiosk owners when new orders arrive
- **OrderStatusUpdated**: Notifies customers when order status changes

### Architecture

- **Backend**: Laravel Broadcasting with Reverb or Pusher driver
- **Frontend**: Laravel Echo with Pusher.js client library
- **Channels**: Private channels with authentication (`kios.{id}`, `user.{id}`)

## Development Setup (Reverb)

Reverb is Laravel's first-party WebSocket server, ideal for local development.

### 1. Install Reverb

```bash
composer require laravel/reverb
php artisan reverb:install
```

### 2. Configure Environment Variables

Update your `.env` file:

```env
# Broadcasting
BROADCAST_CONNECTION=reverb

# Reverb Configuration
REVERB_APP_ID=local-app-id
REVERB_APP_KEY=local-app-key
REVERB_APP_SECRET=local-app-secret
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http

# Enable debug logging (optional)
VITE_ECHO_DEBUG=true
```

### 3. Start Reverb Server

```bash
php artisan reverb:start
```

You should see:
```
INFO  Reverb server started on http://localhost:8080
```

### 4. Start Development Server

In a separate terminal:

```bash
npm run dev
```

### 5. Verify Connection

Open your browser console and look for:
```
[Echo Debug] Initializing Echo { broadcaster: 'reverb', hasKey: true, retryCount: 0 }
[Echo Debug] Echo initialized successfully
[Echo Debug] WebSocket connected
```

## Production Setup (Pusher)

Pusher is a managed WebSocket service for production deployments.

### 1. Create Pusher Account

1. Sign up at [pusher.com](https://pusher.com)
2. Create a new Channels app
3. Note your credentials: App ID, Key, Secret, Cluster

### 2. Configure Environment Variables

Update your `.env` file:

```env
# Broadcasting
BROADCAST_CONNECTION=pusher

# Pusher Configuration
PUSHER_APP_ID=your-app-id
PUSHER_APP_KEY=your-app-key
PUSHER_APP_SECRET=your-app-secret
PUSHER_APP_CLUSTER=your-cluster

# Disable debug logging in production
VITE_ECHO_DEBUG=false
```

### 3. Rebuild Frontend Assets

```bash
npm run build
```

### 4. Deploy Application

Deploy your application with the updated `.env` configuration. No separate WebSocket server is needed - Pusher handles all connections.

## Environment Variables

### Backend Variables (Laravel)

| Variable | Description | Example |
|----------|-------------|---------|
| `BROADCAST_CONNECTION` | Broadcaster driver | `reverb` or `pusher` |
| `REVERB_APP_ID` | Reverb application ID | `local-app-id` |
| `REVERB_APP_KEY` | Reverb application key | `local-app-key` |
| `REVERB_APP_SECRET` | Reverb application secret | `local-app-secret` |
| `REVERB_HOST` | Reverb server host | `localhost` |
| `REVERB_PORT` | Reverb server port | `8080` |
| `REVERB_SCHEME` | Reverb connection scheme | `http` or `https` |
| `PUSHER_APP_ID` | Pusher application ID | `123456` |
| `PUSHER_APP_KEY` | Pusher application key | `abc123def456` |
| `PUSHER_APP_SECRET` | Pusher application secret | `secret123` |
| `PUSHER_APP_CLUSTER` | Pusher cluster region | `ap1`, `us2`, `eu` |

### Frontend Variables (Vite)

The frontend automatically reads broadcaster configuration from backend environment variables via `vite.config.js`. You only need to set:

| Variable | Description | Example |
|----------|-------------|---------|
| `VITE_ECHO_DEBUG` | Enable debug logging | `true` or `false` |

**Note**: The `vite.config.js` file automatically exposes backend variables to the frontend using the `define` option. You do NOT need to manually set `VITE_PUSHER_APP_KEY` or similar variables - they are automatically populated from `PUSHER_APP_KEY`, etc.

## Testing WebSocket Functionality

### 1. Test OrderMasuk Event

1. Log in as a kiosk owner
2. Navigate to the orders page
3. In another browser/incognito window, log in as a customer
4. Place a new order for the kiosk
5. Verify the kiosk owner receives:
   - Audio notification
   - Modal popup with order details
   - Page auto-refresh

### 2. Test OrderStatusUpdated Event

1. Log in as a customer
2. Navigate to your orders page
3. In another browser/incognito window, log in as kiosk owner
4. Update the order status (e.g., from "pending" to "processing")
5. Verify the customer receives:
   - Real-time status update on the page
   - Notification message

### 3. Check Backend Logs

With `APP_DEBUG=true`, check `storage/logs/laravel.log` for:

```
[INFO] OrderMasuk event broadcasting
{
  "event": "OrderMasuk",
  "channel": "kios.1",
  "order_id": 42,
  "kiosk_id": 1,
  "user_id": 5,
  "status": "pending",
  "total": 25000
}
```

### 4. Check Browser Console

With `VITE_ECHO_DEBUG=true`, check browser console for:

```
[Echo Debug] Initializing Echo
[Echo Debug] Echo configuration
[Echo Debug] Echo initialized successfully
[Echo Debug] WebSocket connected
[Echo Debug] Connection state change { previous: 'connecting', current: 'connected' }
```

## Troubleshooting

### Error: "You must pass your app key when you instantiate Pusher"

**Cause**: Environment variables are not loaded correctly by Vite.

**Solution**:
1. Verify `.env` file has correct broadcaster credentials
2. Restart Vite dev server: `npm run dev`
3. Check `vite.config.js` has `define` configuration
4. Verify browser console shows correct values:
   ```javascript
   console.log(import.meta.env.VITE_BROADCAST_CONNECTION);
   console.log(import.meta.env.VITE_PUSHER_APP_KEY); // or VITE_REVERB_APP_KEY
   ```

### Error: "WebSocket connection failed"

**Cause**: Reverb server is not running or network connectivity issue.

**Solution**:
1. For Reverb: Ensure `php artisan reverb:start` is running
2. Check Reverb server logs for errors
3. Verify `REVERB_HOST` and `REVERB_PORT` match the running server
4. Check firewall settings allow connections to port 8080

### Error: "403 Forbidden" when subscribing to channel

**Cause**: Channel authorization failed.

**Solution**:
1. Verify user is authenticated (logged in)
2. Check `routes/channels.php` authorization logic
3. For `kios.{id}`: Verify user owns the kiosk
4. For `user.{id}`: Verify user ID matches authenticated user
5. Check Laravel logs for authorization errors

### Events not received on frontend

**Cause**: Multiple possible issues.

**Solution**:
1. Verify WebSocket connection is established (check browser console)
2. Verify event is being broadcast (check Laravel logs with `APP_DEBUG=true`)
3. Verify channel name matches between backend and frontend
4. Verify event listener is attached correctly:
   ```javascript
   Echo.private('kios.1').listen('OrderMasuk', (e) => {
       console.log('Received OrderMasuk', e);
   });
   ```
5. Check browser Network tab for WebSocket frames

### Connection keeps disconnecting

**Cause**: Network instability or server timeout.

**Solution**:
1. Check network connectivity
2. For Reverb: Increase timeout in `config/reverb.php`
3. For Pusher: Check Pusher dashboard for connection limits
4. Enable debug logging to see disconnection reasons

### Variable interpolation not working

**Cause**: Vite does not support shell-style variable interpolation in `.env` files.

**Solution**:
- ❌ **WRONG**: `VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"`
- ✅ **CORRECT**: Use `vite.config.js` with `define` option (already configured)

The `vite.config.js` file automatically reads backend variables and exposes them to the frontend. You do NOT need to manually set `VITE_*` variables with interpolation.

## Debugging Tools

### Enable Debug Mode

Set in `.env`:
```env
VITE_ECHO_DEBUG=true
```

Restart Vite dev server:
```bash
npm run dev
```

### Debug Logging Output

With debug mode enabled, you'll see detailed logs in the browser console:

```
[Echo Debug 2024-01-15T10:30:45.123Z] Initializing Echo { broadcaster: 'reverb', hasKey: true, retryCount: 0 }
[Echo Debug 2024-01-15T10:30:45.234Z] Echo configuration { broadcaster: 'reverb', key: 'local-app-key', wsHost: 'localhost', ... }
[Echo Debug 2024-01-15T10:30:45.345Z] Echo initialized successfully
[Echo Debug 2024-01-15T10:30:45.456Z] WebSocket connected
[Echo Debug 2024-01-15T10:30:45.567Z] Connection state change { previous: 'connecting', current: 'connected' }
```

### Check Connection Status

In browser console:
```javascript
// Check if Echo is initialized
console.log(window.Echo);

// Check connection state
console.log(window.Echo.connector.pusher.connection.state);

// Check subscribed channels
console.log(window.Echo.connector.channels);
```

### Monitor WebSocket Frames

1. Open browser DevTools
2. Go to Network tab
3. Filter by "WS" (WebSocket)
4. Click on the WebSocket connection
5. View "Messages" tab to see frames

### Backend Logging

With `APP_DEBUG=true`, Laravel automatically logs:
- Event broadcasting (OrderMasuk, OrderStatusUpdated)
- Channel authorization attempts
- Broadcasting errors

Check `storage/logs/laravel.log` for detailed information.

## Switching Between Reverb and Pusher

### Development → Production

1. Update `.env`:
   ```env
   BROADCAST_CONNECTION=pusher
   PUSHER_APP_ID=your-app-id
   PUSHER_APP_KEY=your-app-key
   PUSHER_APP_SECRET=your-app-secret
   PUSHER_APP_CLUSTER=your-cluster
   VITE_ECHO_DEBUG=false
   ```

2. Rebuild frontend:
   ```bash
   npm run build
   ```

3. Deploy application

### Production → Development

1. Update `.env`:
   ```env
   BROADCAST_CONNECTION=reverb
   REVERB_APP_ID=local-app-id
   REVERB_APP_KEY=local-app-key
   REVERB_APP_SECRET=local-app-secret
   REVERB_HOST=localhost
   REVERB_PORT=8080
   REVERB_SCHEME=http
   VITE_ECHO_DEBUG=true
   ```

2. Start Reverb server:
   ```bash
   php artisan reverb:start
   ```

3. Start dev server:
   ```bash
   npm run dev
   ```

## Additional Resources

- [Laravel Broadcasting Documentation](https://laravel.com/docs/broadcasting)
- [Laravel Reverb Documentation](https://laravel.com/docs/reverb)
- [Laravel Echo Documentation](https://laravel.com/docs/broadcasting#client-side-installation)
- [Pusher Documentation](https://pusher.com/docs)

## Support

If you encounter issues not covered in this guide:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Check browser console for JavaScript errors
3. Enable debug mode: `VITE_ECHO_DEBUG=true`
4. Review the troubleshooting section above
