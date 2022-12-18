#!/bin/bash

# Turn on maintenance mode
php72 artisan down

# Install composer dependecies
php72 composer.phar install --no-interaction --prefer-dist --optimize-autoloader

# Run database migrations
php72 artisan migrate --force

# Reseed changeble tables
php72 artisan db:seed --class=AdminMenuSeeder
php72 artisan db:seed --class=CustomPermissionsTableSeeder
php72 artisan db:seed --class=CustomConnectRelationshipsSeeder

# Clear caches
php72 artisan cache:clear

# Clear expired password reset tokens
php72 artisan auth:clear-resets

# Clear and cache routes
php72 artisan route:cache

# Clear and cache config
php72 artisan config:cache

# Install node modules
npm install

# Build assets using Laravel Mix
npm run server
npm run client

# Generate API documentation
apidoc -i app/Http/Controllers/Api -o public/doc

# Turn off maintenance mode
php72 artisan up
