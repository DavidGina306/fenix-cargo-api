FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    libpq-dev \
    libonig-dev \
    unzip \
    && docker-php-ext-install -j$(nproc) iconv mbstring pdo pdo_pgsql pdo_mysql gd zip bcmath \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get autoremove -y && apt-get autoclean -y && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY ./docker/php-fpm/php.ini /usr/local/etc/php/

WORKDIR /var/www/html