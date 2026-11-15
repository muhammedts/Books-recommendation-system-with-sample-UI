#!/bin/sh
set -e

cd /var/www/html

if [ -z "$APP_KEY" ]; then
    echo "APP_KEY is not set; generating a temporary key (sessions reset on restart)." >&2
    APP_KEY="base64:$(head -c 32 /dev/urandom | base64)"
    export APP_KEY
fi

php artisan storage:link --force >/dev/null 2>&1 || true
php artisan migrate --force

php artisan config:cache
php artisan route:cache
php artisan view:cache

exec "$@"
