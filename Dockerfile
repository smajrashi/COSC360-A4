# -----------------------
# Stage 1 — build frontend
# -----------------------
FROM node:18 AS node_builder
WORKDIR /app 

# Copy package files first for caching
COPY package*.json ./
COPY yarn.lock . 2>/dev/null || true

# copy everything (Vite needs resources/, vite.config.js, etc.)
COPY . .

# Install JS deps and build assets
RUN npm ci --silent
RUN npm run build

# -----------------------
# Stage 2 — final image
# -----------------------
FROM php:8.2-apache

# Install OS packages and PHP extensions needed for Laravel + Postgres
RUN apt-get update && apt-get install -y \
    git curl unzip zip libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev postgresql-client \
  && docker-php-ext-install pdo pdo_pgsql mbstring xml zip bcmath \
  && a2enmod rewrite

# Copy composer from official composer image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy application source
COPY . /var/www/html

# Copy built frontend assets from node stage (Vite usually outputs to public/build)
# Adjust path if your build outputs elsewhere
COPY --from=node_builder /app/public /var/www/html/public

# Install PHP dependencies (produces vendor/)
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# Fix permissions for storage and cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Place entrypoint script and make executable
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["entrypoint.sh"]
CMD ["apache2-foreground"]
