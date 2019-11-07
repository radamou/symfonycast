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
    # Upgrade pip and install sphinx
    && pip3 install --upgrade pip \
    && pecl install xdebug amqp \

# PHP ext
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql calendar bcmath soap intl zip opcache \
    && docker-php-ext-enable xdebug amqp \

# Config home dir
    && usermod -u $UID www-data -d /home/www-data --shell /bin/bash && \
    mkdir -p /home/www-data && \
    chown www-data:www-data /home/www-data && \
    chown -R www-data:www-data /var/www \
# Configure Timezone
    && ln -fs /usr/share/zoneinfo/Europe/Paris /etc/localtime && \
    echo "Europe/Paris" > /etc/timezone \

# Enable Xdebug
    && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_port=9000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.var_display_max_depth = 10" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.default_enable = 1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && if [ ${IS_MAC} ]; then \
    echo "xdebug.remote_host = 10.254.254.254" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_connect_back = 0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    else \
    echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    fi \
# Install composer
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
# Install wkhtmltopdf
    && curl -L https://github.com/wkhtmltopdf/wkhtmltopdf/releases/download/0.12.3/wkhtmltox-0.12.3_linux-generic-amd64.tar.xz -o /tmp/wkhtmltox.tar.xz \
    && tar -xJf /tmp/wkhtmltox.tar.xz -C /tmp/ \
    && rsync -art /tmp/wkhtmltox/ /usr/local \
    && echo "#!/usr/bin/env bash\nxvfb-run -a -s \"-screen 0 {{ wkhtmltopdf_xvfb_size }}\" wkhtmltopdf \"$@\"" >> /usr/local/bin/wkhtmltopdf.sh \
# Customize PS1 and a welcome message
    && echo "PS1='\[\e[1;32m\]\u@\H:\[\e[m\] \[\e[1;37m\]\w\[\e[m\]\n\[\e[1;33m\]hist:\! \[\e[0;33m\] \[\e[1;31m\]jobs:\j \$\[\e[m\] '" >> /root/.bashrc \
    && echo "echo '\033[42m WELCOME DOCKER \033[0m'" >> /root/.bashrc \
# Blackfire
    && version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/$current_os/amd64/$version \
    && mkdir -p /tmp/blackfire \
    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp/blackfire \
    && mv /tmp/blackfire/blackfire-*.so $(php -r "echo ini_get('extension_dir');")/blackfire.so \
    && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8707\n" > $PHP_INI_DIR/conf.d/blackfire.ini \
    && rm -rf /tmp/blackfire /tmp/blackfire-probe.tar.gz

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

COPY docker/php/custom.ini $PHP_INI_DIR/conf.d/custom.ini

CMD ["php-fpm", "-F"]
