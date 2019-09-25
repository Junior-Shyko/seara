PHP_BIN ?= docker-compose exec php php

.PHONY: setup
setup:
	@cp .env.dist .env
	@docker-compose up -d
	@docker-compose exec php composer install
	@docker-compose exec php php artisan ide-helper:generate
	@docker-compose exec php php artisan ide-helper:meta
	@docker-compose exec node npm install gulp@3.x laravel-elixir
	@docker-compose exec node bower install --allow-root
	@docker-compose exec php php artisan key:generate
	@docker-compose exec php php artisan migrate
	@docker-compose exec node gulp
	@docker-compose exec php chmod -R 777 storage

vendor: composer.json composer.lock
	@docker-compose exec php composer install

.PHONY: assets
assets:
	@docker-compose exec node npm run dev

.PHONY: tests
tests: 	vendor
	@$(PHP_BIN) vendor/bin/phpunit --testsuite Unit
