#!/bin/sh

set -e

echo "Waiting for MariaDB..."

until mariadb-admin ping \
    -h "db" \
    -u "mental_health" \
    -p "secret" \
    --silent
do
    sleep 2
done

echo "MariaDB is ready."

if [ ! -f vendor/autoload.php ]; then
    echo "Installing Composer dependencies..."
    composer install --no-interaction
fi

composer dump-autoload --optimize

if [ ! -f .env ]; then
    echo "Creating .env..."
    cp .env.example .env
fi

mkdir -p storage/framework/cache
mkdir -p storage/framework/views
mkdir -p storage/framework/sessions
mkdir -p storage/logs
mkdir -p bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache || true
chmod -R ug+rwx storage bootstrap/cache

if ! grep -q "^APP_KEY=base64:" .env; then
    echo "Generating APP_KEY..."
    php artisan key:generate --force
fi

echo "Running Laravel setup..."

php artisan optimize:clear
php artisan migrate --force

echo "Starting Apache..."

exec apache2-foreground
