# ── Stage 1: Build Frontend Assets ──
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# ── Stage 2: Production PHP + Nginx Environment ──
FROM php:8.2-fpm-alpine

# Install system dependencies & PHP extensions
RUN apk add --no-cache \
    nginx \
    curl \
    git \
    sqlite \
    sqlite-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    tzdata \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    pdo_sqlite \
    gd \
    fileinfo \
    mbstring \
    zip \
    opcache \
    intl \
    bcmath

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy application source code
COPY . .

# Copy built frontend assets from Stage 1
COPY --from=frontend /app/public/build /var/www/html/public/build

# Install PHP production dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

# Copy Nginx configuration & entrypoint script
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Create database and storage with write permissions
RUN mkdir -p /var/www/html/database /var/www/html/storage /var/www/html/bootstrap/cache && \
    touch /var/www/html/database/database.sqlite && \
    chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database && \
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
