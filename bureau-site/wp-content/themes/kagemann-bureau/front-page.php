<?php
/**
 * The front page template
 *
 * @package KagemannBureau
 * @since 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    
    <!-- Hero Section -->
    <section class="bureau-hero">
        <div class="container">
            <h1 class="hero-title"><?php _e('Professional Web Development & Digital Marketing', 'kagemann-bureau'); ?></h1>
            <p class="hero-subtitle"><?php _e('We help growing businesses establish their online presence with modern, performance-optimized websites and strategic digital marketing.', 'kagemann-bureau'); ?></p>
            <div class="hero-actions">
                <a href="#services" class="wp-block-button__link"><?php _e('View Our Services', 'kagemann-bureau'); ?></a>
                <a href="#contact" class="wp-block-button__link wp-block-button__link--secondary"><?php _e('Get Started Today', 'kagemann-bureau'); ?></a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="bureau-services">
        <div class="container">
            <h2 class="section-title"><?php _e('Our Service Packages', 'kagemann-bureau'); ?></h2>
            <p class="section-subtitle"><?php _e('Choose the package that best fits your business needs and budget.', 'kagemann-bureau'); ?></p>
            
            <div class="services-grid">
                <!-- Starter Package -->
                <div class="service-package">
                    <h3><?php _e('Starter', 'kagemann-bureau'); ?></h3>
                    <div class="price">€2,500</div>
                    <div class="price-period"><?php _e('one-time', 'kagemann-bureau'); ?></div>
                    <ul>
                        <li><?php _e('5-page responsive website', 'kagemann-bureau'); ?></li>
                        <li><?php _e('Mobile-optimized design', 'kagemann-bureau'); ?></li>
                        <li><?php _e('Contact form integration', 'kagemann-bureau'); ?></li>
                        <li><?php _e('Basic SEO setup', 'kagemann-bureau'); ?></li>
                        <li><?php _e('1 month support', 'kagemann-bureau'); ?></li>
                    </ul>
                    <a href="#contact" class="wp-block-button__link"><?php _e('Get Started', 'kagemann-bureau'); ?></a>
                </div>

                <!-- Growth Package -->
                <div class="service-package featured">
                    <h3><?php _e('Growth', 'kagemann-bureau'); ?></h3>
                    <div class="price">€4,500</div>
                    <div class="price-period"><?php _e('one-time', 'kagemann-bureau'); ?></div>
                    <ul>
                        <li><?php _e('10-page responsive website', 'kagemann-bureau'); ?></li>
                        <li><?php _e('Custom design & branding', 'kagemann-bureau'); ?></li>
                        <li><?php _e('Advanced contact forms', 'kagemann-bureau'); ?></li>
                        <li><?php _e('SEO optimization', 'kagemann-bureau'); ?></li>
                        <li><?php _e('Google Analytics setup', 'kagemann-bureau'); ?></li>
                        <li><?php _e('3 months support', 'kagemann-bureau'); ?></li>
                    </ul>
                    <a href="#contact" class="wp-block-button__link"><?php _e('Most Popular', 'kagemann-bureau'); ?></a>
                </div>

                <!-- Pro Package -->
                <div class="service-package">
                    <h3><?php _e('Pro', 'kagemann-bureau'); ?></h3>
                    <div class="price">€7,500</div>
                    <div class="price-period"><?php _e('one-time', 'kagemann-bureau'); ?></div>
                    <ul>
                        <li><?php _e('Unlimited pages', 'kagemann-bureau'); ?></li>
                        <li><?php _e('E-commerce integration', 'kagemann-bureau'); ?></li>
                        <li><?php _e('Custom functionality', 'kagemann-bureau'); ?></li>
                        <li><?php _e('Advanced SEO & marketing', 'kagemann-bureau'); ?></li>
                        <li><?php _e('Performance optimization', 'kagemann-bureau'); ?></li>
                        <li><?php _e('6 months support', 'kagemann-bureau'); ?></li>
                    </ul>
                    <a href="#contact" class="wp-block-button__link"><?php _e('Go Pro', 'kagemann-bureau'); ?></a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="bureau-about">
        <div class="container">
            <h2 class="section-title"><?php _e('About Kagemann Creatives', 'kagemann-bureau'); ?></h2>
            <div class="about-content">
                <p><?php _e('We are a small web bureau specializing in creating modern, performance-optimized websites for growing businesses. Our focus is on delivering high-quality solutions that help our clients establish a strong online presence.', 'kagemann-bureau'); ?></p>
                <p><?php _e('With years of experience in web development and digital marketing, we understand what it takes to create websites that not only look great but also perform exceptionally well across all devices and platforms.', 'kagemann-bureau'); ?></p>
                <p><?php _e('Our approach combines technical expertise with creative design to deliver solutions that meet your business goals and exceed your expectations.', 'kagemann-bureau'); ?></p>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="bureau-contact">
        <div class="container">
            <h2 class="section-title"><?php _e('Get In Touch', 'kagemann-bureau'); ?></h2>
            <p class="section-subtitle"><?php _e('Ready to start your project? Contact us today for a free consultation.', 'kagemann-bureau'); ?></p>
            
            <div class="contact-grid">
                <div class="contact-info">
                    <h3><?php _e('Contact Information', 'kagemann-bureau'); ?></h3>
                    <p>
                        <strong><?php _e('Email:', 'kagemann-bureau'); ?></strong><br>
                        <a href="mailto:<?php echo esc_attr(get_theme_mod('bureau_contact_email', get_option('admin_email'))); ?>">
                            <?php echo esc_html(get_theme_mod('bureau_contact_email', get_option('admin_email'))); ?>
                        </a>
                    </p>
                    <?php if (get_theme_mod('bureau_phone')) : ?>
                        <p>
                            <strong><?php _e('Phone:', 'kagemann-bureau'); ?></strong><br>
                            <a href="tel:<?php echo esc_attr(get_theme_mod('bureau_phone')); ?>">
                                <?php echo esc_html(get_theme_mod('bureau_phone')); ?>
                            </a>
                        </p>
                    <?php endif; ?>
                    <p>
                        <strong><?php _e('Response Time:', 'kagemann-bureau'); ?></strong><br>
                        <?php _e('We typically respond within 24 hours', 'kagemann-bureau'); ?>
                    </p>
                </div>
                
                <div class="contact-form">
                    <h3><?php _e('Send us a Message', 'kagemann-bureau'); ?></h3>
                    <form class="contact-form" action="#" method="post">
                        <div class="form-group">
                            <label for="contact-name"><?php _e('Name', 'kagemann-bureau'); ?> *</label>
                            <input type="text" id="contact-name" name="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="contact-email"><?php _e('Email', 'kagemann-bureau'); ?> *</label>
                            <input type="email" id="contact-email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="contact-message"><?php _e('Message', 'kagemann-bureau'); ?> *</label>
                            <textarea id="contact-message" name="message" rows="5" required></textarea>
                        </div>
                        
                        <button type="submit"><?php _e('Send Message', 'kagemann-bureau'); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
