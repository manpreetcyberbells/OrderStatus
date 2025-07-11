FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip mariadb-client \
    libpng-dev libonig-dev libxml2-dev libzip-dev \
    nginx supervisor cron

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy all app files (including your script)
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chmod -R 775 storage bootstrap/cache && chown -R www-data:www-data .

# Make sure start.sh is executable
RUN chmod +x ./start.sh

# Expose port (Railway uses PORT env variable)
EXPOSE 8000

# Run Laravel through custom script on container start
CMD ["./start.sh"]
