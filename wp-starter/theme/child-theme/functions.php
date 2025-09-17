<?php
/**
 * {{CLIENT_TITLE}} - Kagemann Creatives Starter Theme Functions
 * 
 * @package {{CLIENT_SLUG}}
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme setup
 */
function {{CLIENT_SLUG}}_setup() {
    // Add theme support for various features
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ));
    add_theme_support('custom-logo');
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('responsive-embeds');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('editor-styles');
    add_theme_support('editor-font-sizes');
    add_theme_support('editor-color-palette');
    
    // Add custom image sizes
    add_image_size('hero-image', 1200, 600, true);
    add_image_size('service-image', 400, 300, true);
    add_image_size('team-image', 300, 300, true);
    add_image_size('blog-thumbnail', 600, 400, true);
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', '{{CLIENT_SLUG}}'),
        'footer' => __('Footer Menu', '{{CLIENT_SLUG}}'),
        'social' => __('Social Menu', '{{CLIENT_SLUG}}'),
    ));
}
add_action('after_setup_theme', '{{CLIENT_SLUG}}_setup');

/**
 * Enqueue scripts and styles
 */
function {{CLIENT_SLUG}}_scripts() {
    // Enqueue parent theme styles
    wp_enqueue_style('twentytwentyfour-style', get_template_directory_uri() . '/style.css');
    
    // Enqueue child theme styles
    wp_enqueue_style('{{CLIENT_SLUG}}-style', get_stylesheet_uri(), array('twentytwentyfour-style'), '1.0.0');
    
    // Enqueue custom CSS
    wp_enqueue_style('{{CLIENT_SLUG}}-tokens', get_stylesheet_directory_uri() . '/assets/css/tokens.css', array('{{CLIENT_SLUG}}-style'), '1.0.0');
    
    // Enqueue custom JavaScript
    wp_enqueue_script('{{CLIENT_SLUG}}-frontend', get_stylesheet_directory_uri() . '/assets/js/frontend.js', array('jquery'), '1.0.0', true);
    
    // Localize script for AJAX
    wp_localize_script('{{CLIENT_SLUG}}-frontend', '{{CLIENT_SLUG}}_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('{{CLIENT_SLUG}}_nonce'),
        'strings' => array(
            'loading' => __('Loading...', '{{CLIENT_SLUG}}'),
            'error' => __('An error occurred. Please try again.', '{{CLIENT_SLUG}}'),
        )
    ));
}
add_action('wp_enqueue_scripts', '{{CLIENT_SLUG}}_scripts');

/**
 * Register block patterns
 */
function {{CLIENT_SLUG}}_register_block_patterns() {
    // Register custom block patterns
    register_block_pattern(
        '{{CLIENT_SLUG}}/hero-section',
        array(
            'title' => __('Hero Section', '{{CLIENT_SLUG}}'),
            'description' => __('A hero section with title, description, and call-to-action button.', '{{CLIENT_SLUG}}'),
            'content' => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}},"backgroundColor":"primary","textColor":"background"} -->
