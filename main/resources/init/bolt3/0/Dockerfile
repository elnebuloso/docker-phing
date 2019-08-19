FROM elnebuloso/php:7.3-apache-ubuntu

COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY build/dist/main /var/www/main
COPY VERSION /VERSION

ENV APP_ENV dev
WORKDIR /var/www/main

RUN echo "configure" \
    && a2enmod headers \
    && a2enmod rewrite \
    && echo 'PassEnv APP_ENV' > /etc/apache2/conf-enabled/expose-env.conf \
    && if [ -f /var/www/main/app/nut ]; then chmod +x /var/www/main/app/nut ; fi \
    && if [ -d /var/www/main/app/cache ]; then chmod 0755 -R /var/www/main/app/cache ; fi \
    && if [ -d /var/www/main/app/cache ]; then chown www-data:www-data -R /var/www/main/app/cache ; fi \
    && if [ -d /var/www/main/app/config ]; then chmod 0755 -R /var/www/main/app/config ; fi \
    && if [ -d /var/www/main/app/config ]; then chown www-data:www-data -R /var/www/main/app/config ; fi \
    && if [ -d /var/www/main/app/database ]; then chmod 0755 -R /var/www/main/app/database ; fi \
    && if [ -d /var/www/main/app/database ]; then chown www-data:www-data -R /var/www/main/app/database ; fi \
    && if [ -d /var/www/main/extensions ]; then chmod 0755 -R /var/www/main/extensions ; fi \
    && if [ -d /var/www/main/extensions ]; then chown www-data:www-data -R /var/www/main/extensions ; fi \
    && if [ -d /var/www/main/public/extensions ]; then chmod 0755 -R /var/www/main/public/extensions ; fi \
    && if [ -d /var/www/main/public/extensions ]; then chown www-data:www-data -R /var/www/main/public/extensions ; fi \
    && if [ -d /var/www/main/public/files ]; then chmod 0755 -R /var/www/main/public/files ; fi \
    && if [ -d /var/www/main/public/files ]; then chown www-data:www-data -R /var/www/main/public/files ; fi \
    && if [ -d /var/www/main/public/theme ]; then chmod 0755 -R /var/www/main/public/theme ; fi \
    && if [ -d /var/www/main/public/theme ]; then chown www-data:www-data -R /var/www/main/public/theme ; fi \
    && if [ -d /var/www/main/public/thumbs ]; then chmod 0755 -R /var/www/main/public/thumbs ; fi \
    && if [ -d /var/www/main/public/thumbs ]; then chown www-data:www-data -R /var/www/main/public/thumbs ; fi