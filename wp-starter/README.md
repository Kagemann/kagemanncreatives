# WordPress Starter Kit - Kagemann Creatives

A production-ready WordPress starter kit optimized for SMB websites with built-in performance, security, and compliance features.

## Features

- **Block Theme**: Modern WordPress block theme with child theme support
- **Performance Optimized**: Fast loading with optimized assets
- **Security Hardened**: Built-in security measures and best practices
- **EU Compliant**: GDPR-ready with cookie consent integration
- **Accessibility**: WCAG 2.1 AA compliant design
- **SEO Ready**: Built-in SEO optimization and schema markup
- **Mobile First**: Responsive design with mobile optimization

## Quick Start

1. **Copy to WordPress**: Copy this starter kit to your WordPress installation
2. **Activate Theme**: Activate the child theme in WordPress admin
3. **Configure**: Set up your site settings and content
4. **Customize**: Modify colors, fonts, and content as needed

## Structure

```
wp-starter/
├── theme/
│   └── child-theme/          # WordPress child theme
│       ├── style.css         # Theme stylesheet
│       ├── functions.php     # Theme functions
│       ├── theme.json        # Block theme configuration
│       ├── assets/           # CSS and JavaScript assets
│       └── patterns/         # Block patterns
├── mu-plugins/               # Must-use plugins
├── config/                   # Configuration files
└── composer.json            # PHP dependencies
```

## Installation

### Manual Installation
1. Download or clone this starter kit
2. Copy the `theme/child-theme` folder to your WordPress `wp-content/themes/` directory
3. Copy the `mu-plugins` folder to your WordPress `wp-content/mu-plugins/` directory
4. Activate the theme in WordPress admin

### Using the New Client Script
```bash
# From the project root
make new-client CLIENT=your-client-name
```

## Configuration

### Environment Variables
Copy `config/example.env` to `config/.env` and configure:
- Site URL and admin settings
- Database configuration
- Security keys
- Analytics and tracking IDs

### Theme Customization
- **Colors**: Modify CSS variables in `assets/css/tokens.css`
- **Fonts**: Update font families in `theme.json`
- **Layout**: Customize block patterns in `patterns/` directory

## Block Patterns

The starter kit includes pre-built block patterns:
- **Hero Section**: Eye-catching homepage hero
- **Services Grid**: Service showcase layout
- **Contact Form**: Professional contact section
- **About Section**: Company information layout
- **Testimonials**: Customer testimonial display

## Must-Use Plugins

### Security Hardening (`01-hardening.php`)
- Disable file editing
- Hide WordPress version
- Remove unnecessary headers
- Secure login attempts

### Media Optimization (`02-media-sizes.php`)
- Optimize image sizes
- Add WebP support
- Lazy loading implementation
- Image compression

### Clean Head (`03-clean-head.php`)
- Remove unnecessary meta tags
- Optimize head section
- Add security headers
- Performance optimizations

## Recommended Plugins

### Performance
- **WP Rocket**: Caching and optimization
- **LiteSpeed Cache**: Alternative caching solution
- **Smush**: Image optimization

### SEO
- **Rank Math**: All-in-one SEO solution
- **Yoast SEO**: Popular SEO plugin

### Security
- **Wordfence**: Security scanning and firewall
- **Sucuri**: Security monitoring

### Forms
- **Fluent Forms**: Contact form builder
- **Contact Form 7**: Simple contact forms

### Backup
- **BlogVault**: Automated backups
- **UpdraftPlus**: Backup and restore

## Development

### Local Development
1. Set up local WordPress environment
2. Install the starter kit
3. Run `composer install` for dependencies
4. Start customizing

### Building Assets
```bash
# Install dependencies
npm install

# Build assets
npm run build

# Watch for changes
npm run watch
```

## Customization

### Adding New Block Patterns
1. Create new PHP file in `patterns/` directory
2. Follow the existing pattern structure
3. Register the pattern in `functions.php`

### Modifying Styles
1. Edit CSS variables in `assets/css/tokens.css`
2. Add custom styles to `style.css`
3. Use WordPress block editor for visual customization

### Adding JavaScript
1. Add scripts to `assets/js/frontend.js`
2. Enqueue scripts in `functions.php`
3. Follow WordPress best practices

## Performance Optimization

### Built-in Optimizations
- Minified CSS and JavaScript
- Optimized images and WebP support
- Lazy loading implementation
- Clean HTML output
- Efficient database queries

### Additional Recommendations
- Use a CDN for static assets
- Enable browser caching
- Optimize database regularly
- Monitor Core Web Vitals

## Security Features

### Built-in Security
- Disabled file editing
- Hidden WordPress version
- Secure login attempts
- Clean error messages
- Security headers

### Additional Recommendations
- Use strong passwords
- Enable two-factor authentication
- Regular security updates
- Monitor for vulnerabilities

## Compliance

### GDPR Compliance
- Cookie consent integration
- Privacy policy template
- Data processing transparency
- User rights implementation

### Accessibility
- WCAG 2.1 AA compliant
- Keyboard navigation support
- Screen reader compatibility
- High contrast support

## Support

### Documentation
- Check the `docs/` directory for detailed guides
- Review WordPress Codex for block theme development
- Consult plugin documentation for specific features

### Troubleshooting
1. Check WordPress error logs
2. Verify plugin compatibility
3. Test with default theme
4. Contact Kagemann Creatives for support

## License

MIT License - See [LICENSE](../LICENSE) for details.

## Changelog

### Version 1.0.0
- Initial release
- Block theme implementation
- Security hardening
- Performance optimization
- EU compliance features

---

**Created by**: Kagemann Creatives  
**Website**: kagemanncreatives.com  
**Support**: [support@kagemanncreatives.com](mailto:support@kagemanncreatives.com)
