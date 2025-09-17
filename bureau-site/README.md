# Kagemann Creatives WordPress Theme

A fast, accessible block theme for a small web bureau. Built with modern WordPress block editor (FSE) features, performance optimization, and EU compliance in mind.

## Features

- **Block Theme (FSE):** Built with WordPress 6.5+ block editor features
- **Performance Optimized:** Minimal CSS/JS, fluid typography, optimized images
- **Accessibility First:** WCAG 2.1 AA compliant, semantic markup, keyboard navigation
- **EU Compliant:** Cookie consent ready, GDPR-compliant analytics setup
- **SEO Ready:** JSON-LD schema, clean markup, optimized for search engines
- **Mobile First:** Responsive design, touch-friendly interactions

## Installation

1. **Upload Theme:**
   - Upload the `kagemann` theme folder to `/wp-content/themes/`
   - Or install via WordPress admin: Appearance → Themes → Add New → Upload

2. **Activate Theme:**
   - Go to Appearance → Themes
   - Click "Activate" on the Kagemann Creatives theme

3. **Set Homepage:**
   - Go to Settings → Reading
   - Set "Your homepage displays" to "A static page"
   - Select "Home" as your homepage

## Setup

### 1. Create Navigation Menu
- Go to Appearance → Menus
- Create a new menu (e.g., "Primary Menu")
- Add pages: Home, Services, About, Contact
- Assign to "Primary Menu" location

### 2. Create Pages
Create these essential pages:
- **Home** (uses front-page template with patterns)
- **Services** (insert Services pattern)
- **About** (company story and approach)
- **Contact** (contact information and form)

### 3. Configure Header Navigation
- Edit the header template part
- Update the Navigation block to use your created menu
- Customize navigation styling as needed

## Block Patterns

The theme includes these ready-to-use patterns:

- **Hero:** Main landing section with headline and CTAs
- **Services:** Three-tier service packages with pricing
- **Logos:** Client trust logos section
- **CTA:** Call-to-action section with primary background
- **Contact:** Contact information and form section

### Using Patterns
1. Edit any page in the block editor
2. Click the "+" button to add blocks
3. Go to "Patterns" tab
4. Find "Kagemann Patterns" category
5. Insert desired patterns

## Customization

### Design Tokens
The theme uses CSS custom properties for consistent styling:
- Colors: Primary (#0C1117), Secondary (#F2F5F9), Accent (#5B8DEF)
- Typography: Work Sans (body), Space Mono (headings)
- Spacing: Fluid spacing scale with clamp() functions
- Border radius: Small (6px), Medium (12px), Large (20px)

### Theme.json
All design tokens and block styles are defined in `theme.json`:
- Fluid typography with clamp() functions
- Custom color palette
- Block-specific styling
- Layout settings

### CSS Files
- `tokens.css`: CSS custom properties and utility classes
- `base.css`: Base styles and component classes

## Required Plugins

Install these plugins for full functionality:

1. **Fluent Forms** (or similar)
   - For contact form functionality
   - Replace `[contact-form]` shortcode in Contact pattern

2. **Site Kit by Google**
   - For Google Analytics 4 integration
   - EU-compliant analytics setup

3. **CookieYes** (or similar)
   - For GDPR cookie consent
   - Blocks analytics until consent given

## Performance

### Optimizations Included
- Minimal CSS/JS footprint
- Google Fonts with `display=swap`
- Fluid typography and spacing
- Optimized image sizes
- Clean, semantic HTML

### Performance Targets
- **Lighthouse Performance:** ≥ 90
- **Accessibility:** ≥ 95
- **Best Practices:** ≥ 95
- **SEO:** ≥ 90

## Accessibility

### Features
- Skip-to-content link
- Semantic HTML landmarks
- Proper heading hierarchy
- Keyboard navigation support
- Focus indicators
- Screen reader compatibility

### Testing
Use these tools to verify accessibility:
- WAVE (wave.webaim.org)
- axe DevTools browser extension
- Lighthouse accessibility audit
- Manual keyboard testing

## EU Compliance

### GDPR Features
- Cookie consent integration ready
- Google Analytics with IP anonymization
- Privacy policy template
- Data subject rights documentation

### Implementation
1. Set up CookieYes or similar consent tool
2. Configure Google Analytics with consent mode
3. Add privacy policy page
4. Update contact forms with consent checkboxes

## Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## File Structure

```
kagemann/
├── style.css              # Theme metadata
├── theme.json             # Design tokens and block styles
├── functions.php          # Theme setup and enqueue
├── screenshot.svg         # Theme preview image
├── assets/
│   ├── css/
│   │   ├── tokens.css     # CSS custom properties
│   │   └── base.css       # Base styles
│   ├── js/
│   │   └── app.js         # Minimal JavaScript
│   └── img/
│       └── sample/        # Sample client logos
├── parts/
│   ├── header.html        # Site header
│   └── footer.html        # Site footer
├── templates/
│   ├── front-page.html    # Homepage template
│   ├── page.html          # Page template
│   ├── single.html        # Post template
│   ├── archive.html       # Archive template
│   └── 404.html           # Error page template
└── patterns/
    ├── hero.php           # Hero section pattern
    ├── services.php       # Services pattern
    ├── logos.php          # Trust logos pattern
    ├── cta.php            # Call-to-action pattern
    └── contact.php        # Contact section pattern
```

## Support

For theme support and customization:
- Email: hello@kagemanncreatives.com
- Website: https://kagemanncreatives.com

## License

MIT License - see LICENSE file for details.

## Changelog

### Version 1.0.0
- Initial release
- Block theme with FSE support
- Performance optimized
- Accessibility compliant
- EU compliance ready
