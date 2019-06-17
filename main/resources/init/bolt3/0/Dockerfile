FROM elnebuloso/php:7.3-apache-ubuntu

COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY build/dist /var/www
COPY VERSION /VERSION

RUN echo "configure" \
    && a2enmod headers \
    && a2enmod rewrite \
    && echo 'PassEnv APP_ENV' > /etc/apache2/conf-enabled/expose-env.conf \
    && if [ -f /var/www/app/nut ]; then chmod +x /var/www/app/nut ; fi \
    && if [ -d /var/www/app/cache ]; then chmod 0755 -R /var/www/app/cache ; fi \
    && if [ -d /var/www/app/cache ]; then chown www-data:www-data -R /var/www/app/cache ; fi \
    && if [ -d /var/www/app/config ]; then chmod 0755 -R /var/www/app/config ; fi \
    && if [ -d /var/www/app/config ]; then chown www-data:www-data -R /var/www/app/config ; fi \
    && if [ -d /var/www/app/database ]; then chmod 0755 -R /var/www/app/database ; fi \
    && if [ -d /var/www/app/database ]; then chown www-data:www-data -R /var/www/app/database ; fi \
    && if [ -d /var/www/extensions ]; then chmod 0755 -R /var/www/extensions ; fi \
    && if [ -d /var/www/extensions ]; then chown www-data:www-data -R /var/www/extensions ; fi \
    && if [ -d /var/www/public/extensions ]; then chmod 0755 -R /var/www/public/extensions ; fi \
    && if [ -d /var/www/public/extensions ]; then chown www-data:www-data -R /var/www/public/extensions ; fi \
    && if [ -d /var/www/public/files ]; then chmod 0755 -R /var/www/public/files ; fi \
    && if [ -d /var/www/public/files ]; then chown www-data:www-data -R /var/www/public/files ; fi \
    && if [ -d /var/www/public/theme ]; then chmod 0755 -R /var/www/public/theme ; fi \
    && if [ -d /var/www/public/theme ]; then chown www-data:www-data -R /var/www/public/theme ; fi \
    && if [ -d /var/www/public/thumbs ]; then chmod 0755 -R /var/www/public/thumbs ; fi \
    && if [ -d /var/www/public/thumbs ]; then chown www-data:www-data -R /var/www/public/thumbs ; fi