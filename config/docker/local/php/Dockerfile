FROM php:7.4.3-fpm-alpine

RUN apk add --no-cache \
    git \
    icu-dev \
    libzip-dev \
    postgresql-dev \
    zip

RUN docker-php-ext-install \
    intl \
    opcache \
    pdo \
    pdo_pgsql \
    zip \
    bcmath \
    sockets

ENV LIBRDKAFKA_VERSION v0.9.5
ENV BUILD_DEPS \
    autoconf \
    bash \
    build-base \
    git \
    pcre-dev \
    python

RUN apk --no-cache --virtual .build-deps add ${BUILD_DEPS} \
    && cd /tmp \
    && git clone \
        --branch ${LIBRDKAFKA_VERSION} \
        --depth 1 \
        https://github.com/edenhill/librdkafka.git \
    && cd librdkafka \
    && ./configure \
    && make \
    && make install \
    && pecl install rdkafka-3.1.2 \
    && docker-php-ext-enable rdkafka \
    && rm -rf /tmp/librdkafka \
    && apk del .build-deps

# Uncomment code below for enabling xDebug
# or delete it with the xdebug.ini file

#RUN apk add --no-cache --virtual .xdebug-build-deps ${PHPIZE_DEPS} \
#	&& pecl install xdebug \
#	&& docker-php-ext-enable xdebug \
#	&& apk del .xdebug-build-deps
#
#COPY xdebug.ini /usr/local/etc/php/xdebug.ini
#
#RUN cat /usr/local/etc/php/xdebug.ini >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY --from=composer /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_MEMORY_LIMIT -1
RUN composer global require hirak/prestissimo --no-plugins --no-scripts

ARG HOST_UID

RUN if [ ! -z "${HOST_UID}" ]; then \
        deluser www-data \
        && addgroup www-data \
        && adduser -u "${HOST_UID}" -G www-data -H -s /bin/sh -D www-data; \
    fi

ENV WWW_DATA_UID ${HOST_UID}

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY ./symfony.ini $PHP_INI_DIR/conf.d/
COPY ./opcache.ini $PHP_INI_DIR/conf.d/
COPY ./symfony.pool.conf /usr/local/etc/php-fpm.d/www.conf