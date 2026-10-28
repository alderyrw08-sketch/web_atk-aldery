FROM php:8.3-fpm-alpine

ARG UID=1000
ARG GID=1000

# Install system dependencies
RUN apk add --no-cache \
    curl \
    git \
    bash \
    zip \
    unzip \
    shadow \
    nodejs \
    npm

# Install PHP extensions via installer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions \
    pdo_mysql \
    pdo_sqlite \
    bcmath \
    gd \
    zip \
    intl \
    opcache \
    pcntl \
    redis \
    exif

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Adjust www-data UID and GID to match host user
RUN usermod -u ${UID} www-data && groupmod -g ${GID} www-data

# Copy custom PHP configuration
COPY ./docker/php/local.ini /usr/local/etc/php/conf.d/local.ini

# Copy entrypoint script
COPY ./docker/php/entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

WORKDIR /var/www/html

USER www-data

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php-fpm"]
