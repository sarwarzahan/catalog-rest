FROM composer as composer
COPY . /app
RUN composer install --ignore-platform-reqs --no-scripts

FROM phpdockerio/php7-fpm:latest

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install  php7.0-mysql php7.0-gd php7.0-mbstring php7.0-xml \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*


WORKDIR "/var/www/html"

COPY . /var/www/html
COPY --from=composer /app/vendor /var/www/html/vendor