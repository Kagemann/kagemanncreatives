<?php
/**
 * Security Hardening - Kagemann Creatives
 * 
 * This must-use plugin implements security hardening measures for WordPress.
 * It includes file editing restrictions, version hiding, and other security features.
 * 
 * @package {{CLIENT_SLUG}}
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Disable file editing in WordPress admin
 */
if (!defined('DISALLOW_FILE_EDIT')) {
    define('DISALLOW_FILE_EDIT', true);
}

/**
 * Hide WordPress version from head and RSS feeds
 */
function {{CLIENT_SLUG}}_remove_wp_version() {
    return '';
}
add_filter('the_generator', '{{CLIENT_SLUG}}_remove_wp_version');

/**
 * Remove WordPress version from scripts and styles
 */
function {{CLIENT_SLUG}}_remove_version_scripts_styles($src) {
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('script_loader_src', '{{CLIENT_SLUG}}_remove_version_scripts_styles', 15, 1);
add_filter('style_loader_src', '{{CLIENT_SLUG}}_remove_version_scripts_styles', 15, 1);

/**
 * Remove unnecessary WordPress head elements
 */
function {{CLIENT_SLUG}}_clean_head() {
    // Remove RSD link
    remove_action('wp_head', 'rsd_link');
    
    // Remove Windows Live Writer manifest link
    remove_action('wp_head', 'wlwmanifest_link');
    
    // Remove WordPress shortlink
    remove_action('wp_head', 'wp_shortlink_wp_head');
    
    // Remove adjacent posts links
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
    
    // Remove WordPress version from head
    remove_action('wp_head', 'wp_generator');
    
    // Remove emoji scripts and styles
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    
    // Remove REST API link
    remove_action('wp_head', 'rest_output_link_wp_head');
    
    // Remove oEmbed discovery links
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    
    // Remove oEmbed-specific JavaScript
    remove_action('wp_head', 'wp_oembed_add_host_js');
}
add_action('init', '{{CLIENT_SLUG}}_clean_head');

/**
 * Disable XML-RPC
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Remove XML-RPC pingback methods
 */
function {{CLIENT_SLUG}}_remove_xmlrpc_pingback_ping($methods) {
    unset($methods['pingback.ping']);
    unset($methods['pingback.extensions.getPingbacks']);
    return $methods;
}
add_filter('xmlrpc_methods', '{{CLIENT_SLUG}}_remove_xmlrpc_pingback_ping');

/**
 * Disable pingbacks
 */
function {{CLIENT_SLUG}}_disable_pingbacks($methods) {
    unset($methods['pingback.ping']);
    return $methods;
}
add_filter('xmlrpc_methods', '{{CLIENT_SLUG}}_disable_pingbacks');

/**
 * Remove pingback headers
 */
function {{CLIENT_SLUG}}_remove_pingback_header($headers) {
    unset($headers['X-Pingback']);
    return $headers;
}
add_filter('wp_headers', '{{CLIENT_SLUG}}_remove_pingback_header');

/**
 * Disable author pages
 */
function {{CLIENT_SLUG}}_disable_author_pages() {
    if (is_author()) {
        wp_redirect(home_url());
        exit;
    }
}
add_action('template_redirect', '{{CLIENT_SLUG}}_disable_author_pages');

/**
 * Remove author links from posts
 */
function {{CLIENT_SLUG}}_remove_author_links($content) {
    $content = preg_replace('/<a[^>]*class="url fn n"[^>]*>([^<]*)<\/a>/', '$1', $content);
    return $content;
}
add_filter('the_author_posts_link', '{{CLIENT_SLUG}}_remove_author_links');

/**
 * Disable directory browsing
 */
function {{CLIENT_SLUG}}_disable_directory_browsing() {
    if (is_dir($_SERVER['REQUEST_URI'])) {
        wp_redirect(home_url());
        exit;
    }
}
add_action('template_redirect', '{{CLIENT_SLUG}}_disable_directory_browsing');

/**
 * Remove login error messages
 */
function {{CLIENT_SLUG}}_remove_login_errors() {
    return 'Login failed. Please check your credentials.';
}
add_filter('login_errors', '{{CLIENT_SLUG}}_remove_login_errors');

/**
 * Disable login hints
 */
function {{CLIENT_SLUG}}_disable_login_hints($hints, $user_login, $user) {
    return 'Login failed. Please check your credentials.';
}
add_filter('login_errors', '{{CLIENT_SLUG}}_disable_login_hints');

/**
 * Limit login attempts
 */
function {{CLIENT_SLUG}}_limit_login_attempts() {
    $ip = $_SERVER['REMOTE_ADDR'];
    $attempts = get_transient('login_attempts_' . $ip);
    
    if ($attempts && $attempts >= 5) {
        wp_die('Too many login attempts. Please try again later.');
    }
}
add_action('wp_login_failed', function() {
    $ip = $_SERVER['REMOTE_ADDR'];
    $attempts = get_transient('login_attempts_' . $ip);
    $attempts = $attempts ? $attempts + 1 : 1;
    set_transient('login_attempts_' . $ip, $attempts, 15 * MINUTE_IN_SECONDS);
});

/**
 * Clear login attempts on successful login
 */
add_action('wp_login', function() {
    $ip = $_SERVER['REMOTE_ADDR'];
    delete_transient('login_attempts_' . $ip);
});

/**
 * Add security headers
 */
function {{CLIENT_SLUG}}_add_security_headers() {
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
    }
}
add_action('send_headers', '{{CLIENT_SLUG}}_add_security_headers');

