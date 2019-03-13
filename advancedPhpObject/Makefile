.PHONY: run build-dependency

run:
	docker-compose up -d

build-dependency:
	docker exec -it advancedphpobject_web_1 sh -c 'composer install'