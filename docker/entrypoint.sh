#!/bin/sh
set -e

echo "🚀 Starting MUSEWANGI Production Container..."

# Ensure storage & database directories exist
mkdir -p /var/www/html/storage/framework/cache/data \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/app/public \
         /var/www/html/public/upload/qrcode \
         /var/www/html/bootstrap/cache \
         /var/www/html/database

touch /var/www/html/database/database.sqlite || true
chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/upload /var/www/html/database || true

# Link storage
php artisan storage:link --force || true

# Clear cache
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Check database connection and run migrations
echo "📦 Running Database Migrations & Seeders..."
php artisan migrate --force --seed || php artisan migrate --force || true

# Configure Nginx port from Railway's $PORT env variable (default: 80)
TARGET_PORT="${PORT:-80}"
sed -i "s/listen 80;/listen ${TARGET_PORT};/g" /etc/nginx/http.d/default.conf || true
sed -i "s/listen \[::\]:80;/listen \[::\]:${TARGET_PORT};/g" /etc/nginx/http.d/default.conf || true

echo "✨ MUSEWANGI Ready on Port ${TARGET_PORT}! Starting PHP-FPM & Nginx..."
php-fpm -D
exec nginx -g "daemon off;"
