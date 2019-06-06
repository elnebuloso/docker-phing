FROM elnebuloso/php:7.3-apache-ubuntu

COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY build/dist /var/www
COPY VERSION /VERSION

RUN echo "configure" \
    && a2enmod headers \
    && a2enmod rewrite \
    && echo 'PassEnv APP_ENV' > /etc/apache2/conf-enabled/expose-env.conf \
    && if [ -d /var/www/bootstrap/cache ]; then chmod 0755 -R /var/www/var ; fi \
    && if [ -d /var/www/bootstrap/cache ]; then chown www-data:www-data -R /var/www/var ; fi \
    && if [ -d /var/www/storage ]; then chmod 0755 -R /var/www/var ; fi \
    && if [ -d /var/www/storage ]; then chown www-data:www-data -R /var/www/var ; fi