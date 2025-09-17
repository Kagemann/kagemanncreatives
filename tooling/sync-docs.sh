#!/bin/bash

# Kagemann Creatives - Documentation Sync
# Synchronizes documentation across all projects

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

echo -e "${BLUE}📚 Kagemann Creatives - Documentation Sync${NC}"
echo "================================================"

# Check if docs directory exists
if [ ! -d "docs" ]; then
    print_status "ERROR" "Documentation directory not found"
    exit 1
fi

# Function to sync docs to a directory
sync_docs_to() {
    local target_dir=$1
    local target_name=$2
    
    if [ -d "$target_dir" ]; then
        # Create docs directory if it doesn't exist
        mkdir -p "$target_dir/docs"
        
        # Copy documentation files
        cp -r docs/* "$target_dir/docs/"
        print_status "OK" "Synced docs to $target_name"
        
        # Update any project-specific documentation
        if [ -f "$target_dir/docs/README.md" ]; then
            # Add project-specific header
            cat > "$target_dir/docs/README.md" << EOF
# $target_name - Documentation

This directory contains the standard Kagemann Creatives documentation and project-specific guides.

## Standard Documentation
- [Project Brief](01-project-brief.md)
- [Content Inventory](02-content-inventory.csv)
- [SEO Basics](03-seo-basics.md)
- [Launch Checklist](04-launch-checklist.md)
- [Care Plan SOP](05-care-plan-sop.md)
- [Accessibility Quick Check](06-a11y-quickcheck.md)
- [EU Privacy & Cookies](07-eu-privacy-cookie.md)
- [Monthly Report Template](08-monthly-report-template.md)

## Project-Specific Documentation
$(ls -1 "$target_dir/docs" | grep -v -E "^(01-|02-|03-|04-|05-|06-|07-|08-)" | sed 's/^/- /')
EOF
        fi
    else
        print_status "WARN" "Target directory $target_dir not found"
    fi
}

# Sync to wp-starter
sync_docs_to "wp-starter" "WordPress Starter Kit"

# Sync to bureau-site
sync_docs_to "bureau-site" "Bureau Site"

# Sync to all client directories
if [ -d "clients" ]; then
    for client_dir in clients/*/; do
        if [ -d "$client_dir" ]; then
            client_name=$(basename "$client_dir")
            sync_docs_to "$client_dir" "$client_name"
        fi
    done
    print_status "OK" "Synced docs to all client directories"
fi

# Update main documentation index
cat > "docs/README.md" << EOF
# Kagemann Creatives - Documentation

This directory contains all standard documentation, templates, and checklists used across Kagemann Creatives projects.

## 📋 Project Management
- [Project Brief Template](01-project-brief.md) - Standard project brief template
- [Content Inventory](02-content-inventory.csv) - Content audit spreadsheet
- [Launch Checklist](04-launch-checklist.md) - Pre and post-launch tasks
- [Care Plan SOP](05-care-plan-sop.md) - Ongoing maintenance procedures

## 🎯 Marketing & SEO
- [SEO Basics](03-seo-basics.md) - Essential SEO guidelines
- [Monthly Report Template](08-monthly-report-template.md) - Client reporting template

## ♿ Accessibility & Compliance
- [Accessibility Quick Check](06-a11y-quickcheck.md) - A11y testing checklist
- [EU Privacy & Cookies](07-eu-privacy-cookie.md) - GDPR compliance guide

## 📁 Directory Structure
\`\`\`
docs/
├── README.md                    # This file
├── 01-project-brief.md         # Project brief template
├── 02-content-inventory.csv    # Content audit template
├── 03-seo-basics.md           # SEO guidelines
├── 04-launch-checklist.md     # Launch checklist
├── 05-care-plan-sop.md        # Maintenance procedures
├── 06-a11y-quickcheck.md      # Accessibility checklist
├── 07-eu-privacy-cookie.md    # Privacy compliance
└── 08-monthly-report-template.md # Client reports
\`\`\`

## 🔄 Documentation Sync
This documentation is automatically synced to all projects. To update:
\`\`\`bash
make sync-docs
\`\`\`

## 📝 Usage
1. Copy relevant templates for new projects
2. Customize with project-specific information
3. Use checklists to ensure nothing is missed
4. Update templates based on lessons learned

## 📞 Support
For questions about documentation or templates, contact Kagemann Creatives.
EOF

print_status "OK" "Updated main documentation index"

# Check for outdated documentation
echo ""
print_status "INFO" "Checking for documentation updates..."

# Find all README.md files and check if they need updates
find . -name "README.md" -not -path "./node_modules/*" -not -path "./.git/*" | while read -r readme_file; do
    if [ -f "$readme_file" ]; then
        # Check if file was modified in the last 24 hours
        if [ "$(find "$readme_file" -mtime -1)" ]; then
            print_status "OK" "Updated: $readme_file"
        fi
    fi
done

echo ""
echo "================================================"
print_status "OK" "Documentation sync complete!"
echo ""
print_status "INFO" "All projects now have the latest documentation"
print_status "INFO" "Use 'make sync-docs' to update documentation across all projects"
