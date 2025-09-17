# Deployment Guide - Kagemann Creatives

This guide will walk you through deploying your WordPress system to production.

## 🚀 Quick Start Deployment

### Option 1: GitHub Repository (Recommended)

1. **Create GitHub Repository**
   ```bash
   # Go to GitHub.com and create a new repository
   # Name it: kagemann-creatives
   # Make it private (for now)
   ```

2. **Push to GitHub**
   ```bash
   git remote add origin https://github.com/YOUR_USERNAME/kagemann-creatives.git
   git branch -M main
   git push -u origin main
   ```

3. **Set up GitHub Actions** (automatically configured)
   - Go to your repository settings
   - Enable GitHub Actions
   - The CI/CD pipeline will run automatically

### Option 2: Direct Hosting

1. **Choose a Hosting Provider**
   - **Kinsta** (recommended for WordPress)
   - **WP Engine**
   - **SiteGround**
   - **DigitalOcean**
   - **AWS/Azure**

2. **Upload Files**
   ```bash
   # Compress the project
   tar -czf kagemann-creatives.tar.gz --exclude=node_modules --exclude=.git .
   
   # Upload via FTP/SFTP or hosting panel
   ```

## 🏢 Setting Up Your Bureau Website

### Step 1: Choose Your Domain
- **Domain**: kagemanncreatives.com (or your preferred domain)
- **Subdomain**: www.kagemanncreatives.com
- **Email**: hello@kagemanncreatives.com

### Step 2: Set Up WordPress Hosting

#### Option A: Managed WordPress Hosting (Recommended)