<div class="wp-block-group alignfull has-background-color has-primary-background-color has-text-color has-background-color" style="padding-top:4rem;padding-bottom:4rem"><!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":1,"style":{"typography":{"fontSize":"3rem","fontWeight":"700"}}} -->
<h1 class="wp-block-heading" style="font-size:3rem;font-weight:700">Welcome to {{CLIENT_TITLE}}</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"1.25rem"}}} -->
<p style="font-size:1.25rem">We provide exceptional services to help your business grow and succeed in the digital world.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"style":{"border":{"radius":"8px"},"spacing":{"padding":{"top":"1rem","bottom":"1rem","left":"2rem","right":"2rem"}}}} -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" style="border-radius:8px;padding-top:1rem;padding-right:2rem;padding-bottom:1rem;padding-left:2rem">Get Started</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="https://via.placeholder.com/600x400/007cba/ffffff?text=Hero+Image" alt="Hero Image"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
            'categories' => array('{{CLIENT_SLUG}}'),
        )
    );
    
    register_block_pattern(
        '{{CLIENT_SLUG}}/services-grid',
        array(
            'title' => __('Services Grid', '{{CLIENT_SLUG}}'),
            'description' => __('A grid layout showcasing your services with icons and descriptions.', '{{CLIENT_SLUG}}'),
            'content' => '<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}},"backgroundColor":"background"} -->
<div class="wp-block-group alignwide has-background-color has-background-background-color has-text-color" style="padding-top:4rem;padding-bottom:4rem"><!-- wp:heading {"textAlign":"center","style":{"typography":{"fontSize":"2.5rem","fontWeight":"600"}}} -->
<h2 class="wp-block-heading has-text-align-center" style="font-size:2.5rem;font-weight:600">Our Services</h2>
<!-- /wp:heading -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"border":{"radius":"8px"},"spacing":{"padding":{"top":"2rem","bottom":"2rem","left":"2rem","right":"2rem"}},"border":{"width":"1px","style":"solid","color":"#e1e5e9"}}} -->
<div class="wp-block-group" style="border-width:1px;border-style:solid;border-color:#e1e5e9;border-radius:8px;padding-top:2rem;padding-right:2rem;padding-bottom:2rem;padding-left:2rem"><!-- wp:heading {"level":3,"textAlign":"center"} -->
<h3 class="wp-block-heading has-text-align-center">Service 1</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Description of your first service and how it benefits your clients.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"border":{"radius":"8px"},"spacing":{"padding":{"top":"2rem","bottom":"2rem","left":"2rem","right":"2rem"}},"border":{"width":"1px","style":"solid","color":"#e1e5e9"}}} -->
<div class="wp-block-group" style="border-width:1px;border-style:solid;border-color:#e1e5e9;border-radius:8px;padding-top:2rem;padding-right:2rem;padding-bottom:2rem;padding-left:2rem"><!-- wp:heading {"level":3,"textAlign":"center"} -->
<h3 class="wp-block-heading has-text-align-center">Service 2</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Description of your second service and how it benefits your clients.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"border":{"radius":"8px"},"spacing":{"padding":{"top":"2rem","bottom":"2rem","left":"2rem","right":"2rem"}},"border":{"width":"1px","style":"solid","color":"#e1e5e9"}}} -->
<div class="wp-block-group" style="border-width:1px;border-style:solid;border-color:#e1e5e9;border-radius:8px;padding-top:2rem;padding-right:2rem;padding-bottom:2rem;padding-left:2rem"><!-- wp:heading {"level":3,"textAlign":"center"} -->
<h3 class="wp-block-heading has-text-align-center">Service 3</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Description of your third service and how it benefits your clients.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
            'categories' => array('{{CLIENT_SLUG}}'),
        )
    );
    
    register_block_pattern(
        '{{CLIENT_SLUG}}/contact-section',
        array(
            'title' => __('Contact Section', '{{CLIENT_SLUG}}'),
            'description' => __('A contact section with form and contact information.', '{{CLIENT_SLUG}}'),
            'content' => '<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}},"backgroundColor":"secondary"} -->
<div class="wp-block-group alignwide has-background-color has-secondary-background-color has-text-color" style="padding-top:4rem;padding-bottom:4rem"><!-- wp:heading {"textAlign":"center","style":{"typography":{"fontSize":"2.5rem","fontWeight":"600"}}} -->
<h2 class="wp-block-heading has-text-align-center" style="font-size:2.5rem;font-weight:600">Get In Touch</h2>
<!-- /wp:heading -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Contact Information</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Ready to start your project? Get in touch with us today.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong>Email:</strong> info@{{CLIENT_DOMAIN}}<br><strong>Phone:</strong> +45 12 34 56 78<br><strong>Address:</strong> Your Business Address</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Send us a Message</h3>
<!-- /wp:heading -->

<!-- wp:contact-form-7 / --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
            'categories' => array('{{CLIENT_SLUG}}'),
        )
    );
}
add_action('init', '{{CLIENT_SLUG}}_register_block_patterns');

/**
 * Register block pattern category
 */
function {{CLIENT_SLUG}}_register_pattern_category() {
    register_block_pattern_category(
        '{{CLIENT_SLUG}}',
        array('label' => __('{{CLIENT_TITLE}} Patterns', '{{CLIENT_SLUG}}'))
    );
}
add_action('init', '{{CLIENT_SLUG}}_register_pattern_category');

/**
 * Add skip link for accessibility
 */
