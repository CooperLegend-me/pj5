FROM php:8.1-apache

# Установка системных зависимостей
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Очистка кэша apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Установка PHP расширений
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Включение mod_rewrite для Apache
RUN a2enmod rewrite

# Установка composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Настройка директории приложения
WORKDIR /var/www/html

# Копирование файлов проекта
COPY . .

# Установка зависимостей
RUN composer install --optimize-autoloader --no-dev

# Установка прав
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Настройка Apache
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Экспозиция порта
EXPOSE 80

# Запуск Apache
CMD ["apache2-foreground"] 