FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libsqlite3-dev \
    sqlite3 \
    pkg-config \
    build-essential \
    autoconf \
    libtool \
    zip \
    unzip \
    nodejs \
    npm \
    && apt-get upgrade -y sqlite3 libsqlite3-dev

# Install PHP extensions first
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd pdo_sqlite

# Install bun
RUN curl -fsSL https://bun.sh/install | bash
ENV PATH="/root/.bun/bin:$PATH"

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/howlson

# Copy existing application directory contents
COPY . /var/www/howlson

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www/howlson

# Copy .env file for Docker deployment
# Note: .env file is now included in the Docker image
# Make sure to create .env file before building the image
COPY --chown=www-data:www-data .env /var/www/howlson/.env

# Install dependencies
RUN composer install --no-dev --optimize-autoloader
RUN bun install
RUN bun run build

# Create storage and cache directories
RUN mkdir -p /var/www/howlson/storage/logs
RUN mkdir -p /var/www/howlson/storage/framework/cache
RUN mkdir -p /var/www/howlson/storage/framework/sessions
RUN mkdir -p /var/www/howlson/storage/framework/views
RUN mkdir -p /var/www/howlson/bootstrap/cache

# Create database directory and SQLite file
RUN mkdir -p /var/www/howlson/database
RUN touch /var/www/howlson/database/database.sqlite

# Set permissions
RUN chown -R www-data:www-data /var/www/howlson/storage
RUN chown -R www-data:www-data /var/www/howlson/database
RUN chmod 664 /var/www/howlson/database/database.sqlite
RUN chmod 775 /var/www/howlson/database
RUN chown -R www-data:www-data /var/www/howlson/bootstrap/cache
RUN chmod -R 775 /var/www/howlson/storage
RUN chmod -R 775 /var/www/howlson/bootstrap/cache

# Copy startup script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expose port 8000
EXPOSE 8000

# Use custom entrypoint script
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]