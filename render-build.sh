#!/usr/bin/env bash
# exit on error
set -o errexit

# Install composer dependencies
composer install --no-dev --optimize-autoloader

# Install npm dependencies and build assets
npm install
npm run build

# Ensure storage directories exist and have correct permissions
mkdir -p storage/framework/{sessions,views,cache}
chmod -R 775 storage bootstrap/cache

# Run database migrations
php artisan migrate --force
