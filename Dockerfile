FROM php:8.2-apache

RUN docker-php-ext-install mysqli \
    && a2enmod headers rewrite

COPY . /var/www/html/

RUN mkdir -p /var/www/html/assets/uploads/profile_pics \
    && chown -R www-data:www-data /var/www/html/assets/uploads

ENV APACHE_DOCUMENT_ROOT=/var/www/html

EXPOSE 8080

CMD ["sh", "-c", "PORT=${PORT:-8080}; sed -i -E \"s/^Listen [0-9]+/Listen ${PORT}/; s/<VirtualHost \\*:[0-9]+>/<VirtualHost *:${PORT}>/\" /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf; apache2-foreground"]
