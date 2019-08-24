up: docker-up

stop: docker-stop

down: docker-down

init: api-env docker-clear docker-up api-composer api-genrsa api-migration api-docs api-test-keys api-test

docker-clear:
	docker-compose down --remove-orphans
	sudo rm -rf var/docker

docker-up:
	docker-compose up --build -d

docker-stop:
	docker-compose stop

docker-down:
	docker-compose down

pause:
	sleep 5

api-env:
	rm -f .env
	ln -sr .env.dist .env

api-composer:
	docker-compose exec api-php-fpm composer install

api-genrsa:
	docker-compose exec api-php-fpm openssl genrsa -out private.key 2048
	docker-compose exec api-php-fpm openssl rsa -in private.key -pubout -out public.key

api-migration:
	docker-compose exec api-php-fpm composer app migrations:migrate

api-fixtures:
	docker-compose exec api-php-fpm composer app fixtures:load

api-test-keys:
	rm -f tests/data/private.key
	rm -f tests/data/public.key
	ln -sr private.key tests/data/private.key
	ln -sr public.key tests/data/public.key

api-test:
	docker-compose exec api-php-fpm composer test

api-docs:
	docker-compose exec api-php-fpm composer docs
