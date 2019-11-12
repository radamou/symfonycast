OS := $(shell uname)
CURRENT_DIR=$(patsubst %/,%,$(dir $(realpath $(firstword $(MAKEFILE_LIST)))))
DIR_BASENAME=$(shell basename $(CURRENT_DIR))
DOCKER_COMPOSE=docker-compose
PHP_EXEC=$(DOCKER_COMPOSE) exec php

help:
	@echo "Please use \`make <target>' where <target> is one of"
	@echo "  install-project  install project dependency"
	@echo "  php              connect to php container"
	@echo "  run-behat        to run behat tests"
	@echo "  clean            to clean cache and logs files"
