.PHONY: help install new run fix phpstan cs-fix cs-check

# Colors
GREEN  := \033[0;32m
BLUE   := \033[0;34m
YELLOW := \033[0;33m
CYAN   := \033[0;36m
BOLD   := \033[1m
RESET  := \033[0m

# Docker shortcuts
DOCKER_USER := --user $$(id -u):$$(id -g)
DOCKER_VOL  := -v $$(pwd):/app
DOCKER_RUN  := docker run --rm -ti $(DOCKER_USER) $(DOCKER_VOL)
PHP         := $(DOCKER_RUN) php:8.5-cli
COMPOSER    := $(DOCKER_RUN) composer:latest

.DEFAULT_GOAL := help

help: ## 📖 Show this help message
	@echo "$(BOLD)$(CYAN)🎄 Advent of Code - Available Commands$(RESET)\n"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "  $(CYAN)%-12s$(RESET) %s\n", $$1, $$2}'
	@echo ""

install: ## 📦 Install dependencies
	@echo "$(BLUE)📦 Installing dependencies...$(RESET)"
	@$(COMPOSER) install

new: ## 🎄 Create new challenge (year=YYYY day=DD)
	@echo "$(GREEN)🎄 Creating new challenge $(year)/$(day)...$(RESET)"
	@$(PHP) php app/run.php aoc:new $(year) $(day)

run: ## 🚀 Run challenge (year=YYYY day=DD)
	@echo "$(YELLOW)🚀 Running challenge...$(RESET)"
	@$(PHP) php app/run.php aoc:run $(year) $(day)

phpstan: ## 🔍 Run PHPStan static analysis
	@echo "$(BLUE)🔍 Running PHPStan...$(RESET)"
	@$(PHP) php vendor/bin/phpstan analyse

cs-fix: ## 🔧 Fix code style with PHP-CS-Fixer
	@echo "$(BLUE)🔧 Fixing code style...$(RESET)"
	@$(PHP) php vendor/bin/php-cs-fixer fix

cs-check: ## ✅ Check code style with PHP-CS-Fixer (dry-run)
	@echo "$(BLUE)✅ Checking code style...$(RESET)"
	@$(PHP) php vendor/bin/php-cs-fixer fix --dry-run --diff
