FROM php:8.2-apache

RUN docker-php-ext-install mysqli \
    && a2enmod headers rewrite

COPY . /var/www/html/

RUN mkdir -p /var/www/html/assets/uploads/profile_pics \
    && chown -R www-data:www-data /var/www/html/assets/uploads

ENV APACHE_DOCUMENT_ROOT=/var/www/html

EXPOSE 80
