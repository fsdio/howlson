#!/bin/bash

# Exit on any failure
set -e

echo "Starting Docker container initialization..."

# Function to generate new APP_KEY
generate_app_key() {
    echo "Generating new APP_KEY..."
    NEW_APP_KEY=$(php artisan key:generate --show)
    echo "Generated APP_KEY: $NEW_APP_KEY"
    export APP_KEY="$NEW_APP_KEY"
}

# Function to update .env file
update_env_file() {
    echo "Updating .env file..."
    
    # Create .env file if it doesn't exist
    if [ ! -f ".env" ]; then
        if [ -f ".env.example" ]; then
            echo "Creating .env file from .env.example..."
            cp .env.example .env
        else
            echo "Creating basic .env file..."
            cat > .env << EOF
APP_NAME=Laravel
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=http://localhost:8000

LOG_CHANNEL=errorlog
LOG_LEVEL=error

DB_CONNECTION=sqlite
 DB_DATABASE=/var/www/database/database.sqlite

SESSION_DRIVER=database
SESSION_LIFETIME=120

CACHE_STORE=database

QUEUE_CONNECTION=database
EOF
        fi
    fi
    
    # Update APP_KEY in .env file
    if [ ! -z "$APP_KEY" ]; then
        echo "Updating APP_KEY in .env file..."
        sed -i "s|^APP_KEY=.*|APP_KEY=$APP_KEY|" .env
    fi
    
    # Update other environment variables for production
    sed -i "s|^APP_ENV=.*|APP_ENV=production|" .env
    sed -i "s|^APP_DEBUG=.*|APP_DEBUG=false|" .env
    sed -i "s|^DB_CONNECTION=.*|DB_CONNECTION=sqlite|" .env
    sed -i "s|^DB_DATABASE=.*|DB_DATABASE=/var/www/database/database.sqlite|" .env
    sed -i "s|^SESSION_DRIVER=.*|SESSION_DRIVER=database|" .env
    sed -i "s|^CACHE_STORE=.*|CACHE_STORE=database|" .env
    sed -i "s|^QUEUE_CONNECTION=.*|QUEUE_CONNECTION=database|" .env
    sed -i "s|^LOG_CHANNEL=.*|LOG_CHANNEL=errorlog|" .env
    sed -i "s|^LOG_LEVEL=.*|LOG_LEVEL=error|" .env
    
    # Update CORS and Session configuration for production
    if [ ! -z "$APP_URL" ]; then
        sed -i "s|^APP_URL=.*|APP_URL=$APP_URL|" .env
    fi
    
    # Add CORS configuration if not exists
    if ! grep -q "CORS_ALLOWED_ORIGINS" .env; then
        echo "CORS_ALLOWED_ORIGINS=$APP_URL,https://howlson.onrender.com" >> .env
    fi
    
    if ! grep -q "SANCTUM_STATEFUL_DOMAINS" .env; then
        echo "SANCTUM_STATEFUL_DOMAINS=howlson.onrender.com,localhost:8000" >> .env
    fi
    
    # Add Session configuration for production
    if ! grep -q "SESSION_DOMAIN" .env; then
        echo "SESSION_DOMAIN=.onrender.com" >> .env
    fi
    
    if ! grep -q "SESSION_SECURE_COOKIE" .env; then
        echo "SESSION_SECURE_COOKIE=true" >> .env
    fi
    
    if ! grep -q "SESSION_SAME_SITE" .env; then
        echo "SESSION_SAME_SITE=none" >> .env
    fi
    
    echo ".env file updated successfully!"
}

# Check if APP_KEY is provided via environment variable
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:GENERATE_NEW_KEY_IN_RENDER_DASHBOARD" ]; then
    generate_app_key
else
    echo "Using provided APP_KEY: $APP_KEY"
fi

# Update .env file with new configurations
update_env_file

# Check database file exists and is writable
echo "Checking database file..."
if [ ! -f "/var/www/database/database.sqlite" ]; then
    echo "Creating database file..."
    mkdir -p /var/www/database
    touch /var/www/database/database.sqlite
    chmod 664 /var/www/database/database.sqlite
    chmod 775 /var/www/database
fi

# Test database connection
echo "Testing database connection..."
php -r "try { \$pdo = new PDO('sqlite:/var/www/database/database.sqlite'); echo 'Database connection successful\n'; } catch(Exception \$e) { echo 'Database connection failed: ' . \$e->getMessage() . '\n'; exit(1); }"

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force

# Create sessions table if using database sessions
echo "Ensuring sessions table exists..."
php artisan session:table --force 2>/dev/null || echo "Sessions table already exists or not needed"
php artisan migrate --force

# Clear and cache config for production
echo "Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Display final APP_KEY for verification
echo "Final APP_KEY: $APP_KEY"

# Start Vite dev server in background
echo "Starting Vite dev server..."
bun run dev &
VITE_PID=$!

# Function to handle shutdown gracefully
shutdown() {
    echo "Shutting down services..."
    kill $VITE_PID 2>/dev/null
    exit 0
}

# Trap signals to shutdown gracefully
trap shutdown SIGTERM SIGINT

# Start the Laravel application
echo "Starting Laravel server on port ${PORT:-8000}..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}