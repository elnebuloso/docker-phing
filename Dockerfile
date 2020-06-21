FROM ubuntu:18.04

ARG DEBIAN_FRONTEND=noninteractive

#
# install system dependencies
#
RUN echo "install system dependencies" \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        software-properties-common \
        ca-certificates \
        gpg-agent \
        locales \
        locales-all \
        curl \
		ssh-client \
		rsync \
		zip \
		unzip \
        p7zip-full \
		dos2unix \
    && add-apt-repository ppa:git-core/ppa \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
    && echo 'alias l="ls -alhF"' > /root/.bash_aliases \
    && apt-get -y autoremove \
    && apt-get -y autoclean \
    && apt-get -y clean \
    && rm -rf /tmp/*

ENV LANG en_US.UTF-8
ENV LANGUAGE en_US.UTF-8
ENV LC_ALL en_US.UTF-8

#
# install php
#
RUN echo "install php" \
    && add-apt-repository ppa:ondrej/php \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        php7.2-cli \
        php7.3-cli \
        php7.4-cli \
        php7.4-curl \
        php7.4-xml \
        php7.4-zip \
    && update-alternatives --set php /usr/bin/php7.4 \
    && update-alternatives --set phar /usr/bin/phar7.4 \
    && update-alternatives --set phar.phar /usr/bin/phar.phar7.4 \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && export COMPOSER_ALLOW_SUPERUSER=1 \
    && export COMPOSER_HOME=/srv/composer \
    && composer global require --no-suggest --no-ansi --no-interaction \
        phing/phing:2.16.3 \
        pear/archive_tar \
        pear/http_request2 \
        pear/versioncontrol_git \
        sensiolabs/security-checker \
    && ln -s /srv/composer/vendor/bin/phing /usr/local/bin/phing \
    && ln -s /srv/composer/vendor/bin/security-checker /usr/local/bin/security-checker \
    && apt-get -y autoremove \
    && apt-get -y autoclean \
    && apt-get -y clean \
    && rm -rf /tmp/*

#
# install docker
#
ARG DOCKER_COMPOSE_VERSION=1.25.1
RUN echo "install docker" \
    && curl -sSL https://get.docker.com -o get-docker.sh \
    && sh get-docker.sh \
    && curl -sSL https://github.com/docker/compose/releases/download/${DOCKER_COMPOSE_VERSION}/docker-compose-`uname -s`-`uname -m` -o /usr/local/bin/docker-compose \
    && chmod +x /usr/local/bin/docker-compose \
    && apt-get -y autoremove \
    && apt-get -y autoclean \
    && apt-get -y clean \
    && rm -rf /tmp/*

#
# install kubectl
#
RUN echo "install kubectl" \
    && curl -sSL https://packages.cloud.google.com/apt/doc/apt-key.gpg | apt-key add - \
    && echo "deb https://apt.kubernetes.io/ kubernetes-xenial main" | tee -a /etc/apt/sources.list.d/kubernetes.list \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        kubectl \
    && apt-get -y autoremove \
    && apt-get -y autoclean \
    && apt-get -y clean \
    && rm -rf /tmp/*

#
# install gitversion
#
RUN curl -sSL https://github.com/GitTools/GitVersion/releases/download/5.3.2/gitversion-ubuntu.18.04-x64-5.3.2.tar.gz -o /tmp/gitversion.tar.gz \
    && tar -xzvf /tmp/gitversion.tar.gz -C /usr/local/bin \
    && chmod +x /usr/local/bin/gitversion \
    && rm -rf /tmp/*

COPY docker/bin /usr/local/bin
COPY main /srv/phing
COPY VERSION /srv/VERSION

RUN echo "configure /usr/local/bin" \
    && find /usr/local/bin -type f -name '*.sh' | while read f; do mv "$f" "${f%.sh}"; done \
    && chmod +x /usr/local/bin/*

RUN echo "add development user" \
    && useradd --uid 1000 --user-group development \
    && usermod -aG docker development

ENV PHING_COMPOSER_CACHE_VOLUME f81440c9-814d-492c-b30b-08920e854b00
ENV PHING_NPM_CACHE_VOLUME 92f97451-da6b-4236-a026-80c42df19c0b
ENV PHING_YARN_CACHE_VOLUME 68897594-8c80-4b4e-8027-215f82c793bb

CMD ["bash"]
