ARG APP_ENV=prod
ARG BUILD_ENV=local

FROM registry.marfa-tech.net/aramuz/php:8.0.17-fpm as build

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
RUN mkdir /root/.ssh/ && touch /root/.ssh/known_hosts
RUN ssh-keyscan -t rsa github.com >> /etc/ssh/ssh_known_hosts 2> /dev/null
RUN ssh-keyscan -t rsa bitbucket.org >> /etc/ssh/ssh_known_hosts 2> /dev/null

ARG COMPOSER_AUTH
ENV COMPOSER_AUTH=${COMPOSER_AUTH}

RUN composer install --no-scripts --no-autoloader --no-dev

#COPY migrations migrations/
COPY config config/
#COPY parameters parameters/
COPY src src/
#COPY tests tests/

RUN composer dump-autoload --no-scripts --optimize

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

RUN composer install --no-scripts --no-autoloader --no-interaction
RUN composer dump-autoload --no-scripts --optimize