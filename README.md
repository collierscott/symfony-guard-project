Symfony 3 using guard authentication

To get running after downloading repo:
- composer install
- npm install
- bower install
- gulp

php bin/console doctrine:schema:drop --force
php bin/console doctrine:schema:create
php bin/console doctrine:fixtures:load