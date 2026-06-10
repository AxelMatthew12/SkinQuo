# ==============================================================================
# STAGE 1: Build Frontend Assets (Node.js & Vite)
# ==============================================================================
FROM node:20-alpine AS frontend-builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# ==============================================================================
# STAGE 2: Runtime Application (PHP 8.3 & Apache)
# ==============================================================================
FROM php:8.3-apache

# 1. Install dependencies inti (TANPA postgresql-client agar bebas konflik MPM)
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip gd bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Proteksi Ganda: Pastikan hanya mpm_prefork yang aktif & hidupkan rewrite URL
RUN a2dismod mpm_event mpm_worker || true \
    && rm -f /etc/apache2/mods-enabled/mpm_event.load /etc/apache2/mods-enabled/mpm_worker.load \
    && a2enmod mpm_prefork rewrite

# 3. Arahkan Document Root Apache langsung ke folder /public milik Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 4. Tentukan direktori kerja
WORKDIR /var/www/html

# 5. Salin file proyek dan hasil kompilasi desain Vite dari Stage 1
COPY . .
COPY --from=frontend-builder /app/public/build ./public/build

# 6. Install Composer untuk package PHP
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader

# 7. Atur permission folder storage & cache Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 8. Buka port standar
EXPOSE 80

# 9. Jalankan optimasi & paksa hapus sisa file MPM jika masih ada saat container dinyalakan
CMD rm -f /etc/apache2/mods-enabled/mpm_event.load /etc/apache2/mods-enabled/mpm_worker.load || true \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && apache2-foreground
