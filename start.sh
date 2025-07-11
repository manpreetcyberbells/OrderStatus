#!/bin/bash

set -e

echo "Using Railway environment variables..."

# Generate APP_KEY if missing
if [ -z "$APP_KEY" ]; then
    echo "APP_KEY is not set. Generating..."
    php artisan key:generate
fi

# Run migrations only once
if [ ! -f /var/www/.migrated ]; then
    echo "Running migrations..."
    php artisan migrate --force
    touch /var/www/.migrated
else
    echo "Migrations already done. Skipping..."
fi

# Start server on Railway-injected PORT
php artisan serve --host=0.0.0.0 --port="${PORT}"
