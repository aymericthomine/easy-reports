#!/usr/bin/env bash

php artisan config:clear
php artisan view:clear
php artisan cache:clear
php artisan optimize:clear
php artisan route:clear

