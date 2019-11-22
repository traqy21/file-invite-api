FROM php:7.2-apache-stretch

RUN apt-get update && apt-get install -y zip git libfreetype6-dev libjpeg62-turbo-dev libpng-dev vim

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    mariadb-client \
    locales \
    jpegoptim optipng pngquant gifsicle \
    unzip \
    curl

COPY . /var/www/html
COPY .docker/php/vhost.conf /etc/apache2/sites-available/000-default.conf

RUN chown -R www-data:www-data /var/www/html && a2enmod rewrite headers
#RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd
RUN docker-php-ext-install pdo_mysql && chown -R www-data:www-data /var/www/html
RUN docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN chown -R www-data:www-data /usr/local/bin/php

COPY .docker/php/php.ini /usr/local/etc/php/php.ini
RUN chmod u+x /usr/local/etc/php/php.ini

WORKDIR /var/www/html
RUN touch storage/logs/lumen.log && \
    chmod 777 storage/logs/lumen.log && \
    composer install --optimize-autoloader
RUN php artisan migrate
