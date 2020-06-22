FROM php:7.4-fpm-alpine

RUN apk --no-cache add php7 php7-pdo php7-pdo_sqlite php7-fpm php7-opcache php7-mysqli php7-json php7-openssl php7-curl \
    php7-zlib php7-xml php7-phar php7-intl php7-dom php7-xmlreader php7-ctype php7-session \
    php7-mbstring php7-gd nginx supervisor curl && \
    rm /etc/nginx/conf.d/default.conf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

COPY .docker/nginx.conf /etc/nginx/nginx.conf
COPY .docker/fpm-pool.conf /etc/php7/php-fpm.d/www.conf
COPY .docker/php.ini /etc/php7/conf.d/custom.ini
COPY .docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN mkdir -p /app

RUN chown -R nobody.nobody /app && \
  chown -R nobody.nobody /run && \
  chown -R nobody.nobody /var/lib/nginx && \
  chown -R nobody.nobody /var/log/nginx

USER nobody

WORKDIR /app
COPY --chown=nobody . /app/

RUN composer --working-dir=. install
RUN composer install --optimize-autoloader --no-dev
RUN touch database/sqlite/database.sqlite && php artisan migrate --force

ARG GIT_SHA
ENV APP_GIT_SHA $GIT_SHA

EXPOSE 8080

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