/**
 * Disable file execution in uploads directory
 */
function {{CLIENT_SLUG}}_disable_uploads_execution() {
    $upload_dir = wp_upload_dir();
    $htaccess_file = $upload_dir['basedir'] . '/.htaccess';
    
    if (!file_exists($htaccess_file)) {
        $htaccess_content = "Options -ExecCGI\nAddHandler cgi-script .php .pl .py .jsp .asp .sh .cgi\n";
        file_put_contents($htaccess_file, $htaccess_content);
    }
}
add_action('init', '{{CLIENT_SLUG}}_disable_uploads_execution');

/**
 * Remove unnecessary admin menu items
 */
function {{CLIENT_SLUG}}_remove_admin_menu_items() {
    // Remove comments menu
    remove_menu_page('edit-comments.php');
    
    // Remove tools menu for non-admins
    if (!current_user_can('manage_options')) {
        remove_menu_page('tools.php');
    }
}
add_action('admin_menu', '{{CLIENT_SLUG}}_remove_admin_menu_items');

/**
 * Disable theme and plugin editor
 */
function {{CLIENT_SLUG}}_disable_editors() {
    define('DISALLOW_FILE_EDIT', true);
    define('DISALLOW_FILE_MODS', true);
}
add_action('init', '{{CLIENT_SLUG}}_disable_editors');

/**
 * Remove unnecessary dashboard widgets
 */
function {{CLIENT_SLUG}}_remove_dashboard_widgets() {
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
    remove_meta_box('dashboard_primary', 'dashboard', 'side');
    remove_meta_box('dashboard_secondary', 'dashboard', 'side');
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
    remove_meta_box('dashboard_activity', 'dashboard', 'normal');
}
add_action('wp_dashboard_setup', '{{CLIENT_SLUG}}_remove_dashboard_widgets');

/**
 * Disable automatic updates for non-admins
 */
function {{CLIENT_SLUG}}_disable_auto_updates() {
    if (!current_user_can('manage_options')) {
        add_filter('automatic_updater_disabled', '__return_true');
    }
}
add_action('init', '{{CLIENT_SLUG}}_disable_auto_updates');

/**
 * Remove WordPress version from admin footer
 */
function {{CLIENT_SLUG}}_remove_admin_footer_version() {
    return '';
}
add_filter('admin_footer_text', '{{CLIENT_SLUG}}_remove_admin_footer_version');

/**
 * Disable user enumeration
 */