**Kinsta Setup:**
1. Sign up at [kinsta.com](https://kinsta.com)
2. Create a new WordPress site
3. Choose your domain
4. Select "WordPress" as the application
5. Choose your data center location (Europe for Denmark)

**WP Engine Setup:**
1. Sign up at [wpengine.com](https://wpengine.com)
2. Create a new WordPress site
3. Choose your domain
4. Select your plan (Startup plan is fine for beginning)

#### Option B: VPS/Cloud Hosting

**DigitalOcean Setup:**
1. Create a Droplet (Ubuntu 22.04)
2. Install LAMP stack
3. Install WordPress
4. Configure domain and SSL

### Step 3: Deploy Your Bureau Site

#### Method 1: Using the Starter Kit

1. **Download WordPress**
   ```bash
   # On your server
   wget https://wordpress.org/latest.tar.gz
   tar -xzf latest.tar.gz
   mv wordpress/* /var/www/html/
   ```

2. **Upload Your Theme**
   ```bash
   # Copy the bureau theme
   scp -r bureau-site/wp-content/themes/kagemann-bureau/ user@your-server:/var/www/html/wp-content/themes/
   ```

3. **Upload Must-Use Plugins**
   ```bash
   # Copy MU plugins
   scp -r wp-starter/mu-plugins/ user@your-server:/var/www/html/wp-content/mu-plugins/
   ```

#### Method 2: Using Git (Advanced)

1. **Clone Your Repository**
   ```bash
   # On your server
   git clone https://github.com/YOUR_USERNAME/kagemann-creatives.git
   cd kagemann-creatives
   ```

2. **Set Up WordPress**
   ```bash
   # Download WordPress
   wget https://wordpress.org/latest.tar.gz
   tar -xzf latest.tar.gz
   
   # Copy your custom files
   cp -r bureau-site/wp-content/themes/kagemann-bureau/ wordpress/wp-content/themes/
   cp -r wp-starter/mu-plugins/ wordpress/wp-content/mu-plugins/
   
   # Move to web root
   mv wordpress/* /var/www/html/
   ```

### Step 4: Configure WordPress

1. **Access WordPress Admin**
   - Go to: https://yourdomain.com/wp-admin
   - Complete the WordPress setup wizard

2. **Activate Your Theme**
   - Go to Appearance > Themes
   - Activate "Kagemann Creatives Bureau"

3. **Configure Settings**
   - Go to Settings > General
   - Set site title: "Kagemann Creatives"
   - Set tagline: "Professional WordPress Development for Growing Businesses"
   - Set timezone: "Europe/Copenhagen"

4. **Set Up Pages**
   - Create Home page
   - Create Services page
   - Create About page
   - Create Contact page
   - Set Home page as front page

### Step 5: Install Essential Plugins

#### Required Plugins
```bash
# Install via WordPress admin or WP-CLI
wp plugin install --activate rank-math
wp plugin install --activate wp-rocket
wp plugin install --activate wordfence
wp plugin install --activate updraftplus
wp plugin install --activate fluent-forms
```

#### Plugin Configuration

**Rank Math (SEO):**
1. Run the setup wizard
2. Connect to Google Search Console
3. Set up Google Analytics
4. Configure social media

**WP Rocket (Performance):**
1. Activate license
2. Configure caching settings
3. Enable minification
4. Set up CDN (optional)

**Wordfence (Security):**
1. Run security scan
2. Configure firewall
3. Set up two-factor authentication
4. Enable real-time monitoring

**UpdraftPlus (Backup):**
1. Configure backup schedule
2. Set up cloud storage
3. Test backup restoration

**Fluent Forms (Contact Forms):**
1. Create contact form
2. Set up email notifications
3. Configure spam protection

### Step 6: Configure Analytics and Tracking

1. **Google Analytics 4**
   ```javascript
   // Add to your theme's functions.php or use a plugin
   // Measurement ID: G-XXXXXXXXXX
   ```

2. **Google Search Console**
   - Verify your domain
   - Submit sitemap
   - Monitor performance

3. **Cookie Consent**
   - Install CookieYes or Cookiebot
   - Configure GDPR compliance
   - Test consent flow

### Step 7: Set Up SSL and Security

1. **SSL Certificate**
   - Most hosting providers offer free SSL
   - Enable HTTPS redirect
   - Update WordPress URLs

2. **Security Headers**
   - Configure security headers
   - Enable HSTS
   - Set up CSP

3. **File Permissions**
   ```bash
   # Set correct permissions
   find /var/www/html -type d -exec chmod 755 {} \;
   find /var/www/html -type f -exec chmod 644 {} \;
   chmod 600 /var/www/html/wp-config.php
   ```

### Step 8: Performance Optimization

1. **Image Optimization**
   - Install Smush or ShortPixel
   - Enable WebP conversion
   - Set up lazy loading

2. **Caching**
   - Configure page caching
   - Enable object caching
   - Set up browser caching

3. **CDN (Optional)**
   - Set up Cloudflare or similar
   - Configure caching rules
   - Enable compression

## 🔧 Environment Configuration

### Production Environment Variables

Create a `.env` file on your server:

```bash
# Database
DB_NAME=your_database_name
DB_USER=your_database_user
DB_PASSWORD=your_secure_password
DB_HOST=localhost

# WordPress
WP_HOME=https://kagemanncreatives.com
WP_SITEURL=https://kagemanncreatives.com/wp
WP_DEBUG=false
WP_DEBUG_LOG=false

# Security
AUTH_KEY='your_auth_key'
SECURE_AUTH_KEY='your_secure_auth_key'
# ... (generate all keys at https://api.wordpress.org/secret-key/1.1/salt/)

# Analytics
GA4_MEASUREMENT_ID=G-XXXXXXXXXX
GOOGLE_ANALYTICS_ID=UA-XXXXXXXXX-X

# Email
SMTP_HOST=smtp.your-provider.com
SMTP_USERNAME=hello@kagemanncreatives.com
SMTP_PASSWORD=your_email_password
```

### wp-config.php Setup

```php
<?php
// Load environment variables
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

// Database settings
define('DB_NAME', $_ENV['DB_NAME'] ?? 'wordpress');
define('DB_USER', $_ENV['DB_USER'] ?? 'root');
define('DB_PASSWORD', $_ENV['DB_PASSWORD'] ?? '');
define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');

// WordPress URLs
define('WP_HOME', $_ENV['WP_HOME'] ?? 'https://kagemanncreatives.com');
define('WP_SITEURL', $_ENV['WP_SITEURL'] ?? 'https://kagemanncreatives.com/wp');

// Security
define('WP_DEBUG', $_ENV['WP_DEBUG'] ?? false);
define('WP_DEBUG_LOG', $_ENV['WP_DEBUG_LOG'] ?? false);
define('DISALLOW_FILE_EDIT', true);
define('FORCE_SSL_ADMIN', true);

// Performance
define('WP_CACHE', true);
define('COMPRESS_CSS', true);
define('COMPRESS_SCRIPTS', true);

// Security keys
define('AUTH_KEY', $_ENV['AUTH_KEY'] ?? '');
define('SECURE_AUTH_KEY', $_ENV['SECURE_AUTH_KEY'] ?? '');
// ... (add all security keys)

// Memory limits
define('WP_MEMORY_LIMIT', '256M');
define('WP_MAX_MEMORY_LIMIT', '512M');

// File permissions
define('FS_METHOD', 'direct');

// That's all, stop editing! Happy publishing.
require_once ABSPATH . 'wp-settings.php';
```

## 📊 Monitoring and Maintenance

### Set Up Monitoring

1. **Uptime Monitoring**
   - UptimeRobot (free)
   - Pingdom
   - StatusCake

2. **Performance Monitoring**
   - Google PageSpeed Insights
   - GTmetrix
   - WebPageTest

3. **Security Monitoring**
   - Wordfence alerts
   - Sucuri monitoring
   - Server logs

### Regular Maintenance Tasks

```bash
# Weekly maintenance script
#!/bin/bash
echo "Starting weekly maintenance..."

# Update WordPress
wp core update
wp plugin update --all
wp theme update --all

# Optimize database
wp db optimize

# Clear caches
wp cache flush

# Run security scan
wp plugin activate wordfence
wp wordfence scan

# Backup
wp plugin activate updraftplus
wp updraftplus backup

echo "Weekly maintenance completed!"
```

## 🚀 Launch Checklist

### Pre-Launch
- [ ] Domain configured and pointing to server
- [ ] SSL certificate installed and working
- [ ] WordPress installed and configured
- [ ] Theme activated and customized
- [ ] Essential plugins installed and configured
- [ ] Content added and reviewed
- [ ] Forms tested and working
- [ ] Analytics configured and tracking
- [ ] SEO settings configured
- [ ] Security measures in place
- [ ] Backup system working
- [ ] Performance optimized
- [ ] Mobile responsiveness verified
- [ ] Cross-browser compatibility tested

### Launch Day
- [ ] Final content review
- [ ] Test all functionality
- [ ] Verify analytics tracking
- [ ] Check search console
- [ ] Monitor error logs
- [ ] Test contact forms
- [ ] Verify email delivery
- [ ] Check social media integration
- [ ] Test mobile experience
- [ ] Monitor page speed

### Post-Launch
- [ ] Monitor uptime for 24 hours
- [ ] Check analytics data
- [ ] Review search console
- [ ] Monitor error logs
- [ ] Collect user feedback
- [ ] Plan content updates
- [ ] Schedule regular maintenance

## 🆘 Troubleshooting

### Common Issues

**White Screen of Death:**
```bash
# Check error logs
tail -f /var/log/apache2/error.log
tail -f /var/log/nginx/error.log

# Check file permissions
ls -la /var/www/html/wp-config.php
```

**Database Connection Error:**
```bash
# Test database connection
mysql -u username -p -h localhost database_name
```

**Plugin Conflicts:**
```bash
# Deactivate all plugins
wp plugin deactivate --all

# Reactivate one by one
wp plugin activate plugin-name
```

**Performance Issues:**
```bash
# Check server resources
htop
df -h
free -m

# Optimize database
wp db optimize
```

## 📞 Support

If you need help with deployment:

1. **Check the documentation** in the `docs/` directory
2. **Run system diagnostics**: `make doctor`
3. **Check GitHub Issues**: [Project Issues](https://github.com/kagemann-creatives/kagemann-creatives/issues)
4. **Contact Support**: [support@kagemanncreatives.com](mailto:support@kagemanncreatives.com)

---

**Happy Launching! 🚀**
