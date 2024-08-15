ARG APP_ENV=prod
ARG BUILD_ENV=local

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

COPY public public/
COPY bin bin/
COPY symfony.lock symfony.lock

COPY composer.json composer.json
COPY composer.lock composer.lock
COPY .env.dist .env
#COPY phpunit.xml.dist phpunit.xml
#COPY .php-cs-fixer.dist.php .php-cs-fixer.dist.php
#COPY phpcs.xml.dist auth.j* ./

COPY docker/php/php.ini /usr/local/etc/php/conf.d/custom-php.ini

#Configure ssh
#RUN mkdir /root/.ssh/ && touch /root/.ssh/known_hosts
#RUN ssh-keyscan -t rsa github.com >> /etc/ssh/ssh_known_hosts 2> /dev/null
#RUN ssh-keyscan -t rsa bitbucket.org >> /etc/ssh/ssh_known_hosts 2> /dev/null
#
#RUN composer install --no-scripts --no-autoloader --no-dev

#COPY migrations migrations/
COPY config config/
#COPY parameters parameters/
COPY src src/
#COPY tests tests/

#RUN composer dump-autoload --no-scripts --optimize

ARG BRANCH
ARG PROJECT_NAME
ARG COMPOSE_PROJECT_NAME
ARG DATABASE_URL

FROM build as build_with_devs
#Configure bash
#RUN #echo 'alias phpd="php -dzend_extension=xdebug.so"' >> ~/.bashrc

ARG BRANCH

RUN echo "export BRANCH=${BRANCH}" >> ~/.bashrc
RUN echo 'export PS1A="\\t \[$(tput sgr0)\]\[\033[38;5;45m\]\u\[$(tput sgr0)\]\[\033[38;5;15m\] > \[$(tput sgr0)\]\[\033[38;5;75m\]\w\[$(tput sgr0)\]\[\033[38;5;15m\] \[$(tput sgr0)\]"' >> ~/.bashrc
RUN echo 'export PS1="${PS1A}\[\033[38;5;187m\]\${BRANCH}\[$(tput sgr0)\] "' >> ~/.bashrc

#RUN composer install --no-scripts --no-autoloader --no-interaction
#RUN composer dump-autoload --no-scripts --optimize