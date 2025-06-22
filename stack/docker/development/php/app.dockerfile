FROM php:8.2.0-fpm

RUN apt-get update && apt-get install -y  \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    libzip-dev \
    unzip \
    redis \
    --no-install-recommends \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql -j$(nproc) gd

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

# Use development PHP configuration instead of production for better error reporting
RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

# Configure PHP-FPM to listen on port 9000 and be accessible from any IP
RUN echo "listen = 0.0.0.0:9000" >> /usr/local/etc/php-fpm.d/zz-docker.conf

# Increase PHP memory limit and execution time for better performance
RUN echo "memory_limit = 256M" >> $PHP_INI_DIR/conf.d/docker-php-memlimit.ini \
    && echo "max_execution_time = 120" >> $PHP_INI_DIR/conf.d/docker-php-timeouts.ini
