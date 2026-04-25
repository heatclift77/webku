#!/usr/bin/env sh
set -eu

cd /var/www/html

PORT="${PORT:-10000}"
SQLITE_DB_PATH="${SQLITE_DB_PATH:-/var/www/html/database/data/database.sqlite}"

mkdir -p "$(dirname "$SQLITE_DB_PATH")"
mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
touch "$SQLITE_DB_PATH"

chown -R www-data:www-data storage bootstrap/cache database
chmod -R ug+rwX storage bootstrap/cache database

sed -ri "s/Listen [0-9]+/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -ri "s/:([0-9]+)>/:${PORT}>/g" /etc/apache2/sites-available/000-default.conf

su -s /bin/sh www-data -c "php artisan migrate --force"
su -s /bin/sh www-data -c "php artisan config:cache"
su -s /bin/sh www-data -c "php artisan route:cache || php artisan route:clear"
su -s /bin/sh www-data -c "php artisan view:cache"

exec apache2-foreground
