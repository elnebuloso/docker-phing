FROM elnebuloso/php:7.3-apache-ubuntu as prod

COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY build/dist /app
COPY VERSION /VERSION

ENV APP_ENV dev
WORKDIR /app

RUN echo "configure webserver" \
    && a2enmod headers \
    && a2enmod rewrite \
    && echo 'PassEnv APP_ENV' > /etc/apache2/conf-enabled/expose-env.conf

#
# development layer
#
FROM prod as dev
ENV PHPEXT_ENABLE_XDEBUG no
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

FROM dev as phpunit
ENV PHPEXT_ENABLE_XDEBUG yes