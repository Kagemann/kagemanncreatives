#!/bin/bash

# Kagemann Creatives - New Client Site Generator
# Creates a new client site from the WordPress starter kit

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

# Function to replace placeholders in files
replace_placeholders() {
    local file=$1
    local client_name=$2
    local client_domain=$3
    
    # Convert client name to various formats
    local client_slug=$(echo "$client_name" | tr '[:upper:]' '[:lower:]' | sed 's/[^a-z0-9]/-/g' | sed 's/--*/-/g' | sed 's/^-\|-$//g')
    local client_title=$(echo "$client_name" | sed 's/-/ /g' | sed 's/\b\w/\U&/g')
    
    # Replace placeholders
    sed -i.bak "s/{{CLIENT_NAME}}/$client_name/g" "$file"
    sed -i.bak "s/{{CLIENT_DOMAIN}}/$client_domain/g" "$file"
    sed -i.bak "s/{{CLIENT_SLUG}}/$client_slug/g" "$file"
    sed -i.bak "s/{{CLIENT_TITLE}}/$client_title/g" "$file"
    sed -i.bak "s/{{BUREAU_NAME}}/Kagemann Creatives/g" "$file"
    sed -i.bak "s/{{BUREAU_DOMAIN}}/kagemanncreatives.com/g" "$file"
    sed -i.bak "s/{{DEFAULT_TIMEZONE}}/Europe\/Copenhagen/g" "$file"
    sed -i.bak "s/{{DEFAULT_HOSTING}}/Kinsta or WP Engine/g" "$file"
    sed -i.bak "s/{{CONSENT_TOOL}}/CookieYes or Cookiebot/g" "$file"
    
    # Remove backup file
    rm -f "$file.bak"
}

# Check if client name is provided
if [ -z "$1" ]; then
    print_status "ERROR" "Client name is required"
    echo "Usage: $0 <client-name> [client-domain]"
    echo "Example: $0 acme-corp acmecorp.com"
    exit 1
fi

CLIENT_NAME="$1"
CLIENT_DOMAIN="${2:-$CLIENT_NAME.com}"

# Validate client name (alphanumeric and hyphens only)
if [[ ! "$CLIENT_NAME" =~ ^[a-zA-Z0-9-]+$ ]]; then
    print_status "ERROR" "Client name must contain only letters, numbers, and hyphens"
    exit 1
fi

# Check if wp-starter exists
if [ ! -d "wp-starter" ]; then
    print_status "ERROR" "WordPress starter kit not found. Run from the project root."
    exit 1
fi

# Check if clients directory exists, create if not
if [ ! -d "clients" ]; then
    mkdir -p clients
    print_status "OK" "Created clients directory"
fi

# Check if client already exists
CLIENT_DIR="clients/$CLIENT_NAME"
if [ -d "$CLIENT_DIR" ]; then
    print_status "ERROR" "Client '$CLIENT_NAME' already exists in $CLIENT_DIR"
    exit 1
fi

echo -e "${BLUE}🚀 Creating new client site: $CLIENT_NAME${NC}"
echo "================================================"

# Create client directory
mkdir -p "$CLIENT_DIR"
print_status "OK" "Created client directory: $CLIENT_DIR"

# Copy wp-starter to client directory
cp -r wp-starter/* "$CLIENT_DIR/"
print_status "OK" "Copied WordPress starter kit"

# Copy documentation
cp -r docs "$CLIENT_DIR/"
print_status "OK" "Copied documentation"

# Process configuration files
if [ -f "$CLIENT_DIR/config/example.env" ]; then
    cp "$CLIENT_DIR/config/example.env" "$CLIENT_DIR/config/.env"
    replace_placeholders "$CLIENT_DIR/config/.env" "$CLIENT_NAME" "$CLIENT_DOMAIN"
    print_status "OK" "Created environment configuration"
fi

# Process theme files
if [ -f "$CLIENT_DIR/theme/child-theme/style.css" ]; then
    replace_placeholders "$CLIENT_DIR/theme/child-theme/style.css" "$CLIENT_NAME" "$CLIENT_DOMAIN"
    print_status "OK" "Updated theme stylesheet"
fi

if [ -f "$CLIENT_DIR/theme/child-theme/functions.php" ]; then
    replace_placeholders "$CLIENT_DIR/theme/child-theme/functions.php" "$CLIENT_NAME" "$CLIENT_DOMAIN"
    print_status "OK" "Updated theme functions"
fi

# Process README
if [ -f "$CLIENT_DIR/README.md" ]; then
    replace_placeholders "$CLIENT_DIR/README.md" "$CLIENT_NAME" "$CLIENT_DOMAIN"
    print_status "OK" "Updated README"
fi

# Create client-specific documentation
cat > "$CLIENT_DIR/docs/client-info.md" << EOF
# $CLIENT_TITLE - Client Information

## Project Details
- **Client Name**: $CLIENT_NAME
- **Domain**: $CLIENT_DOMAIN
- **Created**: $(date)
- **Agency**: Kagemann Creatives

## Next Steps
1. Set up WordPress hosting
2. Configure domain and SSL
3. Install WordPress using the starter kit
4. Customize theme and content
5. Configure SEO and analytics
6. Launch and handover

## Contact Information
- **Agency**: Kagemann Creatives
- **Website**: kagemanncreatives.com
- **Timezone**: Europe/Copenhagen
EOF

print_status "OK" "Created client information document"

# Create launch checklist
cat > "$CLIENT_DIR/docs/launch-checklist.md" << EOF
# $CLIENT_TITLE - Launch Checklist

## Pre-Launch
- [ ] WordPress installed and configured
- [ ] Theme activated and customized
- [ ] Content added and reviewed
- [ ] SEO settings configured
- [ ] Analytics tracking implemented
- [ ] Cookie consent configured
- [ ] Contact forms tested
- [ ] Mobile responsiveness verified
- [ ] Page speed optimized
- [ ] Security plugins activated

## Launch Day
- [ ] Domain configured
- [ ] SSL certificate installed
- [ ] DNS propagated
- [ ] Site accessible
- [ ] All functionality tested
- [ ] Client approval received

## Post-Launch
- [ ] Client training completed
- [ ] Documentation provided
- [ ] Maintenance plan activated
- [ ] Monitoring setup
- [ ] Backup schedule configured
EOF

print_status "OK" "Created launch checklist"

# Install dependencies if composer.json exists
if [ -f "$CLIENT_DIR/composer.json" ]; then
    cd "$CLIENT_DIR"
    if command -v composer &> /dev/null; then
        composer install --no-dev --optimize-autoloader
        print_status "OK" "Installed PHP dependencies"
    else
        print_status "WARN" "Composer not found, skipping PHP dependencies"
    fi
    cd - > /dev/null
fi

echo ""
echo "================================================"
print_status "OK" "Client site '$CLIENT_NAME' created successfully!"
echo ""
print_status "INFO" "Client directory: $CLIENT_DIR"
print_status "INFO" "Domain: $CLIENT_DOMAIN"
echo ""
echo "📋 Next steps:"
echo "1. Review and customize the theme in $CLIENT_DIR/theme/"
echo "2. Configure environment variables in $CLIENT_DIR/config/.env"
echo "3. Set up WordPress hosting and install the starter kit"
echo "4. Follow the launch checklist in $CLIENT_DIR/docs/launch-checklist.md"
echo ""
print_status "INFO" "Happy coding! 🎉"
