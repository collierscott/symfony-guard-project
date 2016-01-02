Symfony 3 using guard authentication

To get running after downloading repo:
- composer install
- npm install
- bower install
- gulp


php bin/console doctrine:schema:drop --force
php bin/console doctrine:schema:create
php bin/console doctrine:fixtures:load

#Test
php bin/console doctrine:database:create --env=test
php bin/console doctrine:schema:drop --force --env=test
php bin/console doctrine:schema:create --env=test
php bin/console doctrine:fixtures:load --env=test
