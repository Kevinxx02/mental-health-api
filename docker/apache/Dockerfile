FROM php:8.3-apache

# Dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    mariadb-client \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        zip

RUN pecl install pcov \
    && docker-php-ext-enable pcov

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Apache
RUN a2enmod rewrite

WORKDIR /var/www/html

COPY docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY docker/apache/php.ini /usr/local/etc/php/php.ini

COPY docker/apache/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]
