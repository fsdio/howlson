# Troubleshooting Guide

## Common Issues and Solutions

### 1. Error 500 - Internal Server Error

#### Possible Causes:
- Database connection issues
- Missing APP_KEY
- File permissions
- Missing dependencies
- Configuration cache issues

#### Solutions:

**Check Database Connection:**
```bash
# Test SQLite database
php -r "try { \$pdo = new PDO('sqlite:database/database.sqlite'); echo 'OK'; } catch(Exception \$e) { echo \$e->getMessage(); }"
```

**Check APP_KEY:**
```bash
# Generate new APP_KEY if missing
php artisan key:generate
```

**Clear Cache:**
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

**Check File Permissions:**
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chmod 664 database/database.sqlite
```

### 2. Build Failures

#### Frontend Build Issues:
```bash
# Clear node modules and reinstall
rm -rf node_modules
bun install
bun run build
```

#### PHP Dependencies:
```bash
# Clear composer cache and reinstall
composer clear-cache
composer install --no-dev --optimize-autoloader
```

### 3. Database Issues

#### Migration Failures:
```bash
# Reset database (WARNING: This will delete all data)
php artisan migrate:fresh --force

# Or rollback and re-run
php artisan migrate:rollback
php artisan migrate --force
```

#### SQLite Permission Issues:
```bash
# Ensure database directory and file have correct permissions
mkdir -p database
touch database/database.sqlite
chmod 775 database
chmod 664 database/database.sqlite
```

### 4. Render Deployment Issues

#### Environment Variables:
Ensure these are set in Render Dashboard:
- `APP_KEY` (generate new one)
- `APP_ENV=production`
- `APP_DEBUG=false`
- `DB_CONNECTION=sqlite`
- `DB_DATABASE=/opt/render/project/src/database/database.sqlite`

#### Port Binding:
Make sure your application binds to `0.0.0.0:$PORT`

### 5. Logs and Debugging

#### Check Laravel Logs:
```bash
tail -f storage/logs/laravel.log
```

#### Enable Debug Mode (temporarily):
Set `APP_DEBUG=true` in environment variables, then check browser console and network tab for detailed errors.

#### Check Render Logs:
Go to Render Dashboard > Your Service > Logs to see deployment and runtime logs.

## Prevention Tips

1. **Always test locally before deploying**
2. **Use consistent paths across all configuration files**
3. **Keep dependencies up to date**
4. **Monitor logs regularly**
5. **Use proper error handling in your code**
6. **Test database connections in build scripts**

## Quick Health Check

Run this command to check basic application health:

```bash
# Check if all critical components are working
php artisan about
php artisan route:list
php artisan migrate:status
```