.PHONY: all

all: run build-dependency

run:
	docker-compose up -d

build-dependency:
	docker exec -it advancedphpobject_web_1 sh -c 'composer install'

test-quality:
	docker exec -it advancedphpobject_web_1 sh -c 'vendor/bin/phpstan analyse --level max src tests'

clean:
	rm -rf start/var/cache/*
