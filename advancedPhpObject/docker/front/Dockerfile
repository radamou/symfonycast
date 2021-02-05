FROM php:8.0-fpm-alpine

WORKDIR /srv/app

RUN apk add --no-cache \
        php8-intl \
        php8-ctype \
        php8-bcmath \
        php8-mbstring \
        php8-iconv \
        php8-pcntl \
        php8-json \
        php8-xml \
        php8-dom \
        php8-posix \
        php8-session \
        php8-pdo \
        php8-tokenizer \
        php8-zip \
        php8-simplexml \
        file

# OpCache

RUN apk add --no-cache \
        php8-opcache

COPY config/cache.ini /etc/php8/conf.d/cache.ini

ENV PROJECT_DIR="/srv/app"

# Entrypoints
RUN apk add --no-cache \
    bash \
    coreutils \
    su-exec

COPY config/entrypoint-init /bin/entrypoint-init

ENTRYPOINT ["/bin/entrypoint-init"]

COPY config/entrypoint-exec /bin/entrypoint-exec

# MySQL

RUN apk add --no-cache \
        php8-pdo_mysql \
        php8-mysqlnd

# Api

RUN apk add --no-cache \
        php8-curl

# Nginx

RUN apk add --no-cache \
        nginx

COPY config/nginx.conf /etc/nginx/nginx.conf

#COPY config/php-fpm.conf /etc/php8/php-fpm.conf

COPY config/supervisord_fpm.conf /etc/supervisor/conf_enabled/fpm.conf

EXPOSE 80

# Permission fixer

ENV PERMITTED_USERS="root nginx"

ENV PERMITTED_UID=1000

ENV PERMITTED_GID=1000

RUN id -u root || adduser -D root

RUN id -u nginx || adduser -D nginx

RUN apk add --no-cache \
    shadow

COPY config/90-init-permission /usr/share/docker/init.d/root/

ENV ENTRYPOINT_UMASK=002

# Supervisor

RUN apk add --no-cache \
        supervisor

COPY config/supervisor.conf /etc/supervisor/supervisord.conf

CMD ["supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]

ENV LOGSTREAM_PATH=/tmp/stdoutfifo

COPY config/logstream /usr/bin/logstream

COPY config/supervisord_logstream.conf /etc/supervisor/conf_enabled/logstream.conf

RUN apk add --no-cache \
        curl

HEALTHCHECK --interval=10s --timeout=6s --start-period=120s CMD curl --silent --output /dev/null "http://localhost/" || exit 1

STOPSIGNAL SIGQUIT

# App specific

RUN apk add --no-cache \
        php8-ftp \
        php8-fileinfo \
        php8-exif \
        php8-xmlreader \
        php8-xmlwriter \
        php8-soap \
        php8-openssl \
        php8-phar


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

#php cs-fix-fixer installation
RUN curl -L https://cs.symfony.com/download/php-cs-fixer-v2.phar -o php-cs-fixer
RUN chmod a+x php-cs-fixer
RUN mv php-cs-fixer /usr/local/bin/php-cs-fixer


ENV PROJECT_ENV="dev" \
    TZ=UTC

EXPOSE 80
