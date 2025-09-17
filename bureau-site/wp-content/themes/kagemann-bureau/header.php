<?php
/**
 * The header template
 *
 * @package KagemannBureau
 * @since 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#main"><?php _e('Skip to content', 'kagemann-bureau'); ?></a>

    <header id="masthead" class="site-header">
        <div class="container">
            <div class="site-branding">
                <?php
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    ?>
                    <h1 class="site-title">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <?php bloginfo('name'); ?>
                        </a>
                    </h1>
                    <?php
                    $description = get_bloginfo('description', 'display');
                    if ($description || is_customize_preview()) {
                        ?>
                        <p class="site-description"><?php echo $description; ?></p>
                        <?php
                    }
                }
                ?>
            </div>

            <nav id="site-navigation" class="main-navigation">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span class="screen-reader-text"><?php _e('Primary Menu', 'kagemann-bureau'); ?></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'nav-menu',
                    'container'      => false,
                    'fallback_cb'    => 'kagemann_bureau_default_menu',
                ));
                ?>
            </nav>
        </div>
    </header>

    <div id="content" class="site-content">

<?php
/**
 * Default menu fallback
 */
function kagemann_bureau_default_menu() {
    echo '<ul class="nav-menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . __('Home', 'kagemann-bureau') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/about/')) . '">' . __('About', 'kagemann-bureau') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/services/')) . '">' . __('Services', 'kagemann-bureau') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/contact/')) . '">' . __('Contact', 'kagemann-bureau') . '</a></li>';
    echo '</ul>';
}
?>
