FROM ubuntu:16.04

ARG DEBIAN_FRONTEND=noninteractive

RUN echo "install system" \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        software-properties-common \
        ca-certificates \
        locales \
        locales-all \
        curl \
        git \
        subversion \
		rsync \
		ssh-client \
		p7zip-full \
		nano \
    && locale-gen en_US.UTF-8 \
    && echo 'alias l="ls -alhF"' > /root/.bash_aliases \
    && apt-get -y autoremove \
    && apt-get -y autoclean \
    && apt-get -y clean \
    && rm -rf /tmp/*

ENV LANG en_US.UTF-8
ENV LANGUAGE en_US.UTF-8
ENV LC_ALL en_US.UTF-8

RUN echo "install php" \
    && add-apt-repository ppa:ondrej/php \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        php5.6-cli \
        php7.1-cli \
        php7.2-cli \
        php7.2-curl \
        php7.2-mysql \
        php7.2-xml \
        php7.2-zip \
        php7.3-cli \
    && update-alternatives --set php /usr/bin/php7.2 \
    && update-alternatives --set phar /usr/bin/phar7.2 \
    && update-alternatives --set phar.phar /usr/bin/phar.phar7.2 \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && export COMPOSER_ALLOW_SUPERUSER=1 \
    && export COMPOSER_HOME=/srv/composer \
    && composer global require --no-suggest --no-ansi --no-interaction \
        phing/phing \
        pear/archive_tar \
        pear/http_request2 \
        pear/versioncontrol_git \
        pear/versioncontrol_svn \
        sensiolabs/security-checker \
    && ln -s /srv/composer/vendor/bin/phing /usr/local/bin/phing \
    && ln -s /srv/composer/vendor/bin/security-checker /usr/local/bin/security-checker \
    && apt-get -y autoremove \
    && apt-get -y autoclean \
    && apt-get -y clean \
    && rm -rf /tmp/*

RUN echo "install docker" \
    && curl https://get.docker.com | sh \
    && curl -L https://github.com/docker/compose/releases/download/1.23.2/docker-compose-`uname -s`-`uname -m` -o /usr/local/bin/docker-compose \
    && chmod +x /usr/local/bin/docker-compose \
    && apt-get -y autoremove \
    && apt-get -y autoclean \
    && apt-get -y clean \
    && rm -rf /tmp/*

COPY docker/bin /usr/local/bin
COPY build/dist /srv/phing
COPY VERSION /srv/VERSION

RUN echo "configure /usr/local/bin" \
    && find /usr/local/bin -type f -name '*.sh' | while read f; do mv "$f" "${f%.sh}"; done \
    && chmod +x /usr/local/bin/*

CMD ["bash"]
