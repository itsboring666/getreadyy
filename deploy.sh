#!/bin/bash
# GET READY - Professional Deployment Script
# Run this script on your production server (e.g. AWS, DigitalOcean) to safely deploy new updates.

set -e

echo "🚀 Starting Deployment Process..."

# 1. Enter Maintenance Mode
echo "🔒 Entering maintenance mode..."
php artisan down || true

# 2. Pull latest code (Uncomment if using Git)
# echo "📥 Pulling latest code from repository..."
# git pull origin main

# 3. Install/Update Composer Dependencies (No Dev)
echo "📦 Installing production dependencies..."
composer install --optimize-autoloader --no-dev

# 4. Clear and Cache Configurations
echo "🧹 Clearing old caches and regenerating optimized caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 5. Run Database Migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

# 6. Build Frontend Assets (Uncomment if using Vite/NPM heavily in production)
# echo "🎨 Building frontend assets..."
# npm install
# npm run build

# 7. Exit Maintenance Mode
echo "🔓 Exiting maintenance mode..."
php artisan up

echo "✅ Deployment Complete! The application is live."