function {{CLIENT_SLUG}}_disable_user_enumeration() {
    if (isset($_GET['author'])) {
        wp_redirect(home_url());
        exit;
    }
}
add_action('template_redirect', '{{CLIENT_SLUG}}_disable_user_enumeration');

/**
 * Remove unnecessary query strings
 */
function {{CLIENT_SLUG}}_remove_query_strings($src) {
    $output = preg_split("/(&ver|\?ver)/", $src);
    return $output[0];
}
add_filter('script_loader_src', '{{CLIENT_SLUG}}_remove_query_strings', 15, 1);
add_filter('style_loader_src', '{{CLIENT_SLUG}}_remove_query_strings', 15, 1);

/**
 * Disable WordPress feeds
 */
function {{CLIENT_SLUG}}_disable_feeds() {
    wp_die('Feeds are disabled.');
}
add_action('do_feed', '{{CLIENT_SLUG}}_disable_feeds', 1);
add_action('do_feed_rdf', '{{CLIENT_SLUG}}_disable_feeds', 1);
add_action('do_feed_rss', '{{CLIENT_SLUG}}_disable_feeds', 1);
add_action('do_feed_rss2', '{{CLIENT_SLUG}}_disable_feeds', 1);
add_action('do_feed_atom', '{{CLIENT_SLUG}}_disable_feeds', 1);
add_action('do_feed_rss2_comments', '{{CLIENT_SLUG}}_disable_feeds', 1);
add_action('do_feed_atom_comments', '{{CLIENT_SLUG}}_disable_feeds', 1);

/**
 * Remove feed links from head
 */
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);

/**
 * Disable trackbacks and pingbacks
 */
function {{CLIENT_SLUG}}_disable_trackbacks() {
    // Close comments on existing posts
    $posts = get_posts(array(
        'numberposts' => -1,
        'post_status' => 'publish',
        'post_type' => 'post'
    ));
    
    foreach ($posts as $post) {
        if ($post->comment_status === 'open') {
            wp_update_post(array(
                'ID' => $post->ID,
                'comment_status' => 'closed'
            ));
        }
    }
}
add_action('init', '{{CLIENT_SLUG}}_disable_trackbacks');

/**
 * Disable new comments and trackbacks
 */
function {{CLIENT_SLUG}}_disable_new_comments($open, $post_id) {
    return false;
}
add_filter('comments_open', '{{CLIENT_SLUG}}_disable_new_comments', 10, 2);
add_filter('pings_open', '{{CLIENT_SLUG}}_disable_new_comments', 10, 2);

/**
 * Remove comment support from posts
 */
function {{CLIENT_SLUG}}_remove_comment_support() {
    remove_post_type_support('post', 'comments');
    remove_post_type_support('post', 'trackbacks');
}
add_action('init', '{{CLIENT_SLUG}}_remove_comment_support');

/**
 * Hide WordPress version from admin bar
 */
function {{CLIENT_SLUG}}_remove_admin_bar_version() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
}
add_action('wp_before_admin_bar_render', '{{CLIENT_SLUG}}_remove_admin_bar_version');

/**
 * Disable WordPress admin bar for non-admins
 */
function {{CLIENT_SLUG}}_disable_admin_bar() {
    if (!current_user_can('manage_options')) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', '{{CLIENT_SLUG}}_disable_admin_bar');

/**
 * Log failed login attempts
 */
function {{CLIENT_SLUG}}_log_failed_logins($username) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $time = current_time('mysql');
    
    $log_entry = sprintf(
        'Failed login attempt for user "%s" from IP %s at %s. User Agent: %s',
        $username,
        $ip,
        $time,
        $user_agent
    );
    
    error_log($log_entry);
}
add_action('wp_login_failed', '{{CLIENT_SLUG}}_log_failed_logins');

/**
 * Disable WordPress file editor
 */
function {{CLIENT_SLUG}}_disable_file_editor() {
    if (!defined('DISALLOW_FILE_EDIT')) {
        define('DISALLOW_FILE_EDIT', true);
    }
}
add_action('init', '{{CLIENT_SLUG}}_disable_file_editor');
