.PHONY: all

all: run build-dependency

run:
	docker-compose up -d


down:
	docker-compose down

dcexapp:
	docker-compose exec web bash
ps:
	docker-compose ps

build-dependency:
	docker exec -it advancedphpobject_web_1 sh -c 'composer install'

test-quality:
	docker exec -it advancedphpobject_web_1 sh -c 'vendor/bin/phpstan analyse --level max src tests'

clean:
	rm -rf start/var/cache/*
