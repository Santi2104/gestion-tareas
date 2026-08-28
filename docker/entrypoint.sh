#!/bin/sh
set -e

echo "Iniciando contenedor Laravel App..."

# Fix directory permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Wait for MariaDB / MySQL database connection
echo "Esperando disponibilidad de la base de datos (${DB_HOST}:${DB_PORT:-3306})..."
max_retries=30
count=0
until php -r "try { new PDO('mysql:host=' . getenv('DB_HOST') . ';port=' . (getenv('DB_PORT') ?: 3306) . ';dbname=' . getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), [PDO::ATTR_TIMEOUT => 3]); exit(0); } catch (Exception \$e) { exit(1); }"; do
    count=$((count+1))
    if [ $count -ge $max_retries ]; then
        echo "❌ Error: La base de datos no estuvo disponible a tiempo tras $max_retries intentos."
        exit 1
    fi
    echo "   ...intento $count/$max_retries - esperando..."
    sleep 2
done

echo "Base de datos conectada correctamente."

echo "📦 Ejecutando migraciones y seeders de prueba..."
php artisan migrate --force --seed

echo "Optimizando caches de Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🎉 Aplicación lista. Levantando PHP-FPM..."
exec "$@"
