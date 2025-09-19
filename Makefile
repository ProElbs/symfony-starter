PHP_SERVICE := php
NODEJS_SERVICE := nodejs
DB_SERVICE := db
PROJECT_NAME := symfony-starter

# Utiliser docker compose (v2)
COMPOSE := docker compose
COMPOSE_FILE_DEV := docker-compose.dev.yml
COMPOSE_FILE_PROD := docker-compose.prod.yml

##########
# DOCKER #
##########
build:
	@$(COMPOSE) -f $(COMPOSE_FILE_DEV) build
	@$(COMPOSE) -f $(COMPOSE_FILE_DEV) up -d
build-prod:
	@$(COMPOSE) -f $(COMPOSE_FILE_PROD) build
	@$(COMPOSE) -f $(COMPOSE_FILE_PROD) up -d
start:
	@$(COMPOSE) -f $(COMPOSE_FILE_DEV) up -d
start-prod:
	@$(COMPOSE) -f $(COMPOSE_FILE_PROD) up -d
stop:
	@$(COMPOSE) -f $(COMPOSE_FILE_DEV) stop
restart:
	@$(COMPOSE) -f $(COMPOSE_FILE_DEV) stop
	@$(COMPOSE) -f $(COMPOSE_FILE_DEV) up -d
bash:
	@$(COMPOSE) -f $(COMPOSE_FILE_DEV) exec $(PHP_SERVICE) sh

############
# COMPOSER #
############
composer-install:
	@$(COMPOSE) -f $(COMPOSE_FILE_DEV) exec -T $(PHP_SERVICE) composer install
composer-install-prod:
	@$(COMPOSE) -f $(COMPOSE_FILE_PROD) exec -T $(PHP_SERVICE) composer install --no-dev --optimize-autoloader
composer-require:
	@$(COMPOSE) -f $(COMPOSE_FILE_DEV) exec -T $(PHP_SERVICE) composer require $(COMMAND_ARGS)
composer-remove:
	@$(COMPOSE) -f $(COMPOSE_FILE_DEV) exec -T $(PHP_SERVICE) composer remove $(COMMAND_ARGS)

############
# DATABASE #
############
install-db:
	@$(COMPOSE) -f $(COMPOSE_FILE_DEV) exec -T $(PHP_SERVICE) bin/console doctrine:database:drop --force || true
	@$(COMPOSE) -f $(COMPOSE_FILE_DEV) exec -T $(PHP_SERVICE) bin/console doctrine:database:create
	@$(COMPOSE) -f $(COMPOSE_FILE_DEV) exec -T $(PHP_SERVICE) bin/console doctrine:migrations:migrate -n

migrations-diff:
	@$(COMPOSE) -f $(COMPOSE_FILE_DEV) exec -T $(PHP_SERVICE) bin/console doctrine:migrations:diff

migrations-migrate:
	@$(COMPOSE) -f $(COMPOSE_FILE_DEV) exec -T $(PHP_SERVICE) bin/console doctrine:migrations:migrate -n

#########
# TOOLS #
#########
phpstan:
	@$(COMPOSE) -f $(COMPOSE_FILE_DEV) exec -T $(PHP_SERVICE) vendor/bin/phpstan analyse -l 8 src --memory-limit=4G

php-cs-fixer:
	@$(COMPOSE) -f $(COMPOSE_FILE_DEV) exec -T $(PHP_SERVICE) vendor/bin/php-cs-fixer fix -v --dry-run

php-cs-fixer-fix:
	@$(COMPOSE) -f $(COMPOSE_FILE_DEV) exec -T $(PHP_SERVICE) vendor/bin/php-cs-fixer fix -v

###########
# SYMFONY #
###########
cache-clear:
	@$(COMPOSE) -f $(COMPOSE_FILE_DEV) exec -T $(PHP_SERVICE) bin/console cache:clear

#########
# TESTS #
#########
phpunit:
	@$(COMPOSE) -f $(COMPOSE_FILE_DEV) exec -T $(PHP_SERVICE) vendor/bin/phpunit

########################################################
#                        NPM                           #
# Beta, first install Webpack to use npm with symfony  #
########################################################
npm-install:
	@$(COMPOSE) -f $(COMPOSE_FILE_DEV) run --rm $(NODEJS_SERVICE) npm install

npm-add:
	@$(COMPOSE) -f $(COMPOSE_FILE_DEV) run --rm $(NODEJS_SERVICE) npm install -D $(COMMAND_ARGS)

npm-dev:
	@$(COMPOSE) -f $(COMPOSE_FILE_DEV) run --rm $(NODEJS_SERVICE) npm run dev

npm-build:
	@$(COMPOSE) -f $(COMPOSE_FILE_DEV) run --rm $(NODEJS_SERVICE) npm run build

###########
# GLOBALS #
###########
install: build composer-install install-db cache-clear

