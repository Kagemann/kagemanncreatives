#!/bin/bash

# Kagemann Creatives - System Doctor
# Checks system requirements and dependencies

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    local status=$1
    local message=$2
    
    case $status in
        "OK")
            echo -e "${GREEN}✅ $message${NC}"
            ;;
        "WARN")
            echo -e "${YELLOW}⚠️  $message${NC}"
            ;;
        "ERROR")
            echo -e "${RED}❌ $message${NC}"
            ;;
        "INFO")
            echo -e "${BLUE}ℹ️  $message${NC}"
            ;;
    esac
}

echo -e "${BLUE}🔍 Kagemann Creatives - System Doctor${NC}"
echo "================================================"

# Check if running on supported OS
if [[ "$OSTYPE" == "darwin"* ]] || [[ "$OSTYPE" == "linux-gnu"* ]]; then
    print_status "OK" "Operating System: $OSTYPE"
else
    print_status "WARN" "Operating System: $OSTYPE (Windows support is optional)"
fi

# Check Node.js
if command -v node &> /dev/null; then
    NODE_VERSION=$(node --version)
    NODE_MAJOR=$(echo $NODE_VERSION | cut -d'.' -f1 | sed 's/v//')
    if [ "$NODE_MAJOR" -ge 18 ]; then
        print_status "OK" "Node.js: $NODE_VERSION"
    else
        print_status "ERROR" "Node.js: $NODE_VERSION (requires v18+)"
    fi
else
    print_status "ERROR" "Node.js: Not installed"
fi

# Check npm
if command -v npm &> /dev/null; then
    NPM_VERSION=$(npm --version)
    NPM_MAJOR=$(echo $NPM_VERSION | cut -d'.' -f1)
    if [ "$NPM_MAJOR" -ge 8 ]; then
        print_status "OK" "npm: $NPM_VERSION"
    else
        print_status "ERROR" "npm: $NPM_VERSION (requires v8+)"
    fi
else
    print_status "ERROR" "npm: Not installed"
fi

# Check PHP
if command -v php &> /dev/null; then
    PHP_VERSION=$(php --version | head -n1)
    PHP_MAJOR=$(php -r "echo PHP_MAJOR_VERSION;")
    if [ "$PHP_MAJOR" -ge 8 ]; then
        print_status "OK" "PHP: $PHP_VERSION"
    else
        print_status "WARN" "PHP: $PHP_VERSION (WordPress recommends PHP 8.0+)"
    fi
else
    print_status "WARN" "PHP: Not installed (required for WordPress development)"
fi

# Check Composer
if command -v composer &> /dev/null; then
    COMPOSER_VERSION=$(composer --version | head -n1)
    print_status "OK" "Composer: $COMPOSER_VERSION"
else
    print_status "WARN" "Composer: Not installed (required for WordPress dependencies)"
fi

# Check Git
if command -v git &> /dev/null; then
    GIT_VERSION=$(git --version)
    print_status "OK" "Git: $GIT_VERSION"
else
    print_status "ERROR" "Git: Not installed"
fi

# Check Make
if command -v make &> /dev/null; then
    MAKE_VERSION=$(make --version | head -n1)
    print_status "OK" "Make: $MAKE_VERSION"
else
    print_status "WARN" "Make: Not installed (required for automation)"
fi

# Check if we're in a git repository
if [ -d ".git" ]; then
    print_status "OK" "Git repository: Initialized"
else
    print_status "WARN" "Git repository: Not initialized"
fi

# Check if node_modules exists
if [ -d "node_modules" ]; then
    print_status "OK" "Node modules: Installed"
else
    print_status "WARN" "Node modules: Not installed (run 'npm install')"
fi

# Check if wp-starter directory exists
if [ -d "wp-starter" ]; then
    print_status "OK" "WordPress starter: Found"
else
    print_status "WARN" "WordPress starter: Not found"
fi

# Check if bureau-site directory exists
if [ -d "bureau-site" ]; then
    print_status "OK" "Bureau site: Found"
else
    print_status "WARN" "Bureau site: Not found"
fi

# Check if docs directory exists
if [ -d "docs" ]; then
    print_status "OK" "Documentation: Found"
else
    print_status "WARN" "Documentation: Not found"
fi

# Check disk space
if command -v df &> /dev/null; then
    DISK_USAGE=$(df -h . | tail -1 | awk '{print $5}' | sed 's/%//')
    if [ "$DISK_USAGE" -lt 90 ]; then
        print_status "OK" "Disk space: ${DISK_USAGE}% used"
    else
        print_status "WARN" "Disk space: ${DISK_USAGE}% used (consider cleanup)"
    fi
fi

echo ""
echo "================================================"
print_status "INFO" "System check complete!"

# Provide recommendations
echo ""
echo "📋 Recommendations:"
echo "1. Run 'npm install' to install dependencies"
echo "2. Run 'make install' to set up the complete environment"
echo "3. Run 'make new-client CLIENT=example' to create a test client site"
echo "4. Check the docs/ directory for setup instructions"
