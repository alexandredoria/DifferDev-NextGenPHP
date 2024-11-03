FROM php:8.3-fpm-alpine

RUN apk add postgresql-dev \
    && docker-php-ext-install pdo_pgsql opcache

RUN apk update \
    && apk add --update linux-headers \
    && apk add build-base autoconf

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN apk del build-base autoconf \
    && apk cache clean