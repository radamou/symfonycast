INCLUDES_DIR=./makefile.d
include $(INCLUDES_DIR)/base.mk

.PHONY: install-project php test-behat clean vendor cs start

install-project:
	$(PHP_EXEC) sh -c "composer install"

php:
	$(PHP_EXEC) bash

start:
	$(DOCKER_COMPOSE) up -d

build-up:
	$(DOCKER_COMPOSE) up -d --build

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
