FROM elnebuloso/php:7.3-apache-ubuntu as prod

COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY build/dist /app
COPY VERSION /VERSION

ENV APP_ENV local
WORKDIR /app/main

RUN echo "configure" \
    && a2enmod headers \
    && a2enmod rewrite \
    && echo 'PassEnv APP_ENV' > /etc/apache2/conf-enabled/expose-env.conf \
    && if [ -d /app/main/bootstrap/cache ]; then chmod 0755 -R /app/main/bootstrap/cache ; fi \
    && if [ -d /app/main/bootstrap/cache ]; then chown www-data:www-data -R /app/main/bootstrap/cache ; fi \
    && if [ -d /app/main/storage ]; then chmod 0755 -R /app/main/storage ; fi \
    && if [ -d /app/main/storage ]; then chown www-data:www-data -R /app/main/storage ; fi \
    && if [ -f /app/main/artisan ]; then chmod +x /app/main/artisan ; fi

#
# development layer
#
FROM prod as dev
RUN echo "setup development layer" \
    && chmod 777 -R /tmp \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
    && apt-get -y autoremove \
    && apt-get -y autoclean \
    && apt-get -y clean \
    && rm -rf /tmp/*

#
# development layer for composer
#
FROM dev as dev-composer
ENV PHPEXT_ENABLE_XDEBUG no
ENV COMPOSER_HOME /tmp
ADD https://getcomposer.org/composer-stable.phar /usr/local/bin/composer
RUN echo "setup development layer for composer" \
    && chmod 777 /usr/local/bin/composer

#
# development layer for phpunit
#
FROM dev-composer as dev-phpunit
ENV PHPEXT_ENABLE_XDEBUG yes
ADD https://phar.phpunit.de/phpunit-8.phar /usr/local/bin/phpunit
RUN echo "setup development layer for phpunit" \
    && chmod 777 /usr/local/bin/phpunit