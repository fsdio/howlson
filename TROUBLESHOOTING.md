# Panduan Troubleshooting - Howlson Laravel Project

## Error 502 Bad Gateway di Render

### Penyebab Umum:
1. **Path Database Salah**: Path absolut `/opt/render/project/src/database/database.sqlite` tidak valid
2. **Environment Variables Tidak Lengkap**: APP_KEY atau PORT tidak diset
3. **Permission Issues**: File database atau direktori storage tidak memiliki permission yang benar
4. **Build Process Gagal**: Dependencies tidak terinstall dengan benar

### Solusi yang Sudah Diterapkan:

#### 1. Perbaikan Path Database
- **Sebelum**: `/opt/render/project/src/database/database.sqlite`
- **Sesudah**: `database/database.sqlite` (relative path)
- **File yang diperbaiki**: `render.yaml`, `build.sh`, `start.sh`, `.env.render`

#### 2. Perbaikan Environment Variables
- Menghapus duplikasi environment variables di `render.yaml`
- Menambahkan environment variables yang hilang:
  - `SESSION_LIFETIME=120`
  - `SESSION_ENCRYPT=false`
  - `BCRYPT_ROUNDS=12`

#### 3. Perbaikan Build Process
- Menambahkan setup direktori storage yang lengkap
- Memperbaiki permission setting
- Menggunakan relative path untuk database

### Langkah Deploy Ulang:

1. **Push perubahan ke repository**:
   ```bash
   git add .
   git commit -m "Fix 502 Bad Gateway - Update database paths and environment config"
   git push origin main
   ```

2. **Di Render Dashboard**:
   - Buka service Anda
   - Klik "Manual Deploy" untuk trigger build ulang
   - Monitor logs untuk memastikan build berhasil

3. **Verifikasi Environment Variables**:
   Pastikan environment variables berikut sudah diset di Render Dashboard:
   ```
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=base64:GENERATE_NEW_KEY_HERE
   DB_CONNECTION=sqlite
   DB_DATABASE=database/database.sqlite
   SESSION_DRIVER=database
   CACHE_STORE=database
   QUEUE_CONNECTION=database
   LOG_CHANNEL=errorlog
   LOG_LEVEL=error
   SESSION_LIFETIME=120
   SESSION_ENCRYPT=false
   BCRYPT_ROUNDS=12
   ```

### Monitoring dan Debugging:

#### 1. Cek Logs di Render
- Buka Render Dashboard → Service → Logs
- Perhatikan error messages saat build dan startup
- Cari pesan error seperti:
  - "Database connection failed"
  - "APP_KEY is not set"
  - "Permission denied"

#### 2. Test Database Connection
Jika masih ada masalah database, cek di logs apakah ada pesan:
```
Database connection OK
```

#### 3. Verifikasi File Structure
Pastikan struktur file setelah build:
```
/
├── database/
│   └── database.sqlite
├── storage/
│   ├── logs/
│   └── framework/
│       ├── cache/
│       ├── sessions/
│       └── views/
└── bootstrap/
    └── cache/
```

### Masalah Lain yang Mungkin Terjadi:

#### 1. Build Timeout
**Gejala**: Build process terhenti di tengah jalan
**Solusi**: 
- Gunakan plan yang lebih tinggi di Render
- Optimasi dependencies di `package.json`

#### 2. Memory Issues
**Gejala**: Application crash dengan out of memory
**Solusi**:
- Tambahkan `memory_limit` di PHP configuration
- Optimasi cache configuration

#### 3. Asset Build Gagal
**Gejala**: Frontend assets tidak ter-build
**Solusi**:
- Cek `bun run build` berhasil
- Verifikasi `vite.config.ts` configuration

### Kontak dan Support:

Jika masalah masih berlanjut:
1. Cek logs detail di Render Dashboard
2. Pastikan semua environment variables sudah benar
3. Coba deploy ulang dengan "Clear build cache"
4. Hubungi support Render jika diperlukan

### Changelog Perbaikan:

**v1.1.0 - Fix 502 Bad Gateway**
- ✅ Perbaiki path database dari absolute ke relative
- ✅ Hapus duplikasi environment variables
- ✅ Tambah environment variables yang hilang
- ✅ Perbaiki permission setting
- ✅ Optimasi build process
- ✅ Update dokumentasi troubleshooting

**Tested on**: Render Free Plan
**Laravel Version**: 12.x
**PHP Version**: 8.2+
**Node Version**: Latest LTS