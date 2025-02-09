PHP_SERVICE := php
NODEJS_SERVICE := nodejs
DB_SERVICE := dbstarter
PROJECT_NAME := symfony-starter

##########
# DOCKER #
##########
build:
	@docker-compose build
	@docker-compose up -d
build-prod:
	@docker-compose build
	@docker-compose -f docker-compose.prod.yml up -d
start:
	@docker-compose up -d
start-prod:
	@docker-compose -f docker-compose.prod.yml up -d
stop:
	@docker-compose stop
restart:
	@docker-compose stop
	@docker-compose up -d
bash:
	docker exec -it $(PROJECT_NAME)-$(PHP_SERVICE)-1 bash

############
# COMPOSER #
############
composer-install:
	@docker-compose exec -T $(PHP_SERVICE) composer install
composer-install-prod:
	@docker-compose exec -T $(PHP_SERVICE) composer install --no-dev --optimize-autoloader
composer-require:
	@docker-compose exec -T $(PHP_SERVICE) composer require $(COMMAND_ARGS)
composer-remove:
	@docker-compose exec -T $(PHP_SERVICE) composer remove $(COMMAND_ARGS)

############
# DATABASE #
############
install-db:
	@docker-compose exec -T $(PHP_SERVICE) bin/console doctrine:database:drop --force
	@docker-compose exec -T $(PHP_SERVICE) bin/console doctrine:database:create
	@docker-compose exec -T $(PHP_SERVICE) bin/console doctrine:migrations:migrate

migrations-diff:
	@docker-compose exec -T $(PHP_SERVICE) bin/console doctrine:migrations:diff

migrations-migrate:
	@docker-compose exec -T $(PHP_SERVICE) bin/console doctrine:migrations:migrate

#########
# TOOLS #
#########
phpstan:
	@docker-compose exec -T $(PHP_SERVICE) vendor/bin/phpstan analyse -l 8 src --memory-limit=4G

php-cs-fixer:
	@docker-compose exec -T $(PHP_SERVICE) vendor/bin/php-cs-fixer fix -v --dry-run

php-cs-fixer-fix:
	@docker-compose exec -T $(PHP_SERVICE) vendor/bin/php-cs-fixer fix -v

###########
# SYMFONY #
###########
cache-clear:
	@docker-compose exec -T $(PHP_SERVICE) bin/console cache:clear

#########
# TESTS #
#########
phpunit:
	@docker-compose exec -T $(PHP_SERVICE) vendor/bin/phpunit

#######
# NPM #
#######
npm-install:
	@docker-compose run --rm $(NODEJS_SERVICE) npm install

# Change "tailwindcss..." to what you want to install
# or directly run : docker-compose run --rm nodejs XXXX
npm-add:
	@docker-compose run --rm $(NODEJS_SERVICE) npm install -D tailwindcss postcss autoprefixer

# Checkout the package.json vite target dev has been changed from "vite" to "vite build --watch"
npm-dev:
	@docker-compose run --rm $(NODEJS_SERVICE) npm run dev

npm-build:
	@docker-compose run --rm $(NODEJS_SERVICE) npm run build

###########
# GLOBALS #
###########
install: build composer-install install-db cache-clear

