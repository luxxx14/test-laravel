# Используем официальный образ PHP с Nginx
FROM php:7.4-fpm-alpine

# Устанавливаем зависимости
RUN apk update && apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    libfreetype6-dev \
    libxml2-dev \
    git \
    bash \
    zlib-dev \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip intl opcache

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Устанавливаем рабочую директорию для приложения
WORKDIR /var/www

# Копируем только код проекта
COPY . /var/www

# Устанавливаем права на директории storage и bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Устанавливаем рабочий пользователь для контейнера
USER www-data

# Открываем порт 9000 для PHP-FPM
EXPOSE 9000

# Запускаем PHP-FPM
CMD ["php-fpm"]
