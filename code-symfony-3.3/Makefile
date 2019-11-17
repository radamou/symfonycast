INCLUDES_DIR=./makefile.d
include $(INCLUDES_DIR)/*.mk

.PHONY: all build start install-package migration cli-root cli-www ps test-behat cs clean start kill

#==================================================Install project======================================================
all: build start install-package migration

#remove intermediate containers and build without cache
build:
	$(DOCKER_COMPOSE) build --force-rm  --no-cache

start:
	$(DOCKER_COMPOSE) up -d

install-package: vendor
	$(PHP_EXEC_WWW) sh -c "composer install"

migration:
	#$(PHP_EXEC) sh -c "php bin/console doctrine:database:create"
	$(PHP_EXEC_WWW) sh -c "php bin/console doctrine:migrations:migrate"
	$(PHP_EXEC_WWW) sh -c "php bin/console doctrine:fixtures:load"

#=========================================================Utils=========================================================
cli-root:
	$(PHP_EXEC) bash
cli-www:
	$(PHP_EXEC_WWW) bash
ps:
	$(DOCKER_COMPOSE) ps
#================================================Kill/destroy/clean=====================================================

kill:
	$(DOCKER_COMPOSE) kill

#stop containers and force remove them and all anonymous volumes
destroy:
	$(DOCKER_COMPOSE) rm -fsv

clean:
	rm -rf $(CURRENT_DIR)/start/var/cache/* || true
	rm -rf $(CURRENT_DIR)/start/var/logs/* || true

#===================================================Project testing=====================================================
test-behat:
	$(PHP_EXEC) sh -c "vendor/bin/behat"

coverage: vendor
	$(PHP_EXEC) sh -c "vendor/bin/phpunit --coverage-text"

cs: vendor
	$(PHP_EXEC_WWW) sh -c "php-cs-fixer fix --config=.php_cs --allow-risky=yes --diff --verbose"

infection: vendor
	$(PHP_EXEC_WWW) sh -c "vendor/bin/infection --min-covered-msi=80 --min-msi=80"

test-unit: vendor
	$(PHP_EXEC_WWW) sh -c "vendor/bin/phpunit"


