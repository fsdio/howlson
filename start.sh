#!/bin/bash

# Exit on any failure
set -e

echo "Starting application..."

# Check database file exists and is writable
echo "Checking database file..."
if [ ! -f "database/database.sqlite" ]; then
    echo "Creating database file..."
    mkdir -p database
    touch database/database.sqlite
    chmod 664 database/database.sqlite
    chmod 775 database
fi

# Test database connection
echo "Testing database connection..."
php -r "try { \$pdo = new PDO('sqlite:' . getcwd() . '/database/database.sqlite'); echo 'Database connection successful\n'; } catch(Exception \$e) { echo 'Database connection failed: ' . \$e->getMessage() . '\n'; exit(1); }"

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force

# Clear and cache config for production
echo "Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Check if APP_KEY is set
echo "Checking APP_KEY..."
if [ -z "$APP_KEY" ]; then
    echo "Warning: APP_KEY is not set!"
fi

# Start the Laravel application
echo "Starting Laravel server on port ${PORT:-8000}..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}