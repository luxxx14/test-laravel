# Makefile

.PHONY: up build install migrate seed

# Поднятие контейнеров, установка зависимостей, запуск миграций и сидеров
up: build install migrate seed

# Сборка контейнеров
build:
	docker-compose build

# Установка зависимостей Composer и NPM
install:
	docker-compose run --rm app composer install
	docker-compose run --rm app npm install
	docker-compose run --rm app npm run build

# Применение миграций
migrate:
	docker-compose run --rm app php artisan migrate

# Запуск сидеров
seed:
	docker-compose run --rm app php artisan db:seed

# Для остановки контейнеров
down:
	docker-compose down
