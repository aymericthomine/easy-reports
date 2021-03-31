#!/usr/bin/env bash

killall cloud_sql_proxy

cloud_sql_proxy -instances=molitor-partners:europe-west2:molitor-partners=tcp:3307 &

sleep 5

php artisan queue:work

