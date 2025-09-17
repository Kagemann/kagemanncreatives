# Kagemann Creatives - Makefile
# Production-ready WordPress system automation

.PHONY: help doctor new-client fmt sync-docs install clean

# Default target
help: ## Show this help message
	@echo "Kagemann Creatives - Available Commands:"
	@echo ""
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

# System checks
doctor: ## Check system requirements and dependencies
	@echo "🔍 Running system diagnostics..."
	@./tooling/doctor.sh

# Client management
new-client: ## Create a new client site (usage: make new-client CLIENT=acme)
	@if [ -z "$(CLIENT)" ]; then \
		echo "❌ Error: CLIENT variable is required"; \
		echo "Usage: make new-client CLIENT=acme"; \
		exit 1; \
	fi
	@echo "🚀 Creating new client site: $(CLIENT)"
	@./tooling/new-client.sh $(CLIENT)

# Code formatting
fmt: ## Format all code files
	@echo "🎨 Formatting code..."
	@npm run format

fmt-check: ## Check code formatting without making changes
	@echo "🔍 Checking code formatting..."
	@npm run format:check

# Documentation
sync-docs: ## Sync documentation across projects
	@echo "📚 Syncing documentation..."
	@./tooling/sync-docs.sh

# Installation
install: ## Install dependencies
	@echo "📦 Installing dependencies..."
	@npm install
	@if [ -f "wp-starter/composer.json" ]; then \
		cd wp-starter && composer install; \
	fi

# WordPress specific
wp-init: ## Initialize WordPress starter kit
	@echo "🔧 Initializing WordPress starter kit..."
	@cd wp-starter && make init

wp-build: ## Build WordPress assets
	@echo "🏗️ Building WordPress assets..."
	@cd wp-starter && make build

# Cleanup
clean: ## Clean temporary files and caches
	@echo "🧹 Cleaning temporary files..."
	@find . -name "*.log" -delete
	@find . -name ".DS_Store" -delete
	@find . -name "Thumbs.db" -delete
	@rm -rf node_modules/.cache
	@if [ -d "wp-starter/vendor" ]; then \
		cd wp-starter && composer clear-cache; \
	fi

# Development
dev: ## Start development environment
	@echo "🚀 Starting development environment..."
	@echo "Make sure you have a local WordPress environment running"
	@echo "Then run: make wp-build"

# Production
build: ## Build for production
	@echo "🏗️ Building for production..."
	@make clean
	@make fmt-check
	@make wp-build
	@echo "✅ Production build complete"

# Testing
test: ## Run tests
	@echo "🧪 Running tests..."
	@make doctor
	@make fmt-check
	@echo "✅ All tests passed"

# Deployment
deploy: ## Deploy to production (placeholder)
	@echo "🚀 Deploying to production..."
	@echo "⚠️  Configure your deployment pipeline in .github/workflows/"
	@echo "✅ Deployment complete"

# Show variables
vars: ## Show current variable values
	@echo "📋 Current Variables:"
	@echo "BUREAU_NAME: Kagemann Creatives"
	@echo "BUREAU_DOMAIN: kagemanncreatives.com"
	@echo "DEFAULT_TIMEZONE: Europe/Copenhagen"
	@echo "DEFAULT_HOSTING: Kinsta or WP Engine"
	@echo "CONSENT_TOOL: CookieYes or Cookiebot"
