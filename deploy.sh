#!/bin/bash

# Kagemann Creatives - Deployment Script
# This script helps you deploy your WordPress system

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

echo -e "${BLUE}🚀 Kagemann Creatives - Deployment Script${NC}"
echo "================================================"

# Check if we're in the right directory
if [ ! -f "README.md" ] || [ ! -d "wp-starter" ] || [ ! -d "bureau-site" ]; then
    print_status "ERROR" "Please run this script from the project root directory"
    exit 1
fi

# Function to deploy to GitHub
deploy_github() {
    print_status "INFO" "Deploying to GitHub..."
    
    # Check if git is initialized
    if [ ! -d ".git" ]; then
        print_status "INFO" "Initializing Git repository..."
        git init
    fi
    
    # Add all files
    git add .
    
    # Check if there are changes to commit
    if git diff --staged --quiet; then
        print_status "WARN" "No changes to commit"
    else
        # Commit changes
        git commit -m "feat: deploy Kagemann Creatives system"
        print_status "OK" "Changes committed"
    fi
    
    # Check if remote exists
    if ! git remote get-url origin >/dev/null 2>&1; then
        print_status "INFO" "Please add your GitHub repository URL:"
        echo "git remote add origin https://github.com/YOUR_USERNAME/kagemann-creatives.git"
        echo "git branch -M main"
        echo "git push -u origin main"
        return 1
    fi
    
    # Push to GitHub
    git push origin main
    print_status "OK" "Successfully pushed to GitHub"
}

# Function to create deployment package
create_package() {
    print_status "INFO" "Creating deployment package..."
    
    # Create package name with timestamp
    PACKAGE_NAME="kagemann-creatives-$(date +%Y%m%d-%H%M%S).tar.gz"
    
    # Create package excluding unnecessary files
    tar -czf "$PACKAGE_NAME" \
        --exclude=node_modules \
        --exclude=.git \
        --exclude=.github \
        --exclude=*.log \
        --exclude=.DS_Store \
        --exclude=clients \
        .
    
    print_status "OK" "Deployment package created: $PACKAGE_NAME"
    echo "You can now upload this file to your hosting provider"
}

# Function to deploy bureau site
deploy_bureau() {
    print_status "INFO" "Preparing bureau site deployment..."
    
    # Create bureau package
    BUREAU_PACKAGE="bureau-site-$(date +%Y%m%d-%H%M%S).tar.gz"
    
    # Package bureau site files
    tar -czf "$BUREAU_PACKAGE" \
        --exclude=node_modules \
        --exclude=.git \
        --exclude=*.log \
        --exclude=.DS_Store \
        bureau-site/
    
    print_status "OK" "Bureau site package created: $BUREAU_PACKAGE"
    echo ""
    echo "To deploy your bureau site:"
    echo "1. Upload this package to your WordPress hosting"
    echo "2. Extract it to your wp-content directory"
    echo "3. Activate the 'Kagemann Creatives Bureau' theme"
    echo "4. Configure your settings and content"
}

# Function to deploy starter kit
deploy_starter() {
    print_status "INFO" "Preparing starter kit deployment..."
    
    # Create starter package
    STARTER_PACKAGE="wp-starter-$(date +%Y%m%d-%H%M%S).tar.gz"
    
    # Package starter kit files
    tar -czf "$STARTER_PACKAGE" \
        --exclude=node_modules \
        --exclude=.git \
        --exclude=*.log \
        --exclude=.DS_Store \
        wp-starter/
    
    print_status "OK" "Starter kit package created: $STARTER_PACKAGE"
    echo ""
    echo "To deploy the starter kit:"
    echo "1. Upload this package to your WordPress hosting"
    echo "2. Extract it to your wp-content directory"
    echo "3. Activate the child theme"
    echo "4. Configure your settings"
}

# Function to show deployment options
show_options() {
    echo ""
    echo "Deployment Options:"
    echo "1. Deploy to GitHub (recommended)"
    echo "2. Create deployment package"
    echo "3. Deploy bureau site only"
    echo "4. Deploy starter kit only"
    echo "5. Show deployment guide"
    echo "6. Exit"
    echo ""
}

# Main deployment function
main() {
    while true; do
        show_options
        read -p "Choose an option (1-6): " choice
        
        case $choice in
            1)
                deploy_github
                ;;
            2)
                create_package
                ;;
            3)
                deploy_bureau
                ;;
            4)
                deploy_starter
                ;;
            5)
                print_status "INFO" "Opening deployment guide..."
                if command -v open &> /dev/null; then
                    open DEPLOYMENT.md
                elif command -v xdg-open &> /dev/null; then
                    xdg-open DEPLOYMENT.md
                else
                    echo "Please open DEPLOYMENT.md in your text editor"
                fi
                ;;
            6)
                print_status "INFO" "Goodbye!"
                exit 0
                ;;
            *)
                print_status "ERROR" "Invalid option. Please choose 1-6."
                ;;
        esac
        
        echo ""
        read -p "Press Enter to continue..."
    done
}

# Check if script is being run directly
if [ "${BASH_SOURCE[0]}" == "${0}" ]; then
    main "$@"
fi
