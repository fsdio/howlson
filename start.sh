#!/bin/bash

# Exit on any failure
set -e

echo "Starting application..."

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force

# Clear and cache config for production
echo "Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start the Laravel application
echo "Starting Laravel server..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}