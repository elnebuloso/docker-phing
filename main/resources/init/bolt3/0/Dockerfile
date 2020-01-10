FROM elnebuloso/php:7.3-apache-ubuntu as prod

COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY build/dist /app
COPY VERSION /VERSION

ENV APP_ENV dev
WORKDIR /app/main

RUN echo "configure" \
    && a2enmod headers \
    && a2enmod rewrite \
    && echo 'PassEnv APP_ENV' > /etc/apache2/conf-enabled/expose-env.conf \
    && if [ -f /app/main/app/nut ]; then chmod +x /app/main/app/nut ; fi \
    && if [ -d /app/main/app/cache ]; then chmod 0755 -R /app/main/app/cache ; fi \
    && if [ -d /app/main/app/cache ]; then chown www-data:www-data -R /app/main/app/cache ; fi \
    && if [ -d /app/main/app/config ]; then chmod 0755 -R /app/main/app/config ; fi \
    && if [ -d /app/main/app/config ]; then chown www-data:www-data -R /app/main/app/config ; fi \
    && if [ -d /app/main/app/database ]; then chmod 0755 -R /app/main/app/database ; fi \
    && if [ -d /app/main/app/database ]; then chown www-data:www-data -R /app/main/app/database ; fi \
    && if [ -d /app/main/extensions ]; then chmod 0755 -R /app/main/extensions ; fi \
    && if [ -d /app/main/extensions ]; then chown www-data:www-data -R /app/main/extensions ; fi \
    && if [ -d /app/main/public/extensions ]; then chmod 0755 -R /app/main/public/extensions ; fi \
    && if [ -d /app/main/public/extensions ]; then chown www-data:www-data -R /app/main/public/extensions ; fi \
    && if [ -d /app/main/public/files ]; then chmod 0755 -R /app/main/public/files ; fi \
    && if [ -d /app/main/public/files ]; then chown www-data:www-data -R /app/main/public/files ; fi \
    && if [ -d /app/main/public/theme ]; then chmod 0755 -R /app/main/public/theme ; fi \
    && if [ -d /app/main/public/theme ]; then chown www-data:www-data -R /app/main/public/theme ; fi \
    && if [ -d /app/main/public/thumbs ]; then chmod 0755 -R /app/main/public/thumbs ; fi \
    && if [ -d /app/main/public/thumbs ]; then chown www-data:www-data -R /app/main/public/thumbs ; fi

#
# development layer
#
FROM prod as dev
ENV PHPEXT_ENABLE_XDEBUG yes
ADD https://phar.phpunit.de/phpunit-8.phar /usr/local/bin/phpunit
ADD https://getcomposer.org/composer-stable.phar /usr/local/bin/composer
RUN echo "install development dependencies" \
    && chmod +x /usr/local/bin/phpunit \
    && chmod +x /usr/local/bin/composer \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
		unzip \
    && apt-get -y autoremove \
    && apt-get -y autoclean \
    && apt-get -y clean \
    && rm -rf /tmp/*