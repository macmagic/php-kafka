.PHONY: install start stop
install:
		docker-compose build; \
		docker-compose up -d; \
		docker-compose exec php-fpm composer install
start:
		docker-compose up -d
stop:
		docker-compose down
bash:
		docker-compose exec php-fpm sh
test-unit:
		docker-compose exec php-fpm vendor/bin/phpunit
test-coverage:
		docker-compose exec php-fpm vendor/bin/phpunit --coverage-html reports/coverage-report
phpstan:
		docker-compose exec php-fpm vendor/bin/phpstan analyse -c phpstan.neon
php-cs-fixer:
		docker-compose exec php-fpm vendor/bin/php-cs-fixer fix --verbose --config=.php_cs --using-cache=no --show-progress=dots
migrations-apply:
		docker-compose exec php-fpm php bin/console doctrine:migrations:migrate -n
messenger-consumer:
		docker-compose exec php-fpm php bin/console messenger:consume