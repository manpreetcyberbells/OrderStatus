#!/bin/bash

# Generate app key if not already generated
if ! grep -q "APP_KEY=" .env || [ -z "$APP_KEY" ]; then
    echo "Generating app key..."
    php artisan key:generate
fi

# Run migrations if marker file not exists
if [ ! -f /var/www/.migrated ]; then
    echo "Running migrations for the first time..."
    php artisan migrate --force
    touch /var/www/.migrated
else
    echo "Migrations already done. Skipping..."
fi

# Start Laravel development server
php artisan serve --host=0.0.0.0 --port=8000
