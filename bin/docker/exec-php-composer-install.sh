#!/bin/bash

docker compose exec php composer install \
    --no-progress \
    --no-interaction \
    --ignore-platform-reqs \
    --optimize-autoloader \
    --apcu-autoloader
