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

# Cache Laravel configuration
echo "Caching Laravel configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Build process completed successfully!"