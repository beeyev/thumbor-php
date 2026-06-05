# Alexander Tebiev - https://github.com/beeyev

.PHONY: *
.DEFAULT_GOAL := help

help: ## Show this help
	@printf "\n\033[37m%s\033[0m\n" 'Usage: make [target]'
	@printf "\033[33m%s:\033[0m\n" 'Available commands'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  \033[32m%-14s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

stan: ## Execute PHPStan
	php vendor/bin/phpstan analyse --configuration=phpstan.neon.dist --memory-limit=1G

cs: ## Execute PHP CS Fixer
	php vendor/bin/php-cs-fixer fix --diff --verbose --using-cache=yes --cache-file=.php-cs-fixer.cache

test: ## Execute PHPUnit
	vendor/bin/phpunit --testdox

rector: ## Execute Rector PHP
	vendor/bin/rector process
