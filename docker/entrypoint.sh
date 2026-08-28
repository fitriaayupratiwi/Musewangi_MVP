#!/bin/sh

echo "🚀 Starting MUSEWANGI Production Container..."

# Ensure directories exist
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/app/public
mkdir -p /var/www/html/public/upload/qrcode
mkdir -p /var/www/html/bootstrap/cache
mkdir -p /var/www/html/database

# Ensure sqlite database exists
touch /var/www/html/database/database.sqlite

# Permissions
chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/upload /var/www/html/database

# Link storage
php artisan storage:link --force 2>/dev/null || true

# Run database migrations and seeders
php artisan migrate --force --seed 2>/dev/null || php artisan migrate --force 2>/dev/null || true

# Configure Nginx port from Railway's $PORT env variable (default: 80)
TARGET_PORT="${PORT:-80}"
sed -i "s/listen 80;/listen ${TARGET_PORT};/g" /etc/nginx/http.d/default.conf 2>/dev/null || true
sed -i "s/listen \[::\]:80;/listen \[::\]:${TARGET_PORT};/g" /etc/nginx/http.d/default.conf 2>/dev/null || true

echo "✨ MUSEWANGI Ready on Port ${TARGET_PORT}! Starting PHP-FPM & Nginx..."
php-fpm -D
exec nginx -g "daemon off;"
