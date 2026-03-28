# Dockerfile Laravel pour Render

# 1. Image PHP avec FPM et extensions nécessaires
FROM php:8.2-fpm

# 2. Installer dépendances et extensions PHP
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    curl \
    && docker-php-ext-install pdo pdo_mysql

# 3. Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Copier le projet Laravel
WORKDIR /var/www
COPY . .

# 5. Installer les dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# 6. Générer la clé Laravel
RUN php artisan key:generate

# 7. Exposer le port pour Render
EXPOSE 9000

# 8. Commande pour lancer Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9000"]
