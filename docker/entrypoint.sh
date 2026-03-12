#!/bin/sh
set -e

cd /var/www/html

if [ -n "${DB_HOST}" ] && [ -n "${DB_PORT}" ]; then
  echo "[nails] Waiting for MySQL at ${DB_HOST}:${DB_PORT}..."
  until php -r "new PDO('mysql:host=${DB_HOST};port=${DB_PORT}', '${DB_USERNAME}', '${DB_PASSWORD}');" >/dev/null 2>&1; do
    sleep 2
  done
fi

if [ -n "${DB_ROOT_PASSWORD}" ] && [ -n "${DB_DATABASE}" ] && [ -n "${DB_USERNAME}" ] && [ -n "${DB_PASSWORD}" ]; then
  echo "[nails] Ensuring dedicated database/user exist..."
  mysql --protocol=TCP --ssl-mode=DISABLED -h "${DB_HOST}" -P "${DB_PORT}" -uroot -p"${DB_ROOT_PASSWORD}" <<SQL || true
CREATE DATABASE IF NOT EXISTS ${DB_DATABASE} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS '${DB_USERNAME}'@'%' IDENTIFIED BY '${DB_PASSWORD}';
ALTER USER '${DB_USERNAME}'@'%' IDENTIFIED BY '${DB_PASSWORD}';
GRANT ALL PRIVILEGES ON ${DB_DATABASE}.* TO '${DB_USERNAME}'@'%';
FLUSH PRIVILEGES;
SQL
fi

if [ ! -f .env ]; then
  cp .env.example .env
fi

# Si APP_KEY viene como variable de entorno, inyectarla en .env para sobrevivir rebuilds.
if [ -n "${APP_KEY}" ]; then
  sed -i "s|^APP_KEY=.*|APP_KEY=${APP_KEY}|" .env
elif ! grep -q "^APP_KEY=base64:" .env; then
  php artisan key:generate --force
fi

php artisan migrate --force
php artisan db:seed --force
# Symlink relativo para que Caddy pueda resolver storage a través del volumen montado.
php artisan storage:link --relative || true
php artisan filament:assets --ansi 2>/dev/null || true

chown -R www-data:www-data storage bootstrap/cache public || true

if [ "${NAILS_HTTP_MODE}" = "artisan" ]; then
  exec php artisan serve --host=0.0.0.0 --port=8000
fi

exec php-fpm -F
