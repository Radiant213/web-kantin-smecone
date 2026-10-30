FROM php:8.3-fpm

# Install system dependencies for PHP extensions & utilities
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    libgmp-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl opcache gmp \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install official Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy custom PHP configuration
COPY ./docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www/kantin

EXPOSE 9000

CMD ["php-fpm"]

