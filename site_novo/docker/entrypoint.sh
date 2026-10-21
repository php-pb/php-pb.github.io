#!/bin/sh
set -e

# Os volumes nomeados do docker-compose (laravel-storage, laravel-cache) sao
# montados por cima de storage/ e bootstrap/cache/ depois do build da imagem,
# entao o dono/permissao definidos no Dockerfile nao valem para eles. Sem
# isso, o PHP-FPM (rodando como www-data) nao consegue criar diretorios aqui
# dentro (ex: upload de imagem de evento no Filament).
chown -R laravel:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

exec "$@"
