# ---------------------------------------------------------
# Étape 1 : Build vendors avec Composer
# ---------------------------------------------------------
FROM composer:2.8 AS vendor

WORKDIR /app
COPY symfony/composer.json symfony/composer.lock ./
RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction --no-scripts

# ---------------------------------------------------------
# Étape 2 : Image PHP-FPM
# ---------------------------------------------------------
FROM php:8.4-fpm AS base

# Variables d'environnement
ENV COMPOSER_ALLOW_SUPERUSER=1 \
    PHP_OPCACHE_VALIDATE_TIMESTAMPS=1 \
    PHP_OPCACHE_MAX_ACCELERATED_FILES=10000 \
    PHP_OPCACHE_MEMORY_CONSUMPTION=192 \
    PHP_OPCACHE_MAX_WASTED_PERCENTAGE=10

# Dépendances système minimales + extensions PHP
RUN apt-get update && apt-get install -y --no-install-recommends \
    libicu-dev libzip-dev zlib1g-dev libpq-dev libonig-dev \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    ca-certificates \
 && update-ca-certificates \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) \
    gd intl mbstring opcache pdo_pgsql zip bcmath \
 && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Config PHP
COPY docker/php/php.ini /usr/local/etc/php/conf.d/php.ini
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Copier Composer
COPY --from=vendor /usr/bin/composer /usr/bin/composer

# ---------------------------------------------------------
# Étape Dev (avec Xdebug)
# ---------------------------------------------------------
FROM base AS dev

RUN apt-get update && apt-get install -y --no-install-recommends autoconf build-essential \
 && pecl install xdebug \
 && docker-php-ext-enable xdebug \
 && apt-get purge -y --auto-remove build-essential autoconf \
 && rm -rf /var/lib/apt/lists/*

COPY docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Volumes en dev → code monté directement
CMD ["php-fpm"]

# ---------------------------------------------------------
# Étape Prod
# ---------------------------------------------------------
FROM base AS prod

# Copier vendor
COPY --from=vendor /app/vendor ./vendor

# Copier code Symfony
COPY symfony .

# Copier le fichier .env (si présent) pour les variables d'environnement en prod
COPY .env ./.env

RUN chown -R www-data:www-data /var/www/html/var

# Optimiser l'autoload en production (sans exécuter les scripts)
RUN composer dump-autoload --no-dev --classmap-authoritative --optimize

USER www-data

CMD ["php-fpm"]