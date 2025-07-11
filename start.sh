#!/bin/bash

set -e

echo "🟡 Using Railway environment variables..."
echo "🟢 APP_KEY: ${APP_KEY:0:10}..."

# Generate key if needed
if [ -z "$APP_KEY" ]; then
    echo "⚠️ APP_KEY is not set. Generating..."
    php artisan key:generate
fi

# Migrations
if [ ! -f /var/www/.migrated ]; then
    echo "📦 Running migrations..."
    php artisan migrate --force
    touch /var/www/.migrated
else
    echo "✅ Migrations already done. Skipping..."
fi

# Print route list for debugging
echo "🔍 Laravel route list:"
php artisan route:list || echo "⚠️ route:list failed"

# Start server
echo "🚀 Starting server on port ${PORT}..."
php artisan serve --host=0.0.0.0 --port="${PORT}"
