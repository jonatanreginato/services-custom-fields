FROM php:8.2.7-fpm-alpine AS base

LABEL maintainer="jonatan.reginato@nuvemshop.com.br"

# WORKDIR - the directory from which the application will be served
WORKDIR /var/www/

# Install system dependencies
RUN apk add --no-cache --virtual .deps \
    autoconf \
    make \
    g++ \
    linux-headers \
    icu-dev

RUN apk add --no-cache \
    bash \
    curl \
    git \
    icu \
    libzip-dev \
    openssl-dev \
    sed \
    supervisor \
    unzip \
    wget

# Install Docker-PHP Extensions
RUN docker-php-ext-install \
    intl \
    opcache \
    pcntl \
    pdo \
    pdo_mysql \
    zip

RUN docker-php-ext-configure intl --enable-intl
RUN docker-php-ext-configure pcntl --enable-pcntl

# Install APCu and Xdebug
RUN apk add --no-cache --virtual .phpize-deps $PHPIZE_DEPS \
    && pecl install -f apcu && docker-php-ext-enable apcu \
    && pecl install -f xdebug && docker-php-ext-enable xdebug \
    && apk del --purge autoconf g++ make

RUN apk del .deps

# Clear cache and temp files
RUN pecl clear-cache && \
    rm -rf /var/lib/apt/lists/* && \
    rm -rf /tmp/pear

# EXPOSE PORT - Expose default port at which the application will respond
EXPOSE 9000

# Auto accept any terms of service
ENV ACCEPT_EULA=Y

# Set environment variable
ENV PATH="${PATH}:/var/www/bin"

FROM composer:2.4.2 AS build

LABEL maintainer="jonatan.reginato@nuvemshop.com.br"

FROM base AS final

LABEL maintainer="jonatan.reginato@nuvemshop.com.br"

# Copy rootfilesystem folder to the docker conteiner
COPY environment/php/rootfilesystem/ /

# Config INET HTTP server host (supervisor)
ARG INET_HTTP_SERVER_HOST="php-restful-api-template-php:9001"
EXPOSE 9001
RUN sed -i "s/{INET_HTTP_SERVER_HOST}/$INET_HTTP_SERVER_HOST/" /etc/supervisord.conf

# XDEBUG - Config
ENV PHP_IDE_CONFIG     "serverName=docker"
ENV XDEBUG_CONFIG      "idekey=php-restful-api-template"
ENV XDEBUG_SESSION     "php-restful-api-template"
ENV XDEBUG_MODE        "develop,debug,coverage"
ENV XDEBUG_CLIENT_PORT  9003
ENV XDEBUG_CLIENT_HOST "host.docker.internal"
ENV XDEBUG_IDE_KEY     "php-restful-api-template"

RUN sed -i "s/{XDEBUG_MODE}/$XDEBUG_MODE/" /usr/local/etc/php/conf.d/99-xdebug.ini \
 && sed -i "s/{XDEBUG_CLIENT_PORT}/$XDEBUG_CLIENT_PORT/" /usr/local/etc/php/conf.d/99-xdebug.ini \
 && sed -i "s/{XDEBUG_CLIENT_HOST}/$XDEBUG_CLIENT_HOST/" /usr/local/etc/php/conf.d/99-xdebug.ini \
 && sed -i "s/{XDEBUG_IDE_KEY}/$XDEBUG_IDE_KEY/" /usr/local/etc/php/conf.d/99-xdebug.ini

# Get Composer
COPY --from=build /usr/bin/composer /usr/bin/composer

STOPSIGNAL SIGINT

ENTRYPOINT ["/entrypoint.sh"]
