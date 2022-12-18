FROM php:7.3-fpm

ARG user_uid
RUN usermod -u ${user_uid? invalid argument} www-data
RUN groupmod -g ${user_uid? invalid argument} www-data

RUN apt-get update && apt-get upgrade -y  \
    $PHPIZE_DEPS \
    bash \
    git \
    libmagickwand-dev \
    libmcrypt-dev \
    libpng-dev \
    libwebp-dev \
    libzip-dev \
    libpq-dev \
    nodejs \
    npm \
    openssl \
    postgresql \
    sudo \
    unzip \
    vim \
    wget \
    zip

RUN pecl install imagick \
    && docker-php-ext-enable imagick

RUN pecl install xdebug-2.7.1 \
    && docker-php-ext-enable xdebug

RUN docker-php-ext-install \
    bcmath \
    gd \
    mbstring \
    pdo \
    pdo_pgsql \
    tokenizer \
    zip \
    intl

RUN npm install apidoc -g

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --version="1.10.10" --filename=composer
