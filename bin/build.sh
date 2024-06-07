#!/bin/bash

# This script is responsible for making plugin archive file to be installed in the WordPress site.

# 1 - Create temp-plugin directory and copy plugin files
mkdir -p ./temp-plugin

# 2 - Copying necessary files to temp-plugin directory
cp ./.babelrc ./temp-plugin/.babelrc
cp ./ai-smart-suggestions.php ./temp-plugin/ai-smart-suggestions.php
cp ./composer.json ./temp-plugin/composer.json
cp ./composer.lock ./temp-plugin/composer.lock
cp ./LICENSE ./temp-plugin/LICENSE
cp ./package.json ./temp-plugin/package.json
cp ./package-lock.json ./temp-plugin/package-lock.json
cp ./webpack.config.js ./temp-plugin/webpack.config.js

# 3 - Copying necessary directories to temp-plugin directory
mkdir -p ./temp-plugin/block-editor/ && cp -R ./block-editor/* ./temp-plugin/block-editor/
mkdir -p ./temp-plugin/src/ && cp -R ./src/* ./temp-plugin/src/

# 4 - install required composer dependencies
docker run --rm -v "$(pwd)/temp-plugin:/app" composer install --no-dev --optimize-autoloader
docker run --rm -v "$(pwd)/temp-plugin:/app" composer dump-autoload -o

# 5 - install required npm dependencies
docker run --rm -v "$(pwd)/temp-plugin:/app" -w /app node:18.12.0 npm install
docker run --rm -v "$(pwd)/temp-plugin:/app" -w /app node:18.12.0 npm run build

# 6 - Cleanup
rm -rf ./temp-plugin/.babelrc
rm -rf ./temp-plugin/composer.json
rm -rf ./temp-plugin/composer.lock
rm -rf ./temp-plugin/package.json
rm -rf ./temp-plugin/package-lock.json
rm -rf ./temp-plugin/webpack.config.js
rm -rf ./temp-plugin/node_modules
rm -rf ./temp-plugin/block-editor

# 7 - Zip the temp-plugin directory
cd ./temp-plugin && zip -r ../ai-smart-suggestions.zip ./*

# 8 - clean up
cd ../ && rm -rf ./temp-plugin
