#!/bin/bash

set -e  # Exit on error

# Wait for database (optional: useful in cloud deploys)
# sleep 5

# Check if .env exists
# if [ ! -f .env ]; then
#     echo ".env file not found! Please ensure it is present."
#     exit 1
# fi

# Generate APP_KEY if not already set
if grep -q "^APP_KEY=$" .env || ! grep -q "^APP_KEY=" .env; then
    echo "Generating app key..."
    php artisan key:generate
else
    echo "APP_KEY already set. Skipping generation."
fi

# Run migrations only once
if [ ! -f /var/www/.migrated ]; then
    echo "Running migrations..."
    php artisan migrate --force
    touch /var/www/.migrated
else
    echo "Migrations already done. Skipping..."
fi

# Start Laravel server (Railway expects dynamic port)
echo "Starting Laravel server on port: ${PORT}"
php artisan serve --host=0.0.0.0 --port="${PORT}"
