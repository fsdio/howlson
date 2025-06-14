# Deployment Guide untuk Render.com

Panduan ini akan membantu Anda melakukan deployment aplikasi Laravel Vue ke Render.com.

## Persiapan Sebelum Deploy

### 1. Pastikan Semua File Deployment Sudah Ada

File-file berikut sudah dibuat untuk deployment:
- `render.yaml` - Konfigurasi service Render
- `Dockerfile` - Container configuration dengan bun
- `build.sh` - Script build untuk production menggunakan bun
- `start.sh` - Script start aplikasi
- `.env.render` - Template environment variables

### 2. Push Code ke Repository Git

Pastikan semua perubahan sudah di-commit dan push ke repository Git (GitHub, GitLab, atau Bitbucket):

```bash
git add .
git commit -m "Add Render.com deployment configuration"
git push origin main
```

## Langkah-langkah Deployment

### 1. Buat Akun di Render.com

1. Kunjungi [render.com](https://render.com)
2. Daftar atau login dengan akun GitHub/GitLab/Bitbucket
3. Connect repository Anda

### 2. Deploy Database (PostgreSQL)

1. Di dashboard Render, klik "New +"
2. Pilih "PostgreSQL"
3. Isi konfigurasi:
   - **Name**: `howlson-db`
   - **Database**: `howlson`
   - **User**: `howlson`
   - **Plan**: Free (atau sesuai kebutuhan)
4. Klik "Create Database"
5. Tunggu hingga database selesai dibuat
6. Catat connection details (host, port, database, user, password)

### 3. Deploy Web Service

1. Di dashboard Render, klik "New +"
2. Pilih "Web Service"
3. Connect repository Anda
4. Isi konfigurasi:
   - **Name**: `howlson`
   - **Environment**: `Docker`
   - **Plan**: Free (atau sesuai kebutuhan)
   - **Branch**: `main`

### 4. Konfigurasi Environment Variables

Tambahkan environment variables berikut di settings web service:

```
APP_NAME=Howlson
APP_ENV=production
APP_KEY=[Generate new key]
APP_DEBUG=false
APP_URL=https://howlson.onrender.com

LOG_CHANNEL=errorlog
LOG_LEVEL=error

DB_CONNECTION=pgsql
DB_HOST=[Database host dari step 2]
DB_PORT=5432
DB_DATABASE=howlson
DB_USERNAME=[Database username dari step 2]
DB_PASSWORD=[Database password dari step 2]

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false

CACHE_STORE=database
QUEUE_CONNECTION=database
BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
```

### 5. Generate APP_KEY

Untuk generate APP_KEY baru:
1. Jalankan `php artisan key:generate --show` di local
2. Copy hasilnya ke environment variable `APP_KEY`

### 6. Deploy

1. Klik "Create Web Service"
2. Render akan otomatis:
   - Clone repository
   - Build aplikasi menggunakan Dockerfile
   - Deploy ke production

### 7. Verifikasi Deployment

1. Tunggu hingga build selesai (biasanya 5-10 menit)
2. Akses URL aplikasi: `https://howlson.onrender.com`
3. Pastikan aplikasi berjalan dengan baik

## Troubleshooting

### Build Gagal

1. Cek logs di Render dashboard
2. Pastikan semua dependencies ada di `composer.json` dan `package.json`
3. Pastikan PHP version compatibility (PHP 8.2)
4. Pastikan bun terinstall dengan benar di environment

### Database Connection Error

1. Pastikan environment variables database sudah benar
2. Cek apakah database service sudah running
3. Pastikan database credentials sesuai

### Assets Tidak Load

1. Pastikan `bun run build` berhasil
2. Cek konfigurasi `APP_URL` di environment variables
3. Pastikan Vite build configuration sudah benar
4. Verifikasi bahwa bun lockfile (`bun.lockb`) ter-commit ke repository

## Konfigurasi Custom Domain (Opsional)

1. Di settings web service, klik "Custom Domains"
2. Tambahkan domain Anda
3. Update DNS records sesuai instruksi Render
4. Update `APP_URL` di environment variables

## Auto-Deploy

Render akan otomatis deploy ulang setiap kali ada push ke branch `main`. Untuk disable auto-deploy:
1. Masuk ke service settings
2. Matikan "Auto-Deploy"

## Monitoring

- **Logs**: Tersedia di dashboard Render
- **Metrics**: CPU, Memory usage tersedia di dashboard
- **Health Checks**: Render otomatis monitor aplikasi

## Tips Optimasi

1. **Caching**: Gunakan Redis untuk session dan cache (upgrade plan)
2. **CDN**: Gunakan Cloudflare untuk static assets
3. **Database**: Upgrade ke paid plan untuk performa lebih baik
4. **Monitoring**: Setup monitoring eksternal (UptimeRobot, etc.)

## Support

Jika mengalami masalah:
1. Cek dokumentasi Render: [docs.render.com](https://docs.render.com)
2. Cek Laravel deployment guide
3. Contact support Render jika diperlukan