#!/bin/bash

# Composer update
composer update

# Gera a chave do aplicativo
php artisan key:generate

# Executa as migrações
php artisan migrate --force

# Popula o banco de dados
php artisan db:seed --force

# Inicia o Apache no foreground
apache2-foreground
