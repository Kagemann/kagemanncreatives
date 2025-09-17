# Installation Guide - Kagemann Creatives

This guide will help you set up and use the Kagemann Creatives WordPress system.

## Prerequisites

### System Requirements
- **Node.js**: 18.0.0 or higher
- **npm**: 8.0.0 or higher
- **PHP**: 8.0 or higher
- **Composer**: Latest version
- **Git**: Latest version
- **Make**: For automation (optional on Windows)

### Supported Operating Systems
- **macOS**: 10.15 or higher
- **Linux**: Ubuntu 20.04+, CentOS 8+, or equivalent
- **Windows**: 10 or higher (with WSL recommended)

## Quick Start

### 1. Clone the Repository
```bash
git clone https://github.com/kagemann-creatives/kagemann-creatives.git
cd kagemann-creatives
```

### 2. Install Dependencies
```bash
npm install
```

### 3. Run System Check
```bash
make doctor
# or
npm run doctor
```

### 4. Create Your First Client Site
```bash
make new-client CLIENT=example-corp
# or
npm run new-client example-corp
```

## Detailed Installation

### Step 1: Environment Setup

#### macOS/Linux
```bash
# Install Node.js (using nvm)
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
nvm install 18
nvm use 18

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Make (if not available)
# Ubuntu/Debian: sudo apt-get install build-essential
# CentOS/RHEL: sudo yum groupinstall "Development Tools"
```

#### Windows
```bash
# Install Node.js from https://nodejs.org/
# Install Composer from https://getcomposer.org/
# Install Git from https://git-scm.com/
# Install Make from https://www.gnu.org/software/make/
```

### Step 2: Project Setup

```bash
# Clone the repository
git clone https://github.com/kagemann-creatives/kagemann-creatives.git
cd kagemann-creatives

# Install Node.js dependencies
npm install

# Install PHP dependencies
cd wp-starter
composer install
cd ..

# Set up Git hooks
npm run prepare
```

### Step 3: Configuration

#### Environment Variables
```bash
# Copy example environment file
cp wp-starter/config/example.env wp-starter/config/.env

# Edit the configuration
nano wp-starter/config/.env
```

#### Bureau Site Configuration
```bash
# Copy bureau site environment file
cp bureau-site/.env.example bureau-site/.env

# Edit the configuration
nano bureau-site/.env
```

### Step 4: WordPress Setup

#### Local Development
```bash
# Set up local WordPress environment
# Option 1: Using Local by Flywheel
# Option 2: Using XAMPP/MAMP
# Option 3: Using Docker

# Install WordPress
# Copy wp-starter files to your WordPress installation
# Activate the child theme
# Configure plugins and settings
```

#### Production Deployment
```bash
# Build for production
make build

# Deploy to your hosting provider
# Configure domain and SSL
# Set up backups and monitoring
```

## Usage

### Creating New Client Sites

```bash
# Create a new client site
make new-client CLIENT=acme-corp DOMAIN=acmecorp.com

# This will:
# 1. Create a new directory in clients/
# 2. Copy the starter kit
# 3. Replace placeholders with client information
# 4. Set up client-specific documentation
# 5. Create launch checklist
```

### Managing Documentation

```bash
# Sync documentation across all projects
make sync-docs

# This will:
# 1. Copy docs to all projects
# 2. Update project-specific documentation
# 3. Maintain consistency across projects
```

### Code Quality

```bash
# Format code
make fmt

# Check formatting
make fmt-check

# Run linting
npm run lint:php
```

### Development Workflow

```bash
# Start development
make dev

# Build assets
make wp-build

# Run tests
make test

# Deploy
make deploy
```

## Project Structure

```
kagemann-creatives/
├── README.md                 # Project overview
├── LICENSE                   # MIT license
├── package.json             # Node.js dependencies
├── Makefile                 # Automation commands
├── .github/                 # GitHub Actions workflows
├── docs/                    # Documentation
├── tooling/                 # Automation scripts
├── wp-starter/              # WordPress starter kit
├── bureau-site/             # Kagemann Creatives website
└── clients/                 # Generated client sites
```

## WordPress Starter Kit

