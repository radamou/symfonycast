INCLUDES_DIR=./makefile.d
include $(INCLUDES_DIR)/base.mk

.PHONY: install-project cli test-behat clean vendor cs start migration kill

install-project:
	$(PHP_EXEC) sh -c "composer install"

cli:
	$(PHP_EXEC) bash

migration:
	#$(PHP_EXEC) sh -c "php bin/console doctrine:database:create"
	$(PHP_EXEC) sh -c "php bin/console doctrine:migrations:migrate"
	$(PHP_EXEC) sh -c "php bin/console doctrine:fixtures:load"

build-up:
	$(DOCKER_COMPOSE) up -d --build

start:
	$(DOCKER_COMPOSE) up -d

kill:
	$(DOCKER_COMPOSE) kill

destroy:
	$(DOCKER_COMPOSE) rm -f

test-behat:
	$(PHP_EXEC) sh -c "vendor/bin/behat"

clean:
	rm -rf $(CURRENT_DIR)/start/var/cache/* || true
	rm -rf $(CURRENT_DIR)/start/var/logs/* || true

coverage: vendor
	$(PHP_EXEC) sh -c "vendor/bin/phpunit --coverage-text"

cs: vendor
	$(PHP_EXEC) sh -c "php-cs-fixer fix --config=.php_cs --allow-risky=yes --diff --verbose"

infection: vendor
	$(PHP_EXEC) sh -c "vendor/bin/infection --min-covered-msi=80 --min-msi=80"

test: vendor
	$(PHP_EXEC) sh -c "vendor/bin/phpunit"

vendor:
	$(PHP_EXEC) sh -c "composer self-update"
	$(PHP_EXEC) sh -c "composer update"
	$(PHP_EXEC) sh -c "composer validate"
	$(PHP_EXEC) sh -c "composer install"
