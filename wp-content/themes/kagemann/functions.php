<?php
// Theme setup
add_action('after_setup_theme', function(){
  add_theme_support('title-tag');
  add_theme_support('responsive-embeds');
  add_theme_support('editor-styles');
  add_theme_support('wp-block-styles');
  register_block_pattern_category( 'kagemann', ['label' => __('Kagemann Patterns','kagemann')] );
});

// Enqueue
add_action('wp_enqueue_scripts', function(){
  // Google Fonts (swap). Later: self-host.
  wp_enqueue_style('kagemann-fonts',
    'https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;600;700&family=Space+Mono:wght@400;700&display=swap',
    [], null);
  wp_enqueue_style('kagemann-tokens', get_theme_file_uri('assets/css/tokens.css'), [], '1.0');
  wp_enqueue_style('kagemann-base', get_theme_file_uri('assets/css/base.css'), ['kagemann-tokens'], '1.0');
  wp_enqueue_script('kagemann-app', get_theme_file_uri('assets/js/app.js'), [], '1.0', true);
});

// JSON-LD Organization
add_action('wp_head', function(){
  $org = [
    "@context"=>"https://schema.org",
    "@type"=>"Organization",
    "name"=>"Kagemann Creatives",
    "url"=>"https://kagemanncreatives.com",
    "logo"=> esc_url( get_site_icon_url() ?: get_theme_file_uri('screenshot.png') )
  ];
  echo '<script type="application/ld+json">'.wp_json_encode($org).'</script>';
}, 3);

// Security hardening (light)
add_filter('xmlrpc_enabled', '__return_false');
remove_action('wp_head','wp_generator');

// Image sizes
add_action('after_setup_theme', function(){
  add_image_size('hero-xl', 1920, 1080, true);
  add_image_size('logo-sm', 200, 80, false);
});

