#!/bin/bash
set -e

cd /var/www

# Create required storage directories
mkdir -p /var/www/storage/framework/cache/data \
         /var/www/storage/framework/sessions \
         /var/www/storage/framework/views \
         /var/www/storage/logs \
         /var/www/storage/app/public \
         /var/www/bootstrap/cache

# Fix permissions
chmod -R 777 /var/www/storage /var/www/bootstrap/cache

# Run Laravel setup
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan storage:link 2>/dev/null || true

# Start PHP-FPM in background
php-fpm -D

# Start Nginx in foreground (keeps container alive)
nginx -g "daemon off;"