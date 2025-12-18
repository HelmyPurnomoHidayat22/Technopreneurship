#!/usr/bin/env bash
# exit on error
set -o errexit

echo "Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "Caching configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Build completed successfully!"
