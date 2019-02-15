up: docker-up

init: api-env docker-clear docker-up api-composer api-genrsa pause api-test

docker-clear:
	docker-compose down --remove-orphans
	sudo rm -rf var/docker

docker-up:
	docker-compose up --build -d

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

api-test:
	docker-compose exec api-php-fpm composer test