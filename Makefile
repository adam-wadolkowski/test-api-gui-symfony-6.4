console = @docker exec -it php bin/console

help: #show list command in make
	@grep '^[^#[:space:]].*:' $(MAKEFILE_LIST)

setup: #for develop - create migrations and load fixtures
	@docker-compose up -d
	$(console) doctrine:database:drop --force
	$(console) doctrine:database:create
	$(console) make:migration
	$(console) doctrine:migrations:migrate
	$(console) doctrine:fixtures:load

init: # initialize project
	@docker-compose up -d
	$(console) doctrine:database:drop --force
	$(console) doctrine:database:create
	$(console) doctrine:migrations:migrate

fixture: # load only fixture
	@docker-compose up -d
	$(console) doctrine:fixtures:load

shell: # run shell in code container
	@docker-compose up -d
	@docker exec -it php bash
