FROM php:8.2-fpm

# Устанавливаем необходимые зависимости
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libonig-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo_mysql mbstring zip

# Устанавливаем Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Рабочая директория в Laravel
WORKDIR /var/www

# Создаем директории для storage и bootstrap/cache, если их нет
RUN mkdir -p /var/www/storage /var/www/bootstrap/cache

# Устанавливаем правильные права для папок storage и bootstrap/cache
RUN chown -R www-data:www-data /var/www && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Устанавливаем права для всей директории проекта
RUN chmod -R 755 /var/www && \
    chown -R www-data:www-data /var/www

# Устанавливаем права на запись для нужных директорий
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache