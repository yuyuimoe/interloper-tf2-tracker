FROM php:8.3-fpm

RUN apt-get update && apt-get install -y git unzip libzip-dev libpq-dev supervisor

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
  && docker-php-ext-install zip pdo pdo_pgsql pgsql

RUN mkdir -p /etc/supervisor/conf.d/

COPY supervisor.conf /etc/supervisor/conf.d/supervisor.conf

WORKDIR /var/www

ENV PATH="$PATH:/usr/local/bin"

CMD ["supervisord", "-n"]
