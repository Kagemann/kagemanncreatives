#!/bin/bash

# Kagemann Creatives - Docker Startup Script

echo "🚀 Starting Kagemann Creatives WordPress Environment..."

# Wait for database to be ready
echo "⏳ Waiting for database to be ready..."
while ! mysqladmin ping -h"$WORDPRESS_DB_HOST" -u"$WORDPRESS_DB_USER" -p"$WORDPRESS_DB_PASSWORD" --silent; do
    echo "Waiting for database..."
    sleep 2
done

echo "✅ Database is ready!"

# Set proper permissions
echo "🔧 Setting up permissions..."
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html

# Start Apache
echo "🌐 Starting Apache..."
exec apache2-foreground
