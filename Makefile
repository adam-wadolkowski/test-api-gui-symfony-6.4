shell = @docker exec -it blog_php
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

init: #initialize project
	@docker-compose up -d
	$(shell) composer install
	$(chown)
	$(console) doctrine:database:drop --force
	$(console) doctrine:database:create
	$(console) doctrine:migrations:migrate
	@docker-compose ps -a

fixture: #load only fixture
	@docker-compose up -d
	$(chown)
	$(console) doctrine:fixtures:load

shell: #run shell in code container
	@docker-compose up -d
	$(shell) bash

status: #show status projects containers
	@docker-compose ps -a

status-all: #show status all containers
	@docker ps -a

up: #up all project containers
	@docker-compose up -d
	@docker-compose ps -a

down: #down all project containers
	@docker-compose down
	@docker ps -a

down-all: #down all containers in native system
	@docker stop $$(docker ps -a -q)
	@docker rm $$(docker ps -a -q)
	@docker ps -a

permissions: #change permission to edit project code
	$(chown)

clean-cache: #remove file from var/cache/ in project
	@rm -rf app/var/cache/*

cs: #run snifer code
	#@rm .phpcs-cache
	@docker-compose up -d
	$(shell) vendor/bin/phpcs --standard=phpcs.xml

cs-fix: #run fixer snifer code
	@docker-compose up -d
	$(shell) vendor/bin/phpcbf -vv --standard=phpcs.xml
