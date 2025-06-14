#!/bin/bash

# Exit on any failure
set -e

echo "Starting build process..."

# Install PHP dependencies
echo "Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Install Node.js dependencies
echo "Installing Node.js dependencies..."
bun install

# Build frontend assets
echo "Building frontend assets..."
bun run build

# Create storage directories if they don't exist
echo "Setting up storage directories..."
mkdir -p storage/logs
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p bootstrap/cache

# Create database directory and SQLite file
echo "Setting up SQLite database..."
mkdir -p database
touch database/database.sqlite

# Set proper permissions
echo "Setting permissions..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chmod 664 database/database.sqlite
chmod 775 database

# Test database connection
echo "Testing database connection..."
php -r "try { \$pdo = new PDO('sqlite:' . getcwd() . '/database/database.sqlite'); echo 'Database connection successful\n'; } catch(Exception \$e) { echo 'Database connection failed: ' . \$e->getMessage() . '\n'; exit(1); }"

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

# Create sessions table for database sessions
echo "Creating sessions table..."
php artisan session:table --force 2>/dev/null || echo "Sessions table command not available or already exists"

# Run migrations to ensure all tables exist
echo "Running database migrations..."
php artisan migrate --force

# Cache Laravel configuration
echo "Caching Laravel configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Build process completed successfully!"
echo "APP_KEY: $APP_KEY"