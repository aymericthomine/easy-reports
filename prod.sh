#!/usr/bin/env bash

cp .env_PROD .env
cp app.yaml_PROD app.yaml

killall cloud_sql_proxy

sleep 1

cloud_sql_proxy -instances=molitor-partners:europe-west2:molitor-partners=tcp:3307 &

sleep 5

php artisan queue:work

