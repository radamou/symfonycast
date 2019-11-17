OS := $(shell uname)
CURRENT_DIR=$(patsubst %/,%,$(dir $(realpath $(firstword $(MAKEFILE_LIST)))))
DIR_BASENAME=$(shell basename $(CURRENT_DIR))
DOCKER_COMPOSE=docker-compose
PHP_EXEC=$(DOCKER_COMPOSE) exec php
PHP_EXEC_WWW=$(DOCKER_COMPOSE) exec -u www-data php

help:
	@echo "Please use \`make <target>' where <target> is one of"
	@echo "  all              install project  and all dependencies, execute doctrine migrations"
	@echo "  build            build docker container (remove all containers before rebuild)"
	@echo "  start            start all containers"
	@echo "  install-package  install package"
	@echo "  migration        execute doctrine migration"
	@echo "  cli-root         connect to php container  as root"
	@echo "  kill             kill all containers"
	@echo "  destroy          stop containers and force remove them and all anonymous volume"
	@echo "  clean            clean logs and cache files"
	@echo "  test-behat       to run behat tests"
	@echo "  cs               run cs fixer"
	@echo "  infection        to run infection tests"
	@echo "  test-unit        run unit testing"
