FROM php:8.3-fpm

# Install modules
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libicu-dev \
        libzip-dev \
        libonig-dev \
        wget \
        git \
        curl \
        vim \
        nano \
        unzip \
        libcurl4-openssl-dev \
        libssl-dev \
        imagemagick \
            --no-install-recommends


RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install \
    zip \
    curl \
    bcmath \
    exif \
    gd \
    iconv \
    intl \
    mbstring \
    opcache \
    pdo_mysql

RUN pecl install xdebug-3.3.2 \
    && docker-php-ext-enable xdebug \
    && rm -rf /tmp/pear

COPY ./install-composer.sh /
COPY ./php.ini /usr/local/etc/php/
COPY ./xdebug.ini /usr/local/etc/php/conf.d
COPY ./www.conf /usr/local/etc/php/

RUN apt-get purge -y g++ \
    && apt-get autoremove -y \
    && rm -r /var/lib/apt/lists/* \
    && rm -rf /tmp/* \
    && sh /install-composer.sh \
    && rm /install-composer.sh

RUN usermod -u 1000 www-data

VOLUME /root/.composer
WORKDIR /app

EXPOSE 9000
CMD ["php-fpm"]
