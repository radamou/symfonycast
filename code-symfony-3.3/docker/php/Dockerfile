FROM php:7.3-fpm AS base

WORKDIR /var/www

ARG IS_MAC
ARG GID
ARG UID
ENV current_os=linux

# Package install
RUN apt-get update && apt-get install -y \
    unzip \
    libpq-dev \
    libz-dev \
    libmemcached-dev \
    libxml2-dev \
    libicu-dev \
    libzip-dev \
    vim \
    shellcheck \
    librabbitmq-dev \
    poppler-utils \
    graphviz \
    rsync \
    software-properties-common \
    python3-pip \
    git \
    autoconf \
    gcc \
    g++ \
    make \
    iputils-ping \
    wget \
    gnupg2 \
    && pip3 install --upgrade pip \
    && pecl install xdebug amqp \

# PHP ext
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql calendar bcmath soap intl zip opcache sockets \
    && docker-php-ext-enable xdebug sockets opcache amqp \

# Config home dir
    && usermod -u $UID www-data -d /home/www-data --shell /bin/bash && \
    mkdir -p /home/www-data && \
    chown www-data:www-data /home/www-data && \
    chown -R www-data:www-data /var/www \

# Configure Timezone
    && ln -fs /usr/share/zoneinfo/Europe/Paris /etc/localtime && \
    echo "Europe/Paris" > /etc/timezone \

# Install composer
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \

# Blackfire
    && version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/$current_os/amd64/$version \
    && mkdir -p /tmp/blackfire \
    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp/blackfire \
    && mv /tmp/blackfire/blackfire-*.so $(php -r "echo ini_get('extension_dir');")/blackfire.so \
    && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8707\n" > $PHP_INI_DIR/conf.d/blackfire.ini \
    && rm -rf /tmp/blackfire /tmp/blackfire-probe.tar.gz

#install ast ext
RUN docker-php-ext-install pcntl \
    && git clone -q https://github.com/nikic/php-ast.git \
    && cd php-ast \
    && phpize && ./configure && make install \
    && mv ./modules/ast.so /usr/local/lib/php/extensions/ast.so \
    && echo "extension=$(find /usr/local/lib/php/extensions/ -name ast.so)" > $PHP_INI_DIR/conf.d/ast.ini \
    && cd .. && rm -rf php-ast

#Install php cs
RUN curl -L https://cs.symfony.com/download/php-cs-fixer-v2.phar -o php-cs-fixer \
    && chmod a+x php-cs-fixer \
    && mv php-cs-fixer /usr/local/bin/php-cs-fixer

#Install phive
RUN wget -O phive.phar https://phar.io/releases/phive.phar \
    && wget -O phive.phar.asc https://phar.io/releases/phive.phar.asc \
    && gpg2 --keyserver pool.sks-keyservers.net --recv-keys 0x9D8A98B29B2D5D79 \
    && gpg2 --verify phive.phar.asc phive.phar \
    && chmod +x phive.phar \
    && mv phive.phar /usr/local/bin/phive

COPY custom.ini $PHP_INI_DIR/conf.d/custom.ini
COPY docker-php-ext-xdebug.ini $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini
COPY 10-opcache.ini $PHP_INI_DIR/conf.d/10-opcache.ini

CMD ["php-fpm", "-F"]
