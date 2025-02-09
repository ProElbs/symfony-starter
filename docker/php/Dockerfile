FROM composer:2.0 AS composer

FROM php:8.4.3-fpm

RUN docker-php-ext-install pdo_mysql

RUN apt-get update && \
apt-get install -y \
libzip-dev

RUN docker-php-ext-install zip

WORKDIR /var/www/html

COPY --chown=1000:1000 symfony var/www/html

RUN PATH=$PATH:/var/www/html/vendor/bin:bin

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