function {{CLIENT_SLUG}}_skip_link() {
    echo '<a class="skip-link screen-reader-text" href="#main">' . __('Skip to main content', '{{CLIENT_SLUG}}') . '</a>';
}
add_action('wp_body_open', '{{CLIENT_SLUG}}_skip_link');

/**
 * Add schema markup
 */
function {{CLIENT_SLUG}}_schema_markup() {
    if (is_front_page()) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => '{{CLIENT_TITLE}}',
            'url' => home_url(),
            'logo' => get_custom_logo(),
            'contactPoint' => array(
                '@type' => 'ContactPoint',
                'telephone' => '+45-12-34-56-78',
                'contactType' => 'customer service',
                'email' => 'info@{{CLIENT_DOMAIN}}'
            ),
            'address' => array(
                '@type' => 'PostalAddress',
                'addressCountry' => 'DK',
                'addressLocality' => 'Copenhagen',
                'addressRegion' => 'Capital Region'
            )
        );
        
        echo '<script type="application/ld+json">' . json_encode($schema) . '</script>';
    }
}
add_action('wp_head', '{{CLIENT_SLUG}}_schema_markup');

/**
 * Optimize images
 */
function {{CLIENT_SLUG}}_optimize_images($content) {
    // Add loading="lazy" to images
    $content = preg_replace('/<img(.*?)>/i', '<img$1 loading="lazy">', $content);
    
    // Add WebP support
    $content = preg_replace('/\.(jpg|jpeg|png)/i', '.webp', $content);
    
    return $content;
}
add_filter('the_content', '{{CLIENT_SLUG}}_optimize_images');

/**
 * Add security headers
 */
function {{CLIENT_SLUG}}_security_headers() {
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
    }
}
add_action('send_headers', '{{CLIENT_SLUG}}_security_headers');

/**
 * Customize excerpt length
 */
function {{CLIENT_SLUG}}_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', '{{CLIENT_SLUG}}_excerpt_length');

/**
 * Customize excerpt more
 */
function {{CLIENT_SLUG}}_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', '{{CLIENT_SLUG}}_excerpt_more');

/**
 * Add custom body classes
 */
function {{CLIENT_SLUG}}_body_classes($classes) {
    if (is_front_page()) {
        $classes[] = 'homepage';
    }
    
    if (is_page_template('page-contact.php')) {
        $classes[] = 'contact-page';
    }
    
    return $classes;
}
add_filter('body_class', '{{CLIENT_SLUG}}_body_classes');

/**
 * Handle AJAX contact form
 */
function {{CLIENT_SLUG}}_handle_contact_form() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], '{{CLIENT_SLUG}}_nonce')) {
        wp_die('Security check failed');
    }
    
    // Sanitize form data
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $message = sanitize_textarea_field($_POST['message']);
    
    // Validate required fields
    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error('All fields are required');
    }
    
    // Send email
    $to = get_option('admin_email');
    $subject = 'New contact form submission from ' . get_bloginfo('name');
    $body = "Name: $name\nEmail: $email\nMessage: $message";
    $headers = array('Content-Type: text/plain; charset=UTF-8');
    
    if (wp_mail($to, $subject, $body, $headers)) {
        wp_send_json_success('Message sent successfully');
    } else {
        wp_send_json_error('Failed to send message');
    }
}
add_action('wp_ajax_contact_form', '{{CLIENT_SLUG}}_handle_contact_form');
add_action('wp_ajax_nopriv_contact_form', '{{CLIENT_SLUG}}_handle_contact_form');

/**
 * Add cookie consent script
 */
function {{CLIENT_SLUG}}_cookie_consent() {
    if (!is_admin()) {
        echo '<script id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-cbid="YOUR_COOKIEBOT_ID" type="text/javascript" async></script>';
    }
}
add_action('wp_head', '{{CLIENT_SLUG}}_cookie_consent');

/**
 * Add Google Analytics
 */
function {{CLIENT_SLUG}}_google_analytics() {
    if (!is_admin()) {
        echo '<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag("js", new Date());
  gtag("config", "GA_MEASUREMENT_ID", {
    "anonymize_ip": true,
    "cookie_flags": "SameSite=None;Secure"
  });
</script>';
    }
}
add_action('wp_head', '{{CLIENT_SLUG}}_google_analytics');
