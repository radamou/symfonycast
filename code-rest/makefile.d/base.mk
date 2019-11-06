OS := $(shell uname)
CURRENT_DIR=$(patsubst %/,%,$(dir $(realpath $(firstword $(MAKEFILE_LIST)))))
DIR_BASENAME=$(shell basename $(CURRENT_DIR))
PHP_EXEC=docker-compose exec php

help:
	@echo "Please use \`make <target>' where <target> is one of"
	@echo "  pre-configure    to check project requirements (docker, docker-compose, id_rsa file ...)"
	@echo "  unconfigure      to reset project environment"
	@echo "  build            to build the docker stack"
	@echo "  update           to update dependencies"
	@echo "  run              to start all docker containers"
	@echo "  restart          to restart all docker containers"
	@echo "  fix-cs           to fix coding style"
	@echo "  deploy-prod      to deploy a new version to production"
	@echo "  helpme           to generate a log file, helping you debugging your stack"
