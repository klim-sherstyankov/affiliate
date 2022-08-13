FROM registry.marfa-tech.net/dockerhub_proxy/library/nginx:1.11-alpine

RUN set -x \
    && addgroup -g 82 -S www-data \
    && adduser -u 82 -D -S -G www-data www-data

COPY ./docker/nginx/config /etc/nginx/
COPY ./docker/nginx/boot.sh /usr/local/bin/boot_nginx

CMD ["sh", "/usr/local/bin/boot_nginx"]
