#!/usr/bin/env bash

# php artisan config:clear
# php artisan view:clear
# php artisan cache:clear
# php artisan optimize:clear
# php artisan route:clear
composer dumpautoload
npm run prod

cp app.yaml_PROD app.yaml

# gcloud app deploy app.yaml --project molitor-partners
gcloud beta app deploy app.yaml --project molitor-partners --no-cache

