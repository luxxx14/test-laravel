.PHONY: up install migrate seed swagger down

ifeq (,$(wildcard web_app/.env))
  $(error .env file not found)
endif

include web_app/.env

up: start install migrate

start:
	docker-compose up -d

install:
	docker-compose exec app composer install

migrate:
	docker-compose exec db sh -c "\
	until mysql -h db -u $(DB_USERNAME) -p$(DB_PASSWORD) -e 'SELECT 1' > /dev/null 2>&1; do \
	  echo 'Waiting for MySQL...'; sleep 2; \
	done"
	docker-compose exec app php artisan config:clear && \
	docker-compose exec app php artisan cache:clear && \
	docker-compose exec app php artisan migrate

seed:
	docker-compose exec app php artisan db:seed

down:
	docker-compose down

swagger:
	docker-compose exec app php artisan l5-swagger:generate
