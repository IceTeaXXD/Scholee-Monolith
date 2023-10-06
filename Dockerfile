FROM php:8.0-apache
COPY . /var/www/html

RUN docker-php-ext-install mysqli

RUN apt-get update

RUN a2enmod rewrite

RUN service apache2 restart