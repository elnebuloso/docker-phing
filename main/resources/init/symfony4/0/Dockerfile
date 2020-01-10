FROM elnebuloso/php:7.3-apache-ubuntu

COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY build/dist/main /app/main
COPY VERSION /VERSION

ENV APP_ENV dev
WORKDIR /app/main

RUN echo "configure" \
    && a2enmod headers \
    && a2enmod rewrite \
    && echo 'PassEnv APP_ENV' > /etc/apache2/conf-enabled/expose-env.conf \
    && if [ -d /app/main/var ]; then chmod 0755 -R /app/main/var ; fi \
    && if [ -d /app/main/var ]; then chown www-data:www-data -R /app/main/var ; fi

ADD https://phar.phpunit.de/phpunit-8.phar /usr/local/bin/phpunit
RUN chmod +x /usr/local/bin/phpunit