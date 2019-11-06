INCLUDES_DIR=./makefile.d
include $(INCLUDES_DIR)/base.mk

install-project:
	$(PHP_EXEC) sh -c "composer install"

php:
	$(PHP_EXEC) sh

test-behat:
	$(PHP_EXEC) sh -c "vendor/bin/behat"

test-phan:
	$(PHP_EXEC) sh -c "vendor/bin/phan"
