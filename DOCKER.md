# Docker Deployment Guide

Panduan lengkap untuk menjalankan aplikasi Howlson menggunakan Docker.

## Prerequisites

- Docker dan Docker Compose terinstall
- File `.env` sudah dikonfigurasi dengan benar

## Perubahan Konfigurasi Docker

### 1. Environment File (.env)

File `.env` sekarang **disertakan** dalam Docker image untuk memudahkan deployment:

- File `.env` akan di-copy ke dalam container
- Konfigurasi database menggunakan path relatif: `database/database.sqlite`
- Environment variables akan diupdate otomatis oleh `docker-entrypoint.sh`

### 2. Database Configuration

```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

### 3. Production Settings

Docker container akan otomatis mengatur:

```env
APP_ENV=production
APP_DEBUG=false
LOG_CHANNEL=errorlog
LOG_LEVEL=error
```

## Build dan Run

### 1. Build Docker Image

```bash
docker build -t howlson-app .
```

### 2. Run Container

```bash
# Run dengan port default (8000)
docker run -p 8000:8000 howlson-app

# Run dengan custom port
docker run -p 3000:8000 -e PORT=8000 howlson-app

# Run dengan custom APP_KEY
docker run -p 8000:8000 -e APP_KEY="your-app-key" howlson-app
```

### 3. Run dengan Docker Compose (Opsional)

Buat file `docker-compose.yml`:

```yaml
version: '3.8'
services:
  app:
    build: .
    ports:
      - "8000:8000"
    environment:
      - APP_KEY=${APP_KEY}
      - APP_ENV=production
      - APP_DEBUG=false
    volumes:
      - ./storage:/var/www/howlson/storage
      - ./database:/var/www/howlson/database
```

Jalankan dengan:

```bash
docker-compose up -d
```

## Environment Variables

### Required Variables

- `APP_KEY`: Laravel application key (akan di-generate otomatis jika tidak ada)
- `PORT`: Port untuk server (default: 8000)

### Optional Variables

- `APP_ENV`: Environment (default: production)
- `APP_DEBUG`: Debug mode (default: false)
- `LOG_LEVEL`: Log level (default: error)

## Database

- SQLite database akan dibuat otomatis di `/var/www/howlson/database/database.sqlite`
- Migrations akan dijalankan otomatis saat container start
- Database file akan persist selama container berjalan

## Troubleshooting

### 1. Database Permission Issues

```bash
# Check database file permissions
docker exec -it <container-id> ls -la /var/www/howlson/database/

# Fix permissions if needed
docker exec -it <container-id> chown www-data:www-data /var/www/howlson/database/database.sqlite
docker exec -it <container-id> chmod 664 /var/www/howlson/database/database.sqlite
```

### 2. View Logs

```bash
# Container logs
docker logs <container-id>

# Laravel logs
docker exec -it <container-id> tail -f /var/www/howlson/storage/logs/laravel.log
```

### 3. Access Container Shell

```bash
docker exec -it <container-id> bash
```

## Production Deployment

### 1. Build untuk Production

```bash
# Build dengan tag production
docker build -t howlson-app:production .

# Push ke registry (jika menggunakan)
docker tag howlson-app:production your-registry/howlson-app:latest
docker push your-registry/howlson-app:latest
```

### 2. Environment Variables untuk Production

```bash
docker run -d \
  --name howlson-production \
  -p 80:8000 \
  -e APP_KEY="your-production-app-key" \
  -e APP_ENV=production \
  -e APP_DEBUG=false \
  -e APP_URL="https://yourdomain.com" \
  -v /host/path/storage:/var/www/howlson/storage \
-v /host/path/database:/var/www/howlson/database \
  howlson-app:production
```

## Security Notes

1. **APP_KEY**: Pastikan menggunakan APP_KEY yang unik untuk production
2. **Database**: Gunakan volume mounting untuk persist data
3. **Logs**: Monitor logs secara berkala
4. **Updates**: Update image secara berkala untuk security patches

## File Structure dalam Container

```
/var/www/
├── .env                 # Environment file
├── app/                 # Laravel application
├── database/
│   └── database.sqlite  # SQLite database
├── storage/             # Laravel storage
├── public/              # Public assets
└── ...
```

## Monitoring

### Health Check

```bash
# Check if application is running
curl http://localhost:8000

# Check database connection
docker exec -it <container-id> php artisan tinker --execute="DB::connection()->getPdo();"
```

### Performance Monitoring

```bash
# Container stats
docker stats <container-id>

# Memory usage
docker exec -it <container-id> free -h

# Disk usage
docker exec -it <container-id> df -h
```