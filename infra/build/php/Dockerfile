FROM php:8.0-fpm-alpine

MAINTAINER juan-arroyes

RUN apk update \
    && apk add --no-cache \
    git \
    curl \
    icu-dev \
    libxml2-dev \
    g++ \
    libzip-dev \
    make \
    autoconf \
    librdkafka-dev

RUN set -ex \
      && apk --no-cache add \
        postgresql-dev

RUN docker-php-source extract \
    && pecl install xdebug \
    && pecl install rdkafka \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-enable rdkafka \
    && docker-php-ext-install pdo pdo_pgsql soap intl zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && rm -rf /tmp/*

#RUN echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY ./uploads.ini /usr/local/etc/php/conf.d/uploads.ini

RUN cat /etc/group

RUN addgroup -g 1000 -S username && \
        adduser -u 1000 -S username -G username

RUN export XDEBUG_MODE=coverage

USER 1000

WORKDIR /app

COPY . /app