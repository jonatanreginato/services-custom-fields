#!/bin/bash

docker compose exec php composer update \
    --no-progress \
    --no-interaction \
    --ignore-platform-reqs \
    --optimize-autoloader \
    --apcu-autoloader