### Features
- **Block Theme**: Modern WordPress block theme
- **Child Theme**: Extensible child theme structure
- **Must-Use Plugins**: Security, performance, and optimization
- **Block Patterns**: Pre-built content patterns
- **Design Tokens**: Consistent design system
- **Performance**: Optimized for speed and Core Web Vitals
- **Security**: Hardened with security best practices
- **Accessibility**: WCAG 2.1 AA compliant
- **SEO**: Built-in SEO optimization
- **EU Compliance**: GDPR-ready with cookie consent

### Installation
```bash
# Copy to WordPress installation
cp -r wp-starter/theme/child-theme/ /path/to/wordpress/wp-content/themes/
cp -r wp-starter/mu-plugins/ /path/to/wordpress/wp-content/mu-plugins/

# Activate theme in WordPress admin
# Configure settings and content
```

## Bureau Site

### Features
- **Custom Theme**: Built on the starter kit
- **Service Packages**: Three-tier pricing structure
- **Contact Forms**: Lead generation and inquiries
- **Content Management**: Easy content updates
- **Analytics**: Google Analytics 4 integration
- **SEO**: Optimized for search engines
- **Performance**: Fast loading and optimized

### Setup
```bash
# Copy bureau site to WordPress installation
cp -r bureau-site/wp-content/themes/kagemann-bureau/ /path/to/wordpress/wp-content/themes/

# Activate theme in WordPress admin
# Import sample content
# Configure contact forms
# Set up analytics
```

## Automation

### Available Commands

```bash
# System checks
make doctor                    # Check system requirements
make vars                      # Show variable values

# Client management
make new-client CLIENT=name    # Create new client site
make sync-docs                 # Sync documentation

# Code quality
make fmt                       # Format code
make fmt-check                 # Check formatting
make test                      # Run tests

# WordPress
make wp-init                   # Initialize WordPress
make wp-build                  # Build WordPress assets

# Development
make dev                       # Start development
make build                     # Build for production
make clean                     # Clean temporary files

# Deployment
make deploy                    # Deploy to production
```

### GitHub Actions

The project includes automated CI/CD workflows:

- **CI Pipeline**: Code quality, security, and testing
- **Security Scan**: Weekly vulnerability scanning
- **Release**: Automated release creation
- **Deployment**: Staging and production deployment

## Troubleshooting

### Common Issues

#### Node.js Issues
```bash
# Clear npm cache
npm cache clean --force

# Reinstall dependencies
rm -rf node_modules package-lock.json
npm install
```

#### PHP Issues
```bash
# Update Composer
composer self-update

# Clear Composer cache
composer clear-cache

# Reinstall dependencies
rm -rf vendor composer.lock
composer install
```

#### WordPress Issues
```bash
# Check file permissions
find wp-content -type d -exec chmod 755 {} \;
find wp-content -type f -exec chmod 644 {} \;

# Regenerate .htaccess
# Go to WordPress admin > Settings > Permalinks > Save Changes
```

#### Make Issues (Windows)
```bash
# Use npm scripts instead
npm run doctor
npm run new-client
npm run sync-docs
```

### Getting Help

1. **Check the documentation** in the `docs/` directory
2. **Run system diagnostics**: `make doctor`
3. **Check GitHub Issues**: [Project Issues](https://github.com/kagemann-creatives/kagemann-creatives/issues)
4. **Contact Support**: [support@kagemanncreatives.com](mailto:support@kagemanncreatives.com)

## Contributing

### Development Setup
```bash
# Fork the repository
# Clone your fork
# Create a feature branch
# Make your changes
# Run tests and linting
# Submit a pull request
```

### Code Standards
- **PHP**: Follow WordPress coding standards
- **JavaScript**: Use Prettier for formatting
- **CSS**: Follow BEM methodology
- **Documentation**: Use Markdown format

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

- **Documentation**: [docs/](docs/)
- **Issues**: [GitHub Issues](https://github.com/kagemann-creatives/kagemann-creatives/issues)
- **Email**: [support@kagemanncreatives.com](mailto:support@kagemanncreatives.com)
- **Website**: [kagemanncreatives.com](https://kagemanncreatives.com)

---

**Created by**: Kagemann Creatives  
**Version**: 1.0.0  
**Last Updated**: [DATE]
