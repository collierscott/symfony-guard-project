Symfony 3 using guard authentication
====================================

A basic implementation of form, Facebook, and API authentication in Symfony3 using Guard.

**If you are new to Symfony or just want some awesome training, checkout [KNP University](http://www.knpuniversity.com). It is well worth the time and money. And, they are super knowledgeable and helpful.**

To get running after downloading repo:
--------------------------------------

* composer install
* npm install
* bower install
* gulp


php bin/console doctrine:schema:drop --force

php bin/console doctrine:schema:create

php bin/console doctrine:fixtures:load


Test
----
php bin/console doctrine:database:create --env=test

php bin/console doctrine:schema:drop --force --env=test

php bin/console doctrine:schema:create --env=test

php bin/console doctrine:fixtures:load --env=test
