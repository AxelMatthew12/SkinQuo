# === STAGE 1: Build Frontend Assets ===
FROM node:20-alpine AS frontend-builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# === STAGE 2: Runtime Application (Clean Install) ===
# Kita pakai image PHP-CLI agar tidak ada Apache bawaan yang konflik
FROM php:8.3-cli

# 1. Install Apache dan dependencies secara manual (Paling Bersih)
RUN apt-get update && apt-get install -y \
    apache2 \
    libapache2-mod-php8.3 \
    libpng-dev libjpeg-dev libfreetype6-dev libzip-dev libpq-dev postgresql-client zip unzip git curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip gd bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Setup Apache Configuration
RUN a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html
COPY . .
COPY --from=frontend-builder /app/public/build ./public/build

# 3. Install Composer & Permissions
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

# 4. Start Apache dalam mode foreground
CMD php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    apachectl -D FOREGROUND
