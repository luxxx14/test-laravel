.PHONY: up install migrate seed down

# Поднятие контейнеров, установка зависимостей, запуск миграций и сидеров
up: start install migrate seed

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
	docker-compose exec app php artisan migrate

# Запуск сидеров
seed:
	docker-compose exec app php artisan db:seed

# Для остановки контейнеров
down:
	docker-compose down
