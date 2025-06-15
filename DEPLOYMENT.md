# Deployment Guide - Automatic APP_KEY Generation

## Overview
Proyek ini telah dikonfigurasi untuk secara otomatis generate `APP_KEY` baru setiap kali deploy, baik menggunakan Docker maupun Render. Ini memastikan keamanan aplikasi dan mengatasi masalah error 500 yang disebabkan oleh `APP_KEY` yang tidak valid.

## Fitur Otomatis

### 1. Generate APP_KEY Otomatis
- **Docker**: Script `docker-entrypoint.sh` akan generate `APP_KEY` baru setiap container dimulai
- **Render**: Script `build.sh` dan `start.sh` akan generate `APP_KEY` baru setiap deploy
- **Update .env**: File `.env` akan diupdate otomatis dengan `APP_KEY` yang baru

### 2. Database Setup Otomatis
- Membuat file `database/database.sqlite` jika belum ada
- Menjalankan migrasi database otomatis
- Membuat tabel sessions untuk database sessions
- Mengatur permissions yang tepat

### 3. Production Optimization
- Cache konfigurasi Laravel
- Cache routes
- Cache views
- Optimasi untuk environment production

## File yang Dimodifikasi

### 1. `docker-entrypoint.sh` (Baru)
- Script entrypoint untuk Docker container
- Generate `APP_KEY` otomatis
- Update file `.env`
- Setup database dan migrasi
- Start Laravel server

### 2. `Dockerfile`
- Menggunakan `docker-entrypoint.sh` sebagai entrypoint
- Menggantikan `CMD` dengan `ENTRYPOINT`

### 3. `build.sh`
- Ditambahkan proses generate `APP_KEY`
- Membuat tabel sessions
- Update file `.env` jika ada

### 4. `start.sh`
- Ditambahkan proses generate `APP_KEY`
- Update file `.env` jika ada

### 5. `render.yaml`
- Environment variables lengkap
- `APP_KEY` dengan placeholder yang akan di-generate

## Cara Deploy

### Docker
```bash
# Build image
docker build -t howlson .

# Run container
docker run -p 8000:8000 howlson
```

### Render
1. Push code ke repository
2. Render akan otomatis menjalankan `build.sh`
3. Kemudian menjalankan `start.sh`
4. `APP_KEY` akan di-generate otomatis

## Environment Variables

Semua environment variables sudah dikonfigurasi di `render.yaml`:

- `APP_KEY`: Akan di-generate otomatis
- `DB_CONNECTION`: sqlite
- `DB_DATABASE`: database/database.sqlite
- `SESSION_DRIVER`: database
- `CACHE_STORE`: database
- `QUEUE_CONNECTION`: database
- Dan lainnya...

## Deployment Steps untuk Render

### 1. Create a New Web Service

1. Log in to your Render dashboard
2. Click "New +" and select "Web Service"
3. Connect your Git repository
4. Configure the service:
   - **Name**: `howlson` (or your preferred name)
   - **Environment**: `Node`
   - **Build Command**: `./build.sh`
   - **Start Command**: `./start.sh`
   - **Instance Type**: Free tier is sufficient for testing

### 2. Environment Variables (Opsional)

Jika Anda ingin override environment variables default, tambahkan di Render dashboard. Namun, semua sudah dikonfigurasi di `render.yaml`.

### 3. Deploy

1. Click "Create Web Service"
2. Render akan otomatis menjalankan deployment
3. `APP_KEY` akan di-generate otomatis
4. Database akan disetup otomatis
5. Aplikasi akan tersedia di `https://your-service-name.onrender.com`

## Troubleshooting

### Error 500 - Internal Server Error
If you encounter a 500 error after deployment:

1. **Check APP_KEY**: Make sure APP_KEY is properly generated
   ```bash
   # For Render deployment, check logs for:
   # "Generated APP_KEY: base64:..."
   ```

2. **Check Database**: Ensure SQLite database is created and accessible
   ```bash
   # Check if database file exists
   ls -la database/database.sqlite
   ```

3. **Check Permissions**: Ensure proper file permissions
   ```bash
   # Set correct permissions
   chmod 664 database/database.sqlite
   chmod 775 database/
   chmod -R 775 storage/
   ```

### Docker Build Error: "cannot stat '.env.example'"
If you encounter this error during Docker deployment:

1. **Check .dockerignore**: Ensure `.env.example` is not excluded
   - The file should be available in the Docker build context
   - Remove `.env.example` from `.dockerignore` if present

2. **Fallback Solution**: The `docker-entrypoint.sh` script now includes a fallback
   - If `.env.example` is missing, it creates a basic `.env` file
   - This ensures the container can start even without `.env.example`

3. **Manual Fix**: If the error persists
   ```bash
   # Ensure .env.example exists in your project root
   # Or the script will create a basic .env file automatically
   ```

### Database Error: "Database file does not exist"
If you encounter SQLite database path errors:

1. **Absolute Path Issue**: The database path must be absolute
   - Docker: Uses `/var/www/howlson/database/database.sqlite`
   - Render: Uses `$(pwd)/database/database.sqlite`
   - Both deployment scripts now automatically set absolute paths

2. **Check Database Creation**: Ensure the database file is created
   ```bash
   # Check if database file exists
   ls -la database/database.sqlite
   # Should show the file with proper permissions
   ```

3. **Environment Variable**: Verify DB_DATABASE in .env
   ```bash
   # Should be absolute path, not relative
   DB_DATABASE=/var/www/howlson/database/database.sqlite  # Docker
   DB_DATABASE=/opt/render/project/src/database/database.sqlite  # Render
   ```

### Build Gagal

1. Cek logs di Render dashboard
2. Pastikan semua dependencies ada di `composer.json` dan `package.json`
3. Pastikan PHP version compatibility (PHP 8.2)
4. Pastikan bun terinstall dengan benar di environment

### Database Connection Error

1. Pastikan environment variables database sudah benar (DB_CONNECTION=sqlite)
2. Pastikan file database SQLite terbuat dengan permission yang benar
3. Cek apakah direktori database memiliki permission write

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