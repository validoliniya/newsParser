#!/bin/sh

composer install

php bin/console doctrine:database:create --if-not-exists

php bin/console doctrine:migrations:migrate --no-interaction

php bin/console doctrine:fixtures:load --append

yarn install

yarn encore run dev