FROM nginx:1.23-alpine

RUN set -x \
    && apk upgrade \
    && apk add --no-cache bash \
    && (delgroup www-data || true) \
    && adduser -D -H -u 82 -s /bin/bash www-data

COPY ./docker/nginx/config /etc/nginx/
COPY ./docker/nginx/boot.sh /usr/local/bin/boot_nginx

CMD ["sh", "/usr/local/bin/boot_nginx"]
