#!/bin/bash

ROOT_DIR=$PWD'/'
ENV=$ROOT_DIR'.env'

if ! -d "$ROOT_DIR"'vendor'; then
    composer install
fi

if ! -f "$ENV"; then
    cp "$ROOT_DIR"'.env.example' "$ENV"
    php artisan key:generate
fi

php artisan serve --host=0.0.0.0
