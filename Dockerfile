FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nodejs \
    npm \
    netcat-traditional \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --optimize-autoloader --no-interaction \
    && npm install

RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache

RUN echo '#!/bin/bash\n\
set -e\n\
\n\
if [ ! -f .env ]; then\n\
    cp .env.example .env\n\
fi\n\
\n\
while ! nc -z db 3306; do\n\
    sleep 1\n\
done\n\
\n\
if ! grep -q "APP_KEY=base64:" .env; then\n\
    php artisan key:generate --no-interaction\n\
fi\n\
\n\

php artisan migrate:fresh --seed --no-interaction\n\
\n\
php artisan storage:link --no-interaction\n\
\n\
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache\n\
\n\
exec "$@"' > /usr/local/bin/entrypoint.sh \
    && chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 9000
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]