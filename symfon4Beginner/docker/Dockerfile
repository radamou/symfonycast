FROM alpine:3.7

WORKDIR /srv/app

# PHP
RUN apk add --no-cache \
        php7

RUN apk add --no-cache \
        php7-intl \
        php7-ctype \
        php7-bcmath \
        php7-mbstring \
        php7-iconv \
        php7-pcntl \
        php7-json \
        php7-xml \
        php7-dom \
        php7-posix \
        php7-session \
        php7-pdo \
        php7-tokenizer \
        php7-zip \
        php7-simplexml \
        file

# OpCache

RUN apk add --no-cache \
        php7-opcache \
        php7-apcu

COPY config/cache.ini /etc/php7/conf.d/cache.ini


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
        php7-pdo_mysql \
        php7-mysqlnd

# Api

RUN apk add --no-cache \
        php7-curl

# Nginx

RUN apk add --no-cache \
        nginx \
        php7-fpm

COPY config/nginx.conf /etc/nginx/nginx.conf

COPY config/php-fpm.conf /etc/php7/php-fpm.conf

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
        php7-ftp \
        php7-fileinfo \
        php7-exif \
        php7-xmlreader \
        php7-xmlwriter \
        php7-soap \
        php7-openssl \
        php7-phar


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

#php cs-fix-fixer installation
RUN curl -L https://cs.symfony.com/download/php-cs-fixer-v2.phar -o php-cs-fixer
RUN chmod a+x php-cs-fixer
RUN mv php-cs-fixer /usr/local/bin/php-cs-fixer


ENV PROJECT_ENV="dev" \
    TZ=UTC

EXPOSE 80
