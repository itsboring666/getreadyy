#!/usr/bin/env bash
# GET READY — Render.com Build Script
set -o errexit

echo "=== Installing PHP dependencies ==="
composer install --no-dev --optimize-autoloader

echo "=== Generating application key ==="
php artisan key:generate --force

echo "=== Running database migrations ==="
php artisan migrate --force

echo "=== Seeding default settings ==="
php artisan db:seed --class=SettingsSeeder --force 2>/dev/null || echo "Settings seeder skipped (already exists or not found)"

echo "=== Caching configuration ==="
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=== Creating storage symlink ==="
php artisan storage:link || true

echo "=== Build complete! ==="
