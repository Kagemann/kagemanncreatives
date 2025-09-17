<?php
/**
 * The footer template
 *
 * @package KagemannBureau
 * @since 1.0.0
 */
?>

    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-widgets">
                    <?php if (is_active_sidebar('footer-widgets')) : ?>
                        <?php dynamic_sidebar('footer-widgets'); ?>
                    <?php else : ?>
                        <div class="footer-widget">
                            <h3><?php _e('Kagemann Creatives', 'kagemann-bureau'); ?></h3>
                            <p><?php _e('Professional web development and digital marketing services for growing businesses.', 'kagemann-bureau'); ?></p>
                        </div>
                        
                        <div class="footer-widget">
                            <h3><?php _e('Quick Links', 'kagemann-bureau'); ?></h3>
                            <ul>
                                <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Home', 'kagemann-bureau'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/about/')); ?>"><?php _e('About', 'kagemann-bureau'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/services/')); ?>"><?php _e('Services', 'kagemann-bureau'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php _e('Contact', 'kagemann-bureau'); ?></a></li>
                            </ul>
                        </div>
                        
                        <div class="footer-widget">
                            <h3><?php _e('Contact Info', 'kagemann-bureau'); ?></h3>
                            <p>
                                <?php if (get_theme_mod('bureau_phone')) : ?>
                                    <strong><?php _e('Phone:', 'kagemann-bureau'); ?></strong> <?php echo esc_html(get_theme_mod('bureau_phone')); ?><br>
                                <?php endif; ?>
                                <strong><?php _e('Email:', 'kagemann-bureau'); ?></strong> <?php echo esc_html(get_theme_mod('bureau_contact_email', get_option('admin_email'))); ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="footer-bottom">
                    <div class="footer-navigation">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer',
                            'menu_class'     => 'footer-menu',
                            'container'      => false,
                            'depth'          => 1,
                        ));
                        ?>
                    </div>
                    
                    <div class="site-info">
                        <p>
                            &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. 
                            <?php _e('All rights reserved.', 'kagemann-bureau'); ?>
                        </p>
                        <p class="powered-by">
                            <?php _e('Powered by', 'kagemann-bureau'); ?> 
                            <a href="https://wordpress.org/" target="_blank" rel="noopener">WordPress</a> 
                            <?php _e('and', 'kagemann-bureau'); ?> 
                            <a href="https://kagemanncreatives.com/" target="_blank" rel="noopener">Kagemann Creatives</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
