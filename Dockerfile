FROM composer:latest AS composer_stage
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip mariadb-client \
    libpng-dev libonig-dev libxml2-dev libzip-dev \
    nginx supervisor cron

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

# ✅ Correct: Install Composer from previous stage
COPY --from=composer_stage /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy app files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chmod -R 775 storage bootstrap/cache && chown -R www-data:www-data .

# Make script executable
RUN chmod +x ./start.sh

# Expose dynamic port
EXPOSE 8081

# Start app
CMD ["./start.sh"]
