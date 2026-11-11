FROM php:8.2-fpm-alpine AS base

# تثبيت dependencies النظامية
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    sqlite-dev \
    mysql-client \
    nodejs \
    npm \
    supervisor \
    && rm -rf /var/cache/apk/*

# تثبيت إضافات PHP
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    pdo_sqlite \
    mbstring \
    zip \
    intl \
    bcmath \
    opcache

# تثبيت Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# إعدادات PHP
COPY docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www/html

# نسخ المشروع
COPY . .

# تثبيت dependencies (production-safe)
RUN composer install --no-interaction --prefer-dist --no-progress --optimize-autoloader \
    && npm ci \
    && npm run build \
    && rm -rf node_modules

# صلاحيات
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

USER www-data

EXPOSE 9000

CMD ["php-fpm"]