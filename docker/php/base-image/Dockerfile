FROM php:8.2-fpm as build

#set timezone
ENV TIMEZONE=Europe/Moscow

RUN apt-get update \
    && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        nghttp2 \
        libmagickwand-dev \
        libmagickwand-dev \
        libpq-dev \
        libgmp-dev \
        libxml2-dev \
        libpng++-dev \
        libonig-dev \
        libzip-dev \
        libwebp-dev \
        cron \
        file \
        git \
        zip \
        vim \
        mc \
        php-mysql \
        php-pdo \
        nano \
        curl \
    && pecl install imagick apcu xdebug

RUN curl "https://github.com/tideways/php-xhprof-extension/archive/v5.0.4.tar.gz" -fsL -o ./php-xhprof-extension.tar.gz \
    && tar xf ./php-xhprof-extension.tar.gz \
    && cd php-xhprof-extension-5.0.4 \
    && phpize \
    && ./configure \
    && make \
    && make install
RUN rm -rf ./php-xhprof-extension.tar.gz ./php-xhprof-extension-5.0.4

RUN docker-php-ext-install -j$(nproc) gd bcmath intl sysvmsg sysvsem sysvshm gmp opcache pdo pdo_mysql pcntl soap sockets zip\
    && docker-php-ext-enable imagick tideways_xhprof \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && rm -rf /var/lib/apt/lists/* \
    && echo "extension=apcu.so" > /usr/local/etc/php/conf.d/apcu.ini \
    && echo "apc.enable_cli=1" >> /usr/local/etc/php/conf.d/apcu.ini

COPY --from=composer:2.1.9 /usr/bin/composer /usr/bin/composer

WORKDIR /app
