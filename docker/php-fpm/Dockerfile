
ARG PHP_FPM_VERSION
FROM php:${PHP_FPM_VERSION}-fpm
WORKDIR "/var/www"

ARG USER_UID
ARG USER_GID
ARG USER_NAME

RUN groupadd -g ${USER_GID} ${USER_NAME} && \
useradd -u ${USER_UID} -g ${USER_NAME} -m ${USER_NAME} && \
usermod -p "*" ${USER_NAME}


RUN ldconfig

RUN apt-get update && apt install -y openssl bash libxml2-dev postgresql-client libpq-dev libpng-dev libaio1

RUN apt-get install libzip-dev -y

RUN docker-php-ext-install zip
RUN apt-get install unzip -y

RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql soap gd pdo_mysql mysqli

RUN docker-php-ext-install exif

RUN curl -sL https://deb.nodesource.com/setup_14.x | bash

RUN apt-get update && apt-get install -y nodejs && apt-get clean

RUN apt-get update && apt-get install -y git

RUN apt-get update && apt-get install -y nano

RUN apt-get update && apt-get install -y net-tools

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN rm -rf /var/www/html

RUN apt-get update && apt-get install -y libxrender-dev libfontconfig

COPY ./php-ini-overrides.ini /usr/local/etc/php/conf.d

