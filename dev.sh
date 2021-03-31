#!/usr/bin/env bash

cp .env_DEV .env
cp app.yaml_DEV app.yaml

killall cloud_sql_proxy >/dev/null 2>&1

php artisan queue:work

