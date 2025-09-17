# Local WordPress Setup - Kagemann Creatives

This guide will help you set up a local WordPress environment to test your Kagemann Bureau theme.

## 🏠 Local Development Options

### Option 1: Local by Flywheel (Recommended - Easiest)

**Why Local by Flywheel?**
- ✅ One-click WordPress installation
- ✅ No server configuration needed
- ✅ Built-in SSL support
- ✅ Easy database management
- ✅ Perfect for WordPress development

**Setup Steps:**

1. **Download Local**
   - Go to [localwp.com](https://localwp.com)
   - Download Local for Windows
   - Install the application

2. **Create New Site**
   - Open Local
   - Click "Create a new site"
   - Site name: `kagemann-creatives`
   - Choose "Preferred" environment
   - WordPress version: Latest
   - Username: `admin`
   - Password: `admin` (or your choice)
   - Email: `admin@kagemanncreatives.local`

3. **Deploy Your Theme**
   ```bash
   # Copy your theme to Local's themes directory
   # Path will be shown in Local app
   # Usually: C:\Users\YourName\AppData\Roaming\Local\run\kagemann-creatives\app\public\wp-content\themes\
   
   # Copy the theme folder
   xcopy "bureau-site\wp-content\themes\kagemann-bureau" "C:\Users\YourName\AppData\Roaming\Local\run\kagemann-creatives\app\public\wp-content\themes\kagemann-bureau" /E /I
   ```

4. **Activate Your Theme**
   - Go to: `http://kagemann-creatives.local`
   - WordPress Admin → Appearance → Themes
   - Activate "Kagemann Creatives Bureau"

### Option 2: XAMPP (More Control)

**Why XAMPP?**
- ✅ Full control over server configuration
- ✅ Good for learning server management
- ✅ Free and open source
- ✅ Includes phpMyAdmin

**Setup Steps:**

1. **Download XAMPP**
   - Go to [apachefriends.org](https://apachefriends.org)
   - Download XAMPP for Windows
   - Install to `C:\xampp\`

2. **Start Services**
   - Open XAMPP Control Panel
   - Start Apache and MySQL
   - Both should show green "Running" status

3. **Download WordPress**
   ```bash
   # Download WordPress
   curl -O https://wordpress.org/latest.tar.gz
   # Or download manually from wordpress.org
   ```

4. **Extract WordPress**
   - Extract to `C:\xampp\htdocs\kagemann-creatives\`
   - Rename `wp-config-sample.php` to `wp-config.php`

5. **Create Database**
   - Go to `http://localhost/phpmyadmin`
   - Create new database: `kagemann_creatives`
   - Create user: `wordpress` with password: `wordpress`

6. **Configure WordPress**
   - Edit `wp-config.php`:
   ```php
   define('DB_NAME', 'kagemann_creatives');
   define('DB_USER', 'wordpress');
   define('DB_PASSWORD', 'wordpress');
   define('DB_HOST', 'localhost');
   ```

7. **Install WordPress**
   - Go to `http://localhost/kagemann-creatives`
   - Complete WordPress setup wizard

8. **Deploy Your Theme**
   ```bash
   # Copy your theme
   xcopy "bureau-site\wp-content\themes\kagemann-bureau" "C:\xampp\htdocs\kagemann-creatives\wp-content\themes\kagemann-bureau" /E /I
   ```

### Option 3: Docker (Advanced)

**Why Docker?**
- ✅ Consistent environment
- ✅ Easy to share with team
- ✅ Production-like setup
- ✅ Easy cleanup

**Setup Steps:**

1. **Install Docker Desktop**
   - Download from [docker.com](https://docker.com)
   - Install Docker Desktop for Windows

2. **Start Local Environment**
   ```bash
   # Start the containers
   docker-compose up -d
   
   # Check if running
   docker-compose ps
   ```

3. **Access Your Site**
   - WordPress: `http://localhost:8080`
   - phpMyAdmin: `http://localhost:8081`

4. **Deploy Your Theme**
   ```bash
   # Copy theme to wp-content directory
   xcopy "bureau-site\wp-content\themes\kagemann-bureau" "wp-content\themes\kagemann-bureau" /E /I
   ```

5. **Stop Environment**
   ```bash
   # Stop containers
   docker-compose down
   
   # Stop and remove volumes
   docker-compose down -v
   ```

## 🎯 Quick Setup Script

I'll create a quick setup script for you:

```bash
# Create local setup script
@echo off
echo Setting up local WordPress environment...

# Create wp-content directory
mkdir wp-content\themes\kagemann-bureau

# Copy theme files
xcopy "bureau-site\wp-content\themes\kagemann-bureau\*" "wp-content\themes\kagemann-bureau\" /E /I

echo Theme copied successfully!
echo Next steps:
echo 1. Set up WordPress (Local, XAMPP, or Docker)
echo 2. Copy wp-content to your WordPress installation
echo 3. Activate the Kagemann Bureau theme
```

## 📋 Local Development Workflow

### Daily Workflow

1. **Start Local Environment**
   - Open Local/XAMPP/Docker
   - Start your WordPress site

2. **Make Changes**
   - Edit theme files
   - Test changes in browser
   - Use browser dev tools

3. **Test Responsiveness**
   - Test on different screen sizes
   - Check mobile experience
   - Verify accessibility

4. **Commit Changes**
   ```bash
   git add .
   git commit -m "feat: update bureau theme"
   git push origin master
   ```

### Testing Checklist

- [ ] **Home page loads correctly**
- [ ] **All pages display properly**
- [ ] **Contact forms work**
- [ ] **Mobile responsive**
- [ ] **Fast loading**
- [ ] **No console errors**
- [ ] **Accessibility compliant**
- [ ] **SEO elements present**

## 🔧 Local Development Tools

### Browser Extensions
- **WordPress Admin Bar** - Quick admin access
- **Web Developer** - CSS/JS debugging
- **Lighthouse** - Performance testing
- **WAVE** - Accessibility testing

### Development Plugins
- **Query Monitor** - Debug queries
- **Debug Bar** - Development info
- **User Switching** - Test different users
- **WP Crontrol** - Manage cron jobs

### Code Editors
- **VS Code** - With WordPress extensions
- **PhpStorm** - Professional PHP IDE
- **Sublime Text** - Lightweight editor

## 🚀 Deployment from Local

### When Ready to Deploy

1. **Test Everything Locally**
   - All functionality working
   - No errors or warnings
   - Performance optimized

2. **Create Deployment Package**
   ```bash
   # Create theme package
   Compress-Archive -Path "wp-content\themes\kagemann-bureau\*" -DestinationPath "kagemann-bureau-theme.zip"
   ```

3. **Deploy to Production**
   - Upload to One.com
   - Activate theme
   - Configure settings

## 🆘 Troubleshooting

### Common Issues

**Local Site Not Loading:**
- Check if Apache/MySQL is running
- Verify port 80/8080 is not in use
- Check firewall settings

**Theme Not Appearing:**
- Verify theme files are in correct directory
- Check file permissions
- Clear browser cache

**Database Connection Error:**
- Verify database credentials
- Check if MySQL is running
- Test connection in phpMyAdmin

**Plugin Conflicts:**
- Deactivate all plugins
- Activate theme first
- Reactivate plugins one by one

## 📊 Performance Testing

### Local Performance Tools

1. **Lighthouse**
   - Built into Chrome DevTools
   - Test performance, accessibility, SEO
   - Generate reports

2. **GTmetrix**
   - Online performance testing
   - Detailed analysis
   - Recommendations

3. **WebPageTest**
   - Advanced performance testing
   - Multiple locations
   - Detailed waterfall charts

## 🎯 Next Steps

1. **Choose your local setup** (Local by Flywheel recommended)
2. **Install WordPress locally**
3. **Deploy your bureau theme**
4. **Test and customize**
5. **Deploy to production when ready**

---

**Happy Local Development! 🏠**
