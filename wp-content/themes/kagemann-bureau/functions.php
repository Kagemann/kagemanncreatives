<?php
/**
 * Kagemann Creatives Bureau Theme Functions
 *
 * @package KagemannBureau
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme setup
 */
function kagemann_bureau_setup() {
    // Add theme support for various features
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
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
    add_image_size('bureau-hero', 1200, 600, true);
    add_image_size('bureau-service', 400, 300, true);
    add_image_size('bureau-team', 300, 300, true);
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'kagemann-bureau'),
        'footer' => __('Footer Menu', 'kagemann-bureau'),
    ));
}
add_action('after_setup_theme', 'kagemann_bureau_setup');

/**
 * Enqueue scripts and styles
 */
function kagemann_bureau_scripts() {
    // Enqueue theme stylesheet
    wp_enqueue_style('kagemann-bureau-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Enqueue Google Fonts
    wp_enqueue_style('kagemann-bureau-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap', array(), null);
    
    // Enqueue theme JavaScript
    wp_enqueue_script('kagemann-bureau-script', get_template_directory_uri() . '/assets/js/theme.js', array('jquery'), '1.0.0', true);
    
    // Localize script for AJAX
    wp_localize_script('kagemann-bureau-script', 'kagemannBureau', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('kagemann_bureau_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'kagemann_bureau_scripts');

/**
 * Register widget areas
 */
function kagemann_bureau_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar', 'kagemann-bureau'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here.', 'kagemann-bureau'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Widgets', 'kagemann-bureau'),
        'id' => 'footer-widgets',
        'description' => __('Add footer widgets here.', 'kagemann-bureau'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="footer-widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'kagemann_bureau_widgets_init');

/**
 * Customize excerpt length
 */
function kagemann_bureau_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'kagemann_bureau_excerpt_length');

/**
 * Customize excerpt more
 */
function kagemann_bureau_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'kagemann_bureau_excerpt_more');

/**
 * Add custom body classes
 */
function kagemann_bureau_body_classes($classes) {
    if (is_front_page()) {
        $classes[] = 'home-page';
    }
    return $classes;
}
add_filter('body_class', 'kagemann_bureau_body_classes');

/**
 * Handle contact form submission
 */
function kagemann_bureau_handle_contact_form() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'kagemann_bureau_nonce')) {
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
    $subject = 'New Contact Form Submission from ' . $name;
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
    $headers = array('Content-Type: text/plain; charset=UTF-8');
    
    if (wp_mail($to, $subject, $body, $headers)) {
        wp_send_json_success('Message sent successfully!');
    } else {
        wp_send_json_error('Failed to send message');
    }
}
add_action('wp_ajax_contact_form', 'kagemann_bureau_handle_contact_form');
add_action('wp_ajax_nopriv_contact_form', 'kagemann_bureau_handle_contact_form');

/**
 * Add theme customizer options
 */
function kagemann_bureau_customize_register($wp_customize) {
    // Add Bureau section
    $wp_customize->add_section('kagemann_bureau_options', array(
        'title' => __('Bureau Options', 'kagemann-bureau'),
        'priority' => 30,
    ));
    
    // Add contact email setting
    $wp_customize->add_setting('bureau_contact_email', array(
        'default' => get_option('admin_email'),
        'sanitize_callback' => 'sanitize_email',
    ));
    
    $wp_customize->add_control('bureau_contact_email', array(
        'label' => __('Contact Email', 'kagemann-bureau'),
        'section' => 'kagemann_bureau_options',
        'type' => 'email',
    ));
    
    // Add phone number setting
    $wp_customize->add_setting('bureau_phone', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('bureau_phone', array(
        'label' => __('Phone Number', 'kagemann-bureau'),
        'section' => 'kagemann_bureau_options',
        'type' => 'text',
    ));
}
add_action('customize_register', 'kagemann_bureau_customize_register');

/**
 * Add editor styles
 */
function kagemann_bureau_add_editor_styles() {
    add_editor_style('assets/css/editor-style.css');
}
add_action('admin_init', 'kagemann_bureau_add_editor_styles');

/**
 * Disable WordPress admin bar for non-admins
 */
function kagemann_bureau_disable_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'kagemann_bureau_disable_admin_bar');

/**
 * Remove WordPress version from head
 */
remove_action('wp_head', 'wp_generator');

/**
 * Remove unnecessary WordPress head elements
 */
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');

/**
 * Add security headers
 */
function kagemann_bureau_security_headers() {
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
    }
}
add_action('send_headers', 'kagemann_bureau_security_headers');
