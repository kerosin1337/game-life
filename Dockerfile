FROM php:7.4-apache

RUN a2enmod rewrite
RUN apt-get update
RUN apt-get install -y libpq-dev
RUN docker-php-ext-install pdo pdo_pgsql
WORKDIR /var/www/html
COPY vhost.conf /etc/apache2/sites-available/000-default.conf
COPY /backend /var/www/html/
RUN chmod -R 777 /var/www/html/storage
