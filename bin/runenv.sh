#!/bin/bash

#if [ "$EUID" -ne 0 ]
#  then echo "Please run as root"
#  exit
#fi

echo ""
echo "$(date '+%Y-%m-%d %H:%M:%S,%3N') $(tput bold)$(tput setaf 4)INFO$(tput sgr0) Starting development environment..."

# Install npm dependencies
if ! command -v npm; then
    echo "$(date '+%Y-%m-%d %H:%M:%S,%3N') $(tput bold)$(tput setaf 4)INFO$(tput sgr0) Installing nvm..."
    curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.3/install.sh &> '/dev/null'
    . ~/.nvm/nvm.sh
    . ~/.bash_profile
    . ~/.zshrc
    . ~/.profile
    . ~/.bashrc
fi
nvm install 16 &> '/dev/null'
npm install --unsafe-perm --save-dev --quiet --no-progress &> '/dev/null'

# Installing and initializing the Commitizen command line tool
if ! command -v commitizen; then
    echo "$(date '+%Y-%m-%d %H:%M:%S,%3N') $(tput bold)$(tput setaf 4)INFO$(tput sgr0) Installing Commitzen..."
    npm install -g commitizen
fi
echo "$(date '+%Y-%m-%d %H:%M:%S,%3N') $(tput bold)$(tput setaf 4)INFO$(tput sgr0) Starting Commitzen..."
commitizen init cz-conventional-changelog --save-dev --save-exact &> '/dev/null'

# Run npm install
npm install

chmod -R +x ./.husky
chmod -R +x ./node_modules/.bin/cz

CONTAINER_BASENAME="services-custom-fields"
RUNNING_CONTAINER=$(docker ps --filter name=${CONTAINER_BASENAME} -q)

if [[ -n $RUNNING_CONTAINER ]]; then
    echo "$(date '+%Y-%m-%d %H:%M:%S,%3N') $(tput bold)$(tput setaf 3)WARNING$(tput sgr0) Containers already running."
    for c in $RUNNING_CONTAINER; do
        docker stop "$c" && docker rm "$c"
    done
    echo "$(date '+%Y-%m-%d %H:%M:%S,%3N') $(tput bold)$(tput setaf 4)INFO$(tput sgr0) Applied docker stop command."
fi

# Config development mode (Mezzio framework)
cp ./config/development.config.php.dist ./config/development.config.php
cp ./config/autoload/development.local.php.dist ./config/autoload/development.local.php
cp ./config/autoload/local.php.dist ./config/autoload/local.php
cp ./config/autoload/routes.local.php.dist ./config/autoload/routes.local.php
echo "$(date '+%Y-%m-%d %H:%M:%S,%3N') $(tput bold)$(tput setaf 4)INFO$(tput sgr0) Configured development mode."

# Setup bin (folder permission)
chmod -R +x ./bin
echo "$(date '+%Y-%m-%d %H:%M:%S,%3N') $(tput bold)$(tput setaf 4)INFO$(tput sgr0) Changed ./bin folder permission."

# Setup cache (Clear and folder permission)
rm -Rf ./cache
mkdir -m 777 ./cache
echo "$(date '+%Y-%m-%d %H:%M:%S,%3N') $(tput bold)$(tput setaf 4)INFO$(tput sgr0) Cache cleared."

# Setup environment (Folder permission)
chmod -R 777 ./environment
echo "$(date '+%Y-%m-%d %H:%M:%S,%3N') $(tput bold)$(tput setaf 4)INFO$(tput sgr0) Changed ./environment folder permission."

# Setup logs (Clear and folder permission)
rm -Rf ./log
mkdir -m 777 ./log

rm -Rf ./environment/nginx/log
mkdir -m 777 ./environment/nginx/log

rm -Rf ./environment/php/log
mkdir -m 777 ./environment/php/log
mkdir -m 777 ./environment/php/log/php
mkdir -m 777 ./environment/php/log/supervisor
echo "$(date '+%Y-%m-%d %H:%M:%S,%3N') $(tput bold)$(tput setaf 4)INFO$(tput sgr0) Cleaned logs."

# Setup .env
ln -sf environment/development.env .env
echo "$(date '+%Y-%m-%d %H:%M:%S,%3N') $(tput bold)$(tput setaf 4)INFO$(tput sgr0) Environment settings file generated."

# Docker up
echo "$(date '+%Y-%m-%d %H:%M:%S,%3N') $(tput bold)$(tput setaf 4)INFO$(tput sgr0) Loading environment."
docker compose up --build

# Docker down
echo ""
echo "$(date '+%Y-%m-%d %H:%M:%S,%3N') $(tput setaf 2)That's all, folks...$(tput sgr0)"
echo "$(date '+%Y-%m-%d %H:%M:%S,%3N') $(tput setaf 2)Goodbye!$(tput sgr0)"
echo "$(date '+%Y-%m-%d %H:%M:%S,%3N') $(tput bold)$(tput setaf 2);)$(tput sgr0)"
echo ""
