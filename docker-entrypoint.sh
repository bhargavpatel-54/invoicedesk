#!/bin/sh

# Ensure storage directories exist and have correct permissions
mkdir -p storage/framework/{sessions,views,cache}
chown -R www-data:www-data storage bootstrap/cache

# Run database migrations
# We use --force because this is production
php artisan migrate --force
php artisan config:clear
php artisan view:clear
php artisan cache:clear

# Start Apache in the foreground
exec apache2-foreground
