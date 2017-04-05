FROM php:7.1-cli
STOPSIGNAL SIGKILL
WORKDIR /opt
RUN pecl install redis
RUN docker-php-ext-enable redis
