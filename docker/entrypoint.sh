#!/bin/sh
set -e

echo "🚀 Starting MUSEWANGI Production Container..."

# Ensure storage directories exist with correct permissions
mkdir -p /var/www/html/storage/framework/cache/data \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/app/public \
         /var/www/html/public/upload/qrcode \
         /var/www/html/bootstrap/cache

chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/upload || true

# Link storage
php artisan storage:link --force || true

# Clear cache first to pick up any new environment variables
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Auto-run database migration & seeders (ensures tables & initial admin/collections exist)
echo "📦 Checking and Running Database Migrations..."
php artisan migrate --force --seed || php artisan migrate --force || true

# Configure Nginx port from Railway's $PORT env variable (default: 80)
TARGET_PORT="${PORT:-80}"
sed -i "s/listen 80;/listen ${TARGET_PORT};/g" /etc/nginx/http.d/default.conf || true
sed -i "s/listen \[::\]:80;/listen \[::\]:${TARGET_PORT};/g" /etc/nginx/http.d/default.conf || true

echo "✨ MUSEWANGI Ready on Port ${TARGET_PORT}! Starting PHP-FPM & Nginx..."
php-fpm -D
exec nginx -g "daemon off;"
