include ${HTTP_TO_HTTPS_REDIRECT};

server {
    listen ${NGINX_LISTEN_PORT};

    include ${SSL_CONFIG};

    root /app/public;

    gzip on;
    gzip_comp_level 2;
    gzip_min_length 1000;
    gzip_proxied expired no-cache no-store private auth;
    gzip_types text/plain application/x-javascript application/javascript text/xml text/css application/xml;

    location / {
        try_files $uri /index.php$is_args$args;
    }

    location ~ ^/index\.php(/|$) {
        include fastcgi_params;
        include ${CORS_PROXY_CONFIG};

        fastcgi_pass ${PHP_FPM_HOST}:9000;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;

        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;

        fastcgi_param X-GeoIP-Country-Code  $http_x_geoip_country_code;
        fastcgi_param REMOTE_ADDR $http_x_forwarded_for;
        fastcgi_param X-GEOIP-CITY $http_x_geoip_city;

        fastcgi_param DOCUMENT_ROOT $realpath_root;

        fastcgi_buffer_size 1024k;
        fastcgi_buffers 4 512k;
        fastcgi_busy_buffers_size 1024k;

        internal;
    }

    location ~* ^.+\.(?:jpg|jpeg|gif|png|ico|css|zip|tgz|gz|rar|bz2|doc|xls|exe|pdf|ppt|tar|mid|midi|wav|bmp|rtf|js|woff|otf|eot|ttf|svg|pdf|pptx|html)$ {
        expires max;
        add_header Pragma public;
        add_header Cache-Control "public, must-revalidate, proxy-revalidate";
        try_files $uri $uri/ =404;
    }

    location ~ \.php$ {
        return 404;
    }

    error_log /var/log/nginx/error.log;
    access_log /var/log/nginx/access.log;
}
