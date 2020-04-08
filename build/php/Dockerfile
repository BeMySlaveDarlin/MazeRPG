FROM debian:buster

LABEL maintainer="Aziz Muzafarov <bemyslavedarlin@gmail.com>"

ENV PATH=/root/composer/vendor/bin:/app/vendor/bin:/app/bin:$PATH
ENV BUILD_DEPS='gcc g++ make autoconf libc-dev zlib1g-dev pkg-config'
ENV COMPOSER_VERSION=1.9.1
ENV PHP_VERSION=7.3
ENV PHP_CONF_PATH=/etc/php/$PHP_VERSION/fpm/php.ini
ENV FPM_CONF_PATH=/etc/php/$PHP_VERSION/fpm/pool.d/www.conf

RUN apt-get -y update \
    && apt-get install --no-install-recommends ${BUILD_DEPS} --no-install-suggests -yq \
        apt-utils \
        jq \
        mc \
        git \
        wget \
        curl \
        nano \
        zip \
        unzip \
        gnupg2 \
        dirmngr \
        apt-transport-https \
        lsb-release \
        openssl \
        re2c \
        ca-certificates \
        software-properties-common \
    && wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg \
    && echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list \
    && rm -rf /tmp/* /var/tmp/* \
    && apt-get autoremove -y \
    && apt-get autoclean -y \
    && apt-get clean -y

RUN apt-get -y update \
    && apt-get install --no-install-recommends --no-install-suggests -yq \
        libmemcached-dev \
        libmemcached11 \
        libmagickwand-dev \
        php$PHP_VERSION-fpm \
        php$PHP_VERSION-cli \
        php$PHP_VERSION-common \
        php$PHP_VERSION-dev \
        php$PHP_VERSION-bcmath \
        php$PHP_VERSION-curl \
        php$PHP_VERSION-gd \
        php$PHP_VERSION-intl \
        php$PHP_VERSION-json \
        php$PHP_VERSION-mbstring \
        php$PHP_VERSION-mongodb \
        php$PHP_VERSION-msgpack \
        php$PHP_VERSION-mysql \
        php$PHP_VERSION-opcache \
        php$PHP_VERSION-pgsql \
        php$PHP_VERSION-pspell \
        php$PHP_VERSION-readline \
        php$PHP_VERSION-recode \
        php$PHP_VERSION-soap \
        php$PHP_VERSION-tidy \
        php$PHP_VERSION-xml \
        php$PHP_VERSION-zip \
        php-phalcon \
        php-amqp \
        php-igbinary \
        php-yaml \
        php-pear \
    && rm -rf /tmp/* /var/tmp/* \
    && apt-get autoremove -y \
    && apt-get autoclean -y \
    && apt-get clean -y

RUN echo "#!/bin/sh\nexit 0" > /usr/sbin/policy-rc.d \
    && sed -i -e "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g" ${PHP_CONF_PATH} \
    && sed -i -e "s/upload_max_filesize\s*=\s*2M/upload_max_filesize = 100M/g" ${PHP_CONF_PATH} \
    && sed -i -e "s/post_max_size\s*=\s*8M/post_max_size = 100M/g" ${PHP_CONF_PATH} \
    && sed -i -e "s/^;clear_env = no$/clear_env = no/" ${FPM_CONF_PATH} \
    && sed -i -e "/listen = .*/c\listen = [::]:8000" ${FPM_CONF_PATH}

RUN pecl update-channels \
    && pecl -d php_suffix=$PHP_VERSION install -o -f redis memcached imagick \
    && echo "extension=redis.so" > /etc/php/$PHP_VERSION/mods-available/redis.ini \
    && echo "extension=memcached.so" > /etc/php/$PHP_VERSION/mods-available/memcached.ini \
    && echo "extension=imagick.so" > /etc/php/$PHP_VERSION/mods-available/imagick.ini \
    && ln -sf /etc/php/$PHP_VERSION/mods-available/redis.ini /etc/php/$PHP_VERSION/fpm/conf.d/20-redis.ini \
    && ln -sf /etc/php/$PHP_VERSION/mods-available/redis.ini /etc/php/$PHP_VERSION/cli/conf.d/20-redis.ini \
    && ln -sf /etc/php/$PHP_VERSION/mods-available/memcached.ini /etc/php/$PHP_VERSION/fpm/conf.d/20-memcached.ini \
    && ln -sf /etc/php/$PHP_VERSION/mods-available/memcached.ini /etc/php/$PHP_VERSION/cli/conf.d/20-memcached.ini \
    && ln -sf /etc/php/$PHP_VERSION/mods-available/imagick.ini /etc/php/$PHP_VERSION/fpm/conf.d/20-imagick.ini \
    && ln -sf /etc/php/$PHP_VERSION/mods-available/imagick.ini /etc/php/$PHP_VERSION/cli/conf.d/20-imagick.ini \
    && rm -rf /tmp/* /var/tmp/* \
    && apt-get autoremove -y \
    && apt-get autoclean -y \
    && apt-get clean -y

RUN mkdir -p /app
COPY ./src/backend /app

WORKDIR /app

VOLUME /app/vendor \
       /app/repository

RUN curl -o /tmp/composer-setup.php https://getcomposer.org/installer \
    && curl -o /tmp/composer-setup.sig https://composer.github.io/installer.sig \
    && php /tmp/composer-setup.php \
        --no-ansi \
        --install-dir=/usr/local/bin \
        --filename=composer \
        --version=${COMPOSER_VERSION} \
    && composer install --no-scripts --no-autoloader \
    && composer dump-autoload --optimize

CMD ["php-fpm7.3", "--nodaemonize", "--fpm-config=/etc/php/7.3/fpm/pool.d/www.conf"]

EXPOSE 8000
