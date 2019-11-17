.PHONY: vendor

vendor:
	$(PHP_EXEC_WWW) sh -c "composer self-update"
	$(PHP_EXEC_WWW) sh -c "composer update"
	$(PHP_EXEC_WWW) sh -c "composer validate"