PHP_BIN ?= docker-compose exec php php
DEP_BIN ?= bin/dep.sh

.PHONY: setup
setup:
	cp .env.example .env
	docker-compose up -d
	docker-compose exec php composer update
#   docker-compose exec php composer run-script setup
	docker-compose exec php php artisan ide-helper:generate
	docker-compose exec php php artisan ide-helper:meta
	docker-compose exec node npm install gulp@3.x laravel-elixir
	docker-compose exec node bower install --allow-root
	docker-compose exec php php artisan key:generate
	docker-compose exec php php artisan migrate
	docker-compose exec php chmod -R 777 storage
	docker-compose exec node gulp	

.PHONY: dbtest
dbtest:
	@docker-compose exec phptest php artisan migrate
	@docker-compose exec phptest php artisan migrate:views

vendor: composer.json composer.lock
	@docker-compose exec php composer install

assets-vendor: bower.json .bowerrc
	@docker-compose exec node bower install --allow-root

.PHONY: assets
assets: assets-vendor
	@docker-compose exec node gulp

.PHONY: watch
watch: assets-vendor
	@docker-compose exec node npm run dev

.PHONY: tests
unit: vendor
	@$(PHP_BIN) vendor/bin/phpunit --testsuite Unit

.PHONY: integration
integration: vendor
	@$(PHP_BIN) vendor/bin/phpunit --testsuite Integration

.PHONY: feature
feature: vendor
	@$(PHP_BIN)	vendor/bin/phpunit --testsuite Feature

tests: vendor
	@$(PHP_BIN)	vendor/bin/phpunit

.PHONY: e2e
e2e:
	npm run cy:dry-run

.PHONY: build
build:
	@bin/build.sh

.PHONY: deploy
deploy: dbtest tests deployer
	bin/build.sh
	bin/dep.sh deploy

.PHONY: deployer
deployer:
	docker build -t deployer -f docker/deployer/Dockerfile .
