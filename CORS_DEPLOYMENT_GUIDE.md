# CORS Deployment Guide untuk Render

## Masalah yang Diperbaiki

Konfigurasi CORS telah diperbarui untuk mengatasi error `strict-origin-when-cross-origin` saat deployment di Render.

## Perubahan yang Dilakukan

### 1. File `render.yaml`
Ditambahkan environment variables untuk CORS:
```yaml
# CORS Configuration
- key: CORS_ALLOWED_ORIGINS
  value: ${RENDER_EXTERNAL_URL}
- key: SANCTUM_STATEFUL_DOMAINS
  value: ${RENDER_EXTERNAL_HOSTNAME}
# Session Configuration for CORS
- key: SESSION_SECURE_COOKIE
  value: true
- key: SESSION_SAME_SITE
  value: none
```

### 2. File `.env.render`
Ditambahkan konfigurasi CORS untuk referensi:
```env
# CORS Configuration
CORS_ALLOWED_ORIGINS=https://your-app-name.onrender.com
SANCTUM_STATEFUL_DOMAINS=your-app-name.onrender.com

# Session Configuration for CORS
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=none
```

### 3. File `config/cors.php`
Diubah untuk menggunakan environment variables:
```php
'allowed_origins' => array_filter([
    env('CORS_ALLOWED_ORIGINS'),
    env('APP_URL'),
    'http://localhost:8000',
    'http://localhost:5173',
    'http://127.0.0.1:8000',
    'http://127.0.0.1:5173',
]),
```

## Langkah Deployment

### 1. Verifikasi Environment Variables di Render Dashboard
Pastikan environment variables berikut sudah diset di Render Dashboard:
- `CORS_ALLOWED_ORIGINS`: URL aplikasi Anda (otomatis dari `${RENDER_EXTERNAL_URL}`)
- `SANCTUM_STATEFUL_DOMAINS`: Domain aplikasi Anda (otomatis dari `${RENDER_EXTERNAL_HOSTNAME}`)
- `SESSION_SECURE_COOKIE`: `true`
- `SESSION_SAME_SITE`: `none`

### 2. Redeploy Aplikasi
1. Commit semua perubahan ke repository
2. Push ke branch yang terhubung dengan Render
3. Tunggu deployment selesai

### 3. Testing CORS
Setelah deployment:
1. Buka aplikasi frontend di browser
2. Cek Network tab di Developer Tools
3. Pastikan tidak ada error CORS
4. Verifikasi response headers mengandung:
   - `Access-Control-Allow-Origin`
   - `Access-Control-Allow-Credentials: true`

## Troubleshooting

### Jika CORS masih tidak berfungsi:

1. **Cek Environment Variables**
   ```bash
   # Di Render shell atau logs
   echo $CORS_ALLOWED_ORIGINS
   echo $APP_URL
   ```

2. **Cek Cache Laravel**
   Pastikan cache diklear setelah deployment:
   ```bash
   php artisan config:clear
   php artisan config:cache
   ```

3. **Verifikasi Middleware**
   Pastikan `HandleCors` middleware aktif di `bootstrap/app.php`

4. **Cek Response Headers**
   Gunakan curl untuk test:
   ```bash
   curl -H "Origin: https://your-frontend-domain.com" \
        -H "Access-Control-Request-Method: POST" \
        -H "Access-Control-Request-Headers: X-Requested-With" \
        -X OPTIONS \
        https://your-app.onrender.com/api/test
   ```

## Catatan Penting

- Environment variables `${RENDER_EXTERNAL_URL}` dan `${RENDER_EXTERNAL_HOSTNAME}` otomatis diset oleh Render
- Konfigurasi `SESSION_SAME_SITE=none` diperlukan untuk cross-origin requests dengan credentials
- `SESSION_SECURE_COOKIE=true` wajib untuk HTTPS deployment
- Middleware `HandleCors` sudah terdaftar di `bootstrap/app.php` untuk grup `web` dan `api`

## Verifikasi Deployment

Setelah deployment berhasil, CORS seharusnya berfungsi dengan:
- Frontend dapat mengakses API backend
- Cookies dan session berfungsi cross-origin
- Tidak ada error CORS di browser console