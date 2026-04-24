# ---------- Stage 1: Build Vue.js assets ----------
FROM node:20-alpine AS vue-builder

WORKDIR /app

# Copy package files from PROJECT ROOT
COPY package*.json ./
COPY vite.config.js ./

# Install dependencies
RUN npm install

# Copy the Vue source (frontend/resources)
COPY frontend/resources ./frontend/resources

# Build the Vue app (output will be ./frontend/web/spa)
RUN npm run build

# ---------- Stage 2: Final PHP/Apache image ----------
FROM php:8.4-apache

# Copy custom PHP configuration (if any)
COPY ./php/custom.ini /usr/local/etc/php/conf.d/

# Install system dependencies
RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
        git \
        curl \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libxml2-dev \
        libzip-dev \
        libicu-dev \
        zip \
        unzip; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure intl && \
    docker-php-ext-install pdo pdo_mysql mysqli gd zip intl

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy the entire application code (Yii2 backend, frontend, common, etc.)
COPY . .

# Copy the built Vue.js assets from the first stage
COPY --from=vue-builder /app/frontend/web/spa /var/www/html/frontend/web/spa

# Install PHP dependencies via Composer (production optimised)
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Set environment variables
ENV YII_ENV=prod
ENV YII_DEBUG=false

# Set correct permissions for Yii2 runtime and asset directories
RUN mkdir -p /var/www/html/common/uploads \
    && chown -R www-data:www-data \
        /var/www/html/backend/runtime \
        /var/www/html/backend/web/assets \
        /var/www/html/frontend/runtime \
        /var/www/html/frontend/web/assets \
        /var/www/html/common/uploads

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
