FROM elnebuloso/php:7.3-apache-ubuntu

COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY build/dist /var/www
COPY VERSION /VERSION

RUN echo "configure" \
    && a2enmod headers \
    && a2enmod rewrite \
    && echo 'PassEnv APP_ENV' > /etc/apache2/conf-enabled/expose-env.conf \
    && if [ -d /var/www/app/cache ]; then chmod 0755 -R /var/www/app/cache ; fi \
    && if [ -d /var/www/app/cache ]; then chown www-data:www-data -R /var/www/app/cache ; fi \
    && if [ -d /var/www/public/files ]; then chmod 0755 -R /var/www/public/files ; fi \
    && if [ -d /var/www/public/files ]; then chown www-data:www-data -R /var/www/public/files ; fi