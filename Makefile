shell = @docker exec -it php
console = @$(shell) bin/console
chown = @sudo chown -R $$USER:$$USER app/

help: #show list command in make
	@grep '^[^#[:space:]].*:' $(MAKEFILE_LIST)

setup: #for develop - create migrations and load fixtures
	@docker-compose up -d
	$(chown)
	$(console) doctrine:database:drop --force
	$(console) doctrine:database:create
	$(console) make:migration
	$(console) doctrine:migrations:migrate
	$(console) doctrine:fixtures:load

init: # initialize project
	@docker-compose up -d
	$(shell) composer install
	$(chown)
	$(console) doctrine:database:drop --force
	$(console) doctrine:database:create
	$(console) doctrine:migrations:migrate
	@docker-compose ps -a

fixture: # load only fixture
	@docker-compose up -d
	$(chown)
	$(console) doctrine:fixtures:load

shell: # run shell in code container
	@docker-compose up -d
	@docker exec -it php bash

status:
	@docker ps -a

up:
	@docker-compose up -d
	@docker-compose ps -a

down:
	@docker-compose down
	@docker ps -a

down-all:
	@docker stop $$(docker ps -a -q)
	@docker rm $$(docker ps -a -q)
	@docker ps -a

permissions:
	$(chown)

clean-cache:
	@rm -rf app/var/cache/*

#clean:
#	@rm -rf app/var/cache/*
#	@rm .phpcs-cache

cs:
	#@rm .phpcs-cache
	@docker-compose up -d
	$(shell) vendor/bin/phpcs -p --standard=phpcs.xml

cs-fix:
	@docker-compose up -d
	$(shell) vendor/bin/phpbf -p --standard=phpcs.xml