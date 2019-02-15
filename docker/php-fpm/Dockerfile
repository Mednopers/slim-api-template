FROM php:7.1-fpm

RUN apt-get update && apt-get install -y --no-install-recommends wget git unzip libmcrypt-dev libpq-dev \
    && pecl install xdebug-2.6.1 \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install pdo pdo_mysql mcrypt bcmath

ADD php.ini /usr/local/etc/php/php.ini

RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet

ARG UID
RUN usermod -u ${UID} www-data

WORKDIR /var/www
