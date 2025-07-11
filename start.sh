#!/bin/bash

# Generate key if missing
if ! grep -q "APP_KEY=" .env || [ -z "$APP_KEY" ]; then
    echo "Generating app key..."
    php artisan key:generate
fi

# Run migrations only once
if [ ! -f /var/www/.migrated ]; then
    echo "Running migrations..."
    php artisan migrate --force
    touch /var/www/.migrated
else
    echo "Migrations already done, skipping."
fi

# Start Laravel app
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
