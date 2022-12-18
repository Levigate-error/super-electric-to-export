SHELL=/bin/bash -e

.DEFAULT_GOAL := help

help: ## This help
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

ifeq ($(test -f ./.env) && echo '1',1)
include .env
endif

mkfile_path := $(abspath $(lastword $(MAKEFILE_LIST)))
BASE_NAME_DIR := $(notdir $(patsubst %/,%,$(dir $(mkfile_path))))
BAMBOO_NAME_SERVICE := $(bamboo_buildKey)_$(bamboo_buildNumber)
NAME_SERVICE_IN_ENV_FILE := $(grep BASE_NAME_SERVICE .env | cut -d '=' -f2)

ifneq ("$(BAMBOO_NAME_SERVICE)","_")
BASE_NAME_SERVICE := $(BAMBOO_NAME_SERVICE)
endif

ifeq ($(BASE_NAME_SERVICE),)
BASE_NAME_SERVICE := $(BASE_NAME_DIR)
endif

export BASE_NAME_SERVICE

build: ## Билд проекта
	@docker-compose -f docker-compose.local.yml build --build-arg user_uid=$$(id -u) db
	@docker-compose -f docker-compose.local.yml build --build-arg user_uid=$$(id -u) redis
	@docker-compose -f docker-compose.local.yml build --build-arg user_uid=$$(id -u) app
	@docker-compose -f docker-compose.local.yml build --build-arg user_uid=$$(id -u) web

first-run: env build up-local prepare-app  ##Самый первый запуск!!!! Если что-то уже было 
	
prepare-app: composer-install key-generate npm-build storage-prepare admin-prepare db-fresh ## Первый запуск storage-prepare public-prepare admin-prepare ssr-prepare db-fresh
	@echo -e "Make: App is completed. \n"

up: ## Запуск проекта в Bamboo
	@docker-compose up -d --remove-orphans
up-local: ## Запуск проекта локально
	@docker-compose -f docker-compose.local.yml up -d  --remove-orphans
down: ## Остановка проекта
	@docker-compose down

restart: down up

bash: ## Доступ к консоли веба
	@docker-compose exec -T app bash

db-migrate: ## Миграции
	@docker-compose exec -T app sudo -u www-data php artisan migrate --force

db-seed: ## Сидеры
	@docker-compose exec -T app sudo -u www-data php artisan db:seed --force

db-fresh: ## Пересборка БД + сидеры
	@docker-compose exec -T app sudo -u www-data php artisan migrate:fresh --seed --force

queue-run: ## Запуск демона очередей
	@docker-compose exec -T app sudo -u www-data php artisan queue:work

composer-install: ## Установка composer
	@docker-compose exec -T app sudo -u www-data composer install -d /var/www/html

apidoc: ## Создание документации
	@docker-compose exec -T app sudo -u www-data apidoc -i app/Http/Controllers/Api -o public/doc

key-generate: ## Генерирование ключа приложения
	@docker-compose exec -T app sudo -u www-data php artisan key:generate

npm-install: ## Установка npm зависимостей
	@docker-compose exec -T app chown -R www-data:www-data /var/www/
	@docker-compose exec -T app npm i npm@latest -g
npm-build: npm-install ## Установка npm зависимотей + сборка фронта
	@docker-compose exec -T app sudo -u www-data npm run dev

env: ## Копирование файла с настройками окружения
	cp .env.example.docker .env

storage-prepare: ## Подготовка storage
	@docker-compose exec -T app sudo -u www-data chmod a+rw storage -R
	@docker-compose exec -T app sudo -u www-data php artisan storage:link

admin-prepare: ## Подготовка админки
	@docker-compose exec -T app sudo -u www-data php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"

ssr-prepare: ## Подготовка SSR
	@docker-compose exec -T app sudo -u www-data mkdir storage/app/ssr
	@docker-compose exec -T app sudo -u www-data chmod 777 -R storage/app/ssr

public-prepare: ## Подготовка public
	@docker-compose exec -T app sudo -u www-data mkdir public/projects-temp
	@docker-compose exec -T app sudo -u www-data chmod 777 -R public/projects-temp

optimize: ## Очистка кэша, роутов, вьюшек и т.д.
	@docker-compose exec -T app sudo -u www-data php artisan optimize:clear

test: ## Запуск тестов
	@docker-compose exec -T app sudo -u www-data vendor/bin/phpunit --testdox -v --log-junit tests/logs/logfile.xml ${args}

default: help
