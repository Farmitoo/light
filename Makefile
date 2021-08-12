server:
	symfony server:start

test:
	./vendor/bin/phpunit -c phpunit.xml.dist tests

fixer:
	./vendor/bin/php-cs-fixer fix --allow-risky=yes

assets-watch:
	yarn run watch

assets-build:
	yarn run build
