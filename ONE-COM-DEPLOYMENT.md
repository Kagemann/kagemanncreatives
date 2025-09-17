# One.com Deployment Guide - Kagemann Creatives

This guide will help you deploy your Kagemann Creatives bureau website to One.com hosting.

## 🏢 One.com Hosting Setup

### Step 1: Sign Up and Domain Setup

1. **Visit [one.com](https://one.com)**
2. **Choose a hosting plan:**
   - **Basic** (€2-5/month) - Perfect for your bureau site
   - **Pro** (€5-10/month) - If you plan to host client sites too
3. **Register your domain:** kagemanncreatives.com
4. **Complete the signup process**

### Step 2: Install WordPress

1. **Log into your One.com control panel**
2. **Navigate to "Webshop & CMS"**
3. **Click "WordPress"**
4. **Click "Install WordPress"**
5. **Configure WordPress:**
   - **Domain:** kagemanncreatives.com
   - **Admin Username:** (choose a secure username)
   - **Admin Password:** (choose a strong password)
   - **Admin Email:** hello@kagemanncreatives.com
6. **Click "Install"**

### Step 3: Deploy Your Bureau Theme

#### Method 1: Using the Deployment Script

```bash
# Create bureau site package
make deploy-bureau

# This creates: bureau-site-YYYYMMDD-HHMMSS.tar.gz
# Extract this file on your computer
```

#### Method 2: Direct from GitHub

1. **Go to your GitHub repository**
2. **Navigate to:** `bureau-site/wp-content/themes/kagemann-bureau/`
3. **Download the theme files**
4. **Compress into a ZIP file**

### Step 4: Upload Your Theme

#### Option A: One.com File Manager (Recommended)

1. **Log into One.com control panel**
2. **Go to "File Manager"**
3. **Navigate to:** `public_html/wp-content/themes/`
4. **Upload your theme folder**
5. **Extract if needed**

#### Option B: WordPress Admin Upload

1. **Go to WordPress Admin** (yourdomain.com/wp-admin)
2. **Navigate to:** Appearance → Themes → Add New
3. **Click "Upload Theme"**
4. **Upload your theme ZIP file**
5. **Click "Install Now"**

#### Option C: FTP Upload

1. **Use FileZilla or similar FTP client**
2. **Connect to your One.com server:**
   - **Host:** ftp.yourdomain.com
   - **Username:** (from One.com control panel)
   - **Password:** (from One.com control panel)
3. **Navigate to:** `/public_html/wp-content/themes/`
4. **Upload your theme folder**

### Step 5: Activate Your Theme

1. **Go to WordPress Admin**
2. **Navigate to:** Appearance → Themes
3. **Find "Kagemann Creatives Bureau"**
4. **Click "Activate"**

### Step 6: Configure Your Site

#### Basic Settings

1. **Go to Settings → General**
   - **Site Title:** Kagemann Creatives
   - **Tagline:** Professional WordPress Development for Growing Businesses
   - **WordPress Address:** https://kagemanncreatives.com
   - **Site Address:** https://kagemanncreatives.com
   - **Timezone:** Copenhagen

2. **Go to Settings → Reading**
   - **Front page displays:** A static page
   - **Front page:** Home
   - **Posts page:** Blog

#### Create Essential Pages

1. **Go to Pages → Add New**
2. **Create these pages:**
   - **Home** (set as front page)
   - **Services**
   - **About**
   - **Contact**
   - **Blog** (set as posts page)

### Step 7: Install Essential Plugins

#### Required Plugins

1. **Rank Math (SEO)**
   - Go to Plugins → Add New
   - Search for "Rank Math"
   - Install and activate
   - Run the setup wizard

2. **WP Rocket (Performance)**
   - Purchase from wp-rocket.me
   - Upload via Plugins → Add New → Upload Plugin
   - Activate and configure

3. **Wordfence (Security)**
   - Go to Plugins → Add New
   - Search for "Wordfence"
   - Install and activate
   - Run security scan

4. **UpdraftPlus (Backup)**
   - Go to Plugins → Add New
   - Search for "UpdraftPlus"
   - Install and activate
   - Configure backup schedule

5. **Fluent Forms (Contact Forms)**
   - Go to Plugins → Add New
   - Search for "Fluent Forms"
   - Install and activate
   - Create contact forms

### Step 8: Configure Analytics

#### Google Analytics 4

1. **Create Google Analytics account**
2. **Get your Measurement ID (G-XXXXXXXXXX)**
3. **Add to your theme's functions.php or use a plugin**

#### Google Search Console

1. **Go to [search.google.com/search-console](https://search.google.com/search-console)**
2. **Add your property:** kagemanncreatives.com
3. **Verify ownership**
4. **Submit your sitemap**

### Step 9: Set Up Email

#### Professional Email

1. **Go to One.com control panel**
2. **Navigate to "Email"**
3. **Create email addresses:**
   - hello@kagemanncreatives.com
   - info@kagemanncreatives.com
   - support@kagemanncreatives.com

#### SMTP Configuration

```php
// Add to wp-config.php
define('SMTP_HOST', 'smtp.one.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'hello@kagemanncreatives.com');
define('SMTP_PASSWORD', 'your_email_password');
define('SMTP_SECURE', 'tls');
```

### Step 10: Performance Optimization

#### One.com Specific Optimizations

1. **Enable Caching**
   - Go to One.com control panel
   - Navigate to "Performance"
   - Enable "Page Caching"

2. **Optimize Images**
   - Install Smush plugin
   - Compress all images
   - Enable WebP conversion

3. **Minify CSS/JS**
   - Use WP Rocket or similar
   - Enable minification
   - Combine files

### Step 11: Security Setup

#### One.com Security Features

1. **Enable SSL**
   - Go to One.com control panel
   - Navigate to "SSL"
   - Enable "Let's Encrypt SSL"

2. **Set Up Firewall**
   - Install Wordfence
   - Configure firewall rules
   - Enable two-factor authentication

3. **Regular Backups**
   - Configure UpdraftPlus
   - Set daily backups
   - Store in cloud storage

### Step 12: Content Setup

#### Home Page Content

1. **Edit your Home page**
2. **Add your hero section**
3. **Add service overview**
4. **Add call-to-action**

#### Services Page

1. **Create your three service packages:**
   - **Starter Package** (€2,500)
   - **Growth Package** (€5,000)
   - **Pro Package** (€10,000)

#### About Page

1. **Add company story**
2. **Add team information**
3. **Add values and mission**

#### Contact Page

1. **Add contact information**
2. **Create contact form**
3. **Add business hours**
4. **Add location/map**

## 🔧 One.com Specific Tips

### File Permissions

```bash
# One.com uses specific file permissions
# Folders: 755
# Files: 644
# wp-config.php: 600
```

### Database Optimization

```sql
-- One.com provides phpMyAdmin
-- Regular database optimization recommended
-- Use WP-CLI if available
```

### Performance Monitoring

1. **Use One.com's built-in analytics**
2. **Set up Google Analytics**
3. **Monitor page speed**
4. **Check Core Web Vitals**

## 🚀 Launch Checklist

### Pre-Launch
- [ ] Domain configured and pointing to One.com
- [ ] SSL certificate active
- [ ] WordPress installed and configured
- [ ] Bureau theme activated
- [ ] Essential plugins installed
- [ ] Content added and reviewed
- [ ] Contact forms working
- [ ] Analytics configured
- [ ] Email addresses set up
- [ ] Performance optimized
- [ ] Security measures in place
- [ ] Backups configured

### Launch Day
- [ ] Final content review
- [ ] Test all functionality
- [ ] Verify analytics tracking
- [ ] Check contact forms
- [ ] Test email delivery
- [ ] Monitor performance
- [ ] Check mobile experience

### Post-Launch
- [ ] Monitor for 24 hours
- [ ] Check analytics data
- [ ] Review search console
- [ ] Monitor error logs
- [ ] Collect feedback
- [ ] Plan content updates

## 🆘 One.com Support

### Getting Help

1. **One.com Support Center**
   - Log into your control panel
   - Go to "Support"
   - Search knowledge base

2. **One.com Community**
   - Visit community.one.com
   - Ask questions
   - Get help from other users

3. **One.com Support**
   - Submit support ticket
   - Live chat available
   - Phone support (premium plans)

### Common Issues

**WordPress Installation Issues:**
- Check file permissions
- Verify database connection
- Clear browser cache

**Theme Upload Issues:**
- Check file size limits
- Verify ZIP file format
- Try FTP upload instead

**Performance Issues:**
- Enable caching
- Optimize images
- Check plugin conflicts

## 📊 One.com Pricing

### Hosting Plans

- **Basic:** €2-5/month
  - 1 website
  - 25GB storage
  - 1 email account
  - Perfect for bureau site

- **Pro:** €5-10/month
  - 5 websites
  - 100GB storage
  - 5 email accounts
  - Good for hosting client sites

- **Business:** €10-20/month
  - Unlimited websites
  - 500GB storage
  - Unlimited email accounts
  - Advanced features

## 🎯 Next Steps

1. **Sign up for One.com**
2. **Install WordPress**
3. **Deploy your bureau theme**
4. **Configure your content**
5. **Set up analytics**
6. **Go live!**

---

**Happy Launching with One.com! 🚀**
