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

# Generate APP_KEY if not set or is placeholder
echo "Checking APP_KEY..."
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:GENERATE_NEW_KEY_IN_RENDER_DASHBOARD" ]; then
    echo "Generating new APP_KEY..."
    NEW_APP_KEY=$(php artisan key:generate --show)
    echo "Generated APP_KEY: $NEW_APP_KEY"
    export APP_KEY="$NEW_APP_KEY"
    
    # Update .env file if it exists
    if [ -f ".env" ]; then
        echo "Updating APP_KEY in .env file..."
        sed -i "s|^APP_KEY=.*|APP_KEY=$NEW_APP_KEY|" .env
    fi
else
    echo "Using existing APP_KEY: $APP_KEY"
fi

# Ensure DB_DATABASE uses absolute path for Render deployment
if [ -f ".env" ]; then
    echo "Setting absolute database path for Render..."
    sed -i "s|^DB_DATABASE=.*|DB_DATABASE=$(pwd)/database/database.sqlite|" .env
fi

# Clear and cache config for production
echo "Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start the Laravel application
echo "Starting Laravel server on port ${PORT:-8000}..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}