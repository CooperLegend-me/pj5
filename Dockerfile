FROM php:8.1-fpm

# Установка системных зависимостей
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx

# Очистка кэша apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Установка PHP расширений
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Получение composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Установка рабочей директории
WORKDIR /var/www

# Копирование файлов проекта
COPY . /var/www

# Установка зависимостей
RUN composer install --optimize-autoloader --no-dev

# Установка прав
RUN chown -R www-data:www-data /var/www

# Копирование nginx конфигурации
COPY nginx.conf /etc/nginx/sites-available/default

# Экспорт порта
EXPOSE 80

# Запуск nginx и php-fpm
CMD service nginx start && php-fpm 