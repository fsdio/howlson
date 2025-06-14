# Howlson - Laravel Application

A modern Laravel application with Vue.js frontend, designed for deployment on Render.

## 🚀 Features

- Laravel 11 backend
- Vue.js 3 with Inertia.js frontend
- SQLite database for simplicity
- Role-based permissions system
- Product management system
- Blog functionality
- Responsive design with Tailwind CSS

## 📋 Prerequisites

- PHP 8.2+
- Composer
- Node.js 18+
- Bun (for faster package management)

## 🛠️ Local Development Setup

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd howlson
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   bun install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database setup**
   ```bash
   touch database/database.sqlite
   php artisan migrate
   php artisan db:seed
   ```

6. **Build frontend assets**
   ```bash
   bun run build
   ```

7. **Start development server**
   ```bash
   php artisan serve
   ```

## 🚀 Deployment on Render

### Automatic Deployment

This project is configured for automatic deployment on Render using the `render.yaml` configuration.

### Manual Setup

1. **Create a new Web Service on Render**
2. **Connect your GitHub repository**
3. **Use the following settings:**
   - **Environment**: PHP
   - **Build Command**: `composer install --no-dev --optimize-autoloader && bun install && bun run build`
   - **Start Command**: `php artisan serve --host=0.0.0.0 --port=$PORT`

### Environment Variables

Set these environment variables in your Render dashboard:

```env
APP_NAME=Howlson
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:YOUR_GENERATED_KEY
APP_URL=https://your-app-name.onrender.com

DB_CONNECTION=sqlite
DB_DATABASE=/opt/render/project/src/database/database.sqlite

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false

CACHE_STORE=database
QUEUE_CONNECTION=database

LOG_CHANNEL=errorlog
LOG_LEVEL=error
```

## 🔧 Configuration Details

### Database
- **Type**: SQLite
- **Location**: `/opt/render/project/src/database/database.sqlite`
- **Migrations**: Run automatically on deployment

### Session & Cache
- **Session Driver**: Database
- **Cache Store**: Database
- **Queue Connection**: Database

### Logging
- **Channel**: errorlog (for Render compatibility)
- **Level**: error (production)

## 🐛 Troubleshooting

### Error 500 - Internal Server Error

**Most common causes and solutions:**

1. **Database Path Issues** (FIXED)
   - All paths standardized to `/opt/render/project/src/database/database.sqlite`

2. **Missing APP_KEY** (FIXED)
   - Auto-generated in render.yaml

3. **Environment Variables**
   - Check all required variables are set in Render dashboard
   - Verify database path matches configuration

4. **Cache Issues** (FIXED)
   - Cache clearing added to startup process

5. **File Permissions** (FIXED)
   - Proper permissions set during build

### Debug Steps

1. **Check Render Logs**
   ```
   Go to Render Dashboard → Your Service → Logs
   ```

2. **Enable Debug Mode** (temporarily)
   ```
   Set APP_DEBUG=true in environment variables
   ```

3. **Test Database Connection**
   ```bash
   php -r "try { \$pdo = new PDO('sqlite:/opt/render/project/src/database/database.sqlite'); echo 'OK'; } catch(Exception \$e) { echo \$e->getMessage(); }"
   ```

### Build Failures

1. **Composer Issues**
   - Check composer.json for syntax errors
   - Verify PHP version compatibility

2. **Node.js/Bun Issues**
   - Check package.json for syntax errors
   - Verify Node.js version compatibility

3. **Asset Build Issues**
   - Check vite.config.ts configuration
   - Verify all frontend dependencies are installed

## 📁 Project Structure

```
howlson/
├── app/                    # Laravel application code
├── config/                 # Configuration files
├── database/              # Database migrations and seeders
├── public/                # Public assets
├── resources/             # Frontend resources (Vue.js)
├── routes/                # Route definitions
├── storage/               # Storage directory
├── render.yaml           # Render deployment configuration
├── build.sh              # Build script
├── start.sh              # Start script
└── TROUBLESHOOTING.md    # Detailed troubleshooting guide
```

## 🔐 Security

- APP_KEY is auto-generated for encryption
- CSRF protection enabled
- SQL injection protection via Eloquent ORM
- XSS protection via Laravel's built-in features

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Run tests
5. Submit a pull request

## 📞 Support

If you encounter any issues:

1. Check the [TROUBLESHOOTING.md](TROUBLESHOOTING.md) file
2. Review Render deployment logs
3. Verify environment variables
4. Check database connectivity

---

**Note**: This application has been optimized for Render deployment with automatic error handling, consistent database paths, and robust environment variable management.