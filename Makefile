.PHONY: up install migrate seed down

# Проверяем, что файл .env существует
ifeq (,$(wildcard web_app/.env))
  $(error .env file not found)
endif

# Загружаем переменные из .env
include web_app/.env

# Поднятие контейнеров, установка зависимостей, запуск миграций и сидеров
up: start install migrate

# Запускаем контейнеры
start:
	docker-compose up -d

# Установка зависимостей Composer и NPM
install:
	docker-compose exec app composer install
#	docker-compose exec app npm install
#	docker-compose exec app npm run build

# Применение миграций
migrate:
#	docker-compose exec app php artisan config:clear
#	docker-compose exec app php artisan cache:clear
#	docker-compose exec app php artisan migrate --force
	docker-compose exec db sh -c "\
	until mysql -h db -u $(DB_USERNAME) -p$(DB_PASSWORD) -e 'SELECT 1' > /dev/null 2>&1; do \
	  echo 'Waiting for MySQL...'; sleep 2; \
	done"
	docker-compose exec app php artisan config:clear && \
	docker-compose exec app php artisan cache:clear && \
	docker-compose exec app php artisan migrate

# Запуск сидеров
seed:
	docker-compose exec app php artisan db:seed

# Для остановки контейнеров
down:
	docker-compose down
