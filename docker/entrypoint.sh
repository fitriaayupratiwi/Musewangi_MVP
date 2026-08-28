#!/bin/sh

echo "🚀 Starting MUSEWANGI Production Container..."

# Ensure system & runtime directories exist
mkdir -p /run/nginx \
         /var/log/nginx \
         /var/www/html/storage/framework/cache/data \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/app/public \
         /var/www/html/public/upload/qrcode \
         /var/www/html/bootstrap/cache \
         /var/www/html/database

# Ensure sqlite database exists
touch /var/www/html/database/database.sqlite

# Full permissions
chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/upload /var/www/html/database /run/nginx /var/log/nginx

# Clear all runtime caches
php artisan optimize:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true
php artisan config:clear 2>/dev/null || true

# Link storage
php artisan storage:link --force 2>/dev/null || true

# Run database migrations and seeders
php artisan migrate --force --seed 2>/dev/null || php artisan migrate --force 2>/dev/null || true

# If custom $PORT is provided, add it to Nginx config
if [ -n "$PORT" ] && [ "$PORT" != "80" ] && [ "$PORT" != "8080" ]; then
    sed -i "1s/^/server { listen ${PORT} default_server; location \/ { proxy_pass http:\/\/127.0.0.1:80; } }\n/" /etc/nginx/http.d/default.conf 2>/dev/null || true
fi

echo "✨ MUSEWANGI Ready! Starting PHP-FPM & Nginx..."
php-fpm -D
exec nginx -g "daemon off;"
