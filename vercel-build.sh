#!/bin/bash

# Instalar dependencias de Composer
composer install

# Ejecutar migraciones (si es necesario)
php artisan migrate
