FROM elnebuloso/php:7.3-apache-ubuntu

COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY build/dist/main /var/www/main
COPY VERSION /VERSION

ENV APP_ENV local
WORKDIR /var/www/main

RUN echo "configure" \
    && a2enmod headers \
    && a2enmod rewrite \
    && echo 'PassEnv APP_ENV' > /etc/apache2/conf-enabled/expose-env.conf \
    && if [ -d /var/www/main/bootstrap/cache ]; then chmod 0755 -R /var/www/main/var ; fi \
    && if [ -d /var/www/main/bootstrap/cache ]; then chown www-data:www-data -R /var/www/main/var ; fi \
    && if [ -d /var/www/main/storage ]; then chmod 0755 -R /var/www/main/var ; fi \
    && if [ -d /var/www/main/storage ]; then chown www-data:www-data -R /var/www/main/var ; fi