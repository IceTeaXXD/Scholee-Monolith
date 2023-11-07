FROM php:8.0-apache
COPY . /var/www/html

RUN docker-php-ext-install mysqli

RUN apt-get update

RUN apt-get install -y libxml2-dev

RUN docker-php-ext-install soap

RUN a2enmod rewrite

RUN service apache2 restart