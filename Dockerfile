# ==========================================
# STAGE 1: Frontend Build & Unit Tests (Node)
# ==========================================
FROM node:22-alpine AS frontend-builder
WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY . .

# Quality Gate: Execute Vitest frontend unit tests
RUN npm run test:unit

# Build production assets with Vite
RUN npm run build

# ==========================================
# STAGE 2: Backend Dependencies & Unit Tests
# ==========================================
FROM php:8.4-cli-alpine AS backend-builder
WORKDIR /var/www/html

# Install build dependencies & PHP extensions needed for tests
RUN apk add --no-cache \
    git \
    unzip \
    libzip-dev \
    sqlite-dev \
    icu-dev \
    oniguruma-dev \
    && docker-php-ext-install \
    pdo_sqlite \
    pdo_mysql \
    zip \
    bcmath \
    intl \
    mbstring

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install full dependencies (excluding scripts until source files are copied)
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --no-progress --no-scripts

COPY . .

# Dump autoload with scripts enabled
RUN composer dump-autoload --optimize

# Quality Gate: Execute PHPUnit backend tests in isolated memory
RUN php -d memory_limit=-1 artisan test --compact

# Remove development dependencies for the production artifact
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# ==========================================
# STAGE 3: Production Runtime (PHP-FPM)
# ==========================================
FROM php:8.4-fpm-alpine AS production
WORKDIR /var/www/html

# Install runtime dependencies
RUN apk add --no-cache \
    bash \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    && docker-php-ext-install \
    pdo_mysql \
    zip \
    bcmath \
    intl \
    mbstring \
    opcache

# Copy clean backend vendor and code
COPY --from=backend-builder /var/www/html /var/www/html

# Copy compiled frontend assets from frontend-builder
COPY --from=frontend-builder /app/public/build /var/www/html/public/build

# Copy configurations and entrypoint script
COPY docker/php/local.ini /usr/local/etc/php/conf.d/local.ini
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]
