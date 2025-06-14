# Troubleshooting Guide

## Common Issues and Solutions

### 1. Error 500 - Internal Server Error

**CRITICAL: Path Consistency Fixed**
All database paths have been standardized to: `/opt/render/project/src/database/database.sqlite`

**Possible causes:**
- Database connection issues (FIXED: Path inconsistency resolved)
- Missing APP_KEY (FIXED: Auto-generated in render.yaml)
- File permissions problems (FIXED: Proper permissions set)
- Cache configuration issues (FIXED: Cache clearing added to startup)
- Environment variables not set properly

**Solutions:**
1. Check database file exists and is writable:
```bash
ls -la /opt/render/project/src/database/database.sqlite
```

2. Test database connection:
```bash
php -r "try { \$pdo = new PDO('sqlite:/opt/render/project/src/database/database.sqlite'); echo 'OK'; } catch(Exception \$e) { echo \$e->getMessage(); }"
```

3. Verify environment variables in Render Dashboard:
   - APP_KEY (should be auto-generated)
   - DB_CONNECTION=sqlite
   - DB_DATABASE=/opt/render/project/src/database/database.sqlite
   - SESSION_DRIVER=database
   - CACHE_STORE=database
   - QUEUE_CONNECTION=database

4. Check Render deployment logs for specific errors
5. If still failing, temporarily set APP_DEBUG=true to see detailed errors

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