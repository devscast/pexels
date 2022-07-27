.PHONY: help
help: ## affiche cet aide
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: lint
lint: vendor/autoload.php ## affiche les erreurs de formatage de code
	php vendor/bin/phpcs -s
	php vendor/bin/ecs check
	php vendor/bin/phpstan

vendor/autoload.php: composer.lock # installe les dépendances PHP
	composer update
	composer dump-autoload
