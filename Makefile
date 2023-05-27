.PHONY: *
.DEFAULT_GOAL := help

help: ## Show this help
	@printf "\n\033[37m%s\033[0m\n" 'Usage: make [target]'
	@printf "\033[33m%s:\033[0m\n" 'Available commands'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  \033[32m%-14s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

stan: ## Execute PHPStan (PHP 7.2 Required)
	php phpstan-v1.10.phar analyse --configuration=phpstan.neon.dist --memory-limit=1G

cs: ## Execute PHP CS Fixer (PHP 7.2 Required)
	php php-cs-fixer-v2.19.phar fix --diff --verbose --using-cache=yes --cache-file=.php-cs-fixer.cache

test: ## Execute PHPUnit
	phpunit --testdox

rector: ## Execute Rector PHP
	rector process
