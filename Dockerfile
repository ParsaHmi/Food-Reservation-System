FROM php:8.2-fpm

# نصب dependencyهای سیستم
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    default-mysql-client \
    libpq-dev

# پاک کردن cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# نصب extensionهای PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# نصب Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# تنظیم working directory
WORKDIR /var/www/html