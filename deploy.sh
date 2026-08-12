#!/bin/bash
set -e

echo "=== Railway Deploy Script ==="

# تنصيب اعتماديات Composer
echo "Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# توليد APP_KEY إذا لم يكن موجوداً
if [ -z "$APP_KEY" ]; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# تحسين الـ config و routes و views
echo "Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# تشغيل الـ migrations
echo "Running migrations..."
php artisan migrate --force

# بناء الـ assets
echo "Building frontend assets..."
npm install
npm run build

echo "=== Deploy Complete ==="
