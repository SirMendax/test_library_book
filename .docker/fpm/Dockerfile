FROM php:7.4-fpm

RUN apt-get update \
        && apt-get install -y \
        git \
        curl \
        wget \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpq-dev \
        libzip-dev \
        zip

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install zip


RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install mysqli pgsql pdo_pgsql pdo pdo_mysql

CMD ["php-fpm"]

WORKDIR "/var/www/test/html"

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

