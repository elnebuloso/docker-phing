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
    && if [ -d /app/main/var ]; then chmod 0755 -R /app/main/var ; fi \
    && if [ -d /app/main/var ]; then chown www-data:www-data -R /app/main/var ; fi \
    && if [ -f /app/main/bin/console ]; then chmod +x /app/main/bin/console ; fi \
    && if [ -f /app/main/bin/adminconsole ]; then chmod +x /app/main/bin/adminconsole ; fi \
    && if [ -f /app/main/bin/websiteconsole ]; then chmod +x /app/main/bin/websiteconsole ; fi

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