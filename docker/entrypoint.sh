#!/bin/bash
set -e

echo "========================================="
echo "  GET READY — Starting Application"
echo "========================================="

# Set PORT (Render injects $PORT, default 10000)
export PORT=${PORT:-10000}

# Update Apache to listen on the correct port
sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf
sed -i "s/*:10000/*:$PORT/g" /etc/apache2/sites-available/000-default.conf

echo ">>> Apache will listen on port $PORT"

# Ensure we don't use a cached .env file (force Render's injected environment variables)
rm -f .env

# Clear any stale cached config (env vars are injected at runtime by Render)
php artisan config:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true

# Generate APP_KEY if not provided
if [ -z "$APP_KEY" ]; then
    echo ">>> Generating APP_KEY..."
    php artisan key:generate --force
fi

# Run database migrations
echo ">>> Running database migrations..."
php artisan migrate --force

# Create storage symlink
echo ">>> Creating storage symlink..."
php artisan storage:link 2>/dev/null || true

# Cache config, routes, and views for performance
echo ">>> Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ">>> Application ready! Starting Apache..."
echo "========================================="

# Start Apache in foreground
exec apache2-foreground
