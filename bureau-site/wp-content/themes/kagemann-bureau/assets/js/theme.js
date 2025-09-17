/**
 * Kagemann Creatives Bureau Theme JavaScript
 *
 * @package KagemannBureau
 * @since 1.0.0
 */

(function($) {
    'use strict';

    // Initialize when document is ready
    $(document).ready(function() {
        initSmoothScrolling();
        initContactForm();
        initAnimations();
        initMobileMenu();
    });

    /**
     * Smooth scrolling for anchor links
     */
    function initSmoothScrolling() {
        $('a[href*="#"]:not([href="#"])').click(function() {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 80
                    }, 1000);
                    return false;
                }
            }
        });
    }

    /**
     * Handle contact form submission
     */
    function initContactForm() {
        $('.contact-form').on('submit', function(e) {
            e.preventDefault();
            
            var $form = $(this);
            var $submitBtn = $form.find('button[type="submit"]');
            var originalText = $submitBtn.text();
            
            // Show loading state
            $submitBtn.text('Sending...').prop('disabled', true);
            
            // Get form data
            var formData = {
                action: 'contact_form',
                name: $form.find('input[name="name"]').val(),
                email: $form.find('input[name="email"]').val(),
                message: $form.find('textarea[name="message"]').val(),
                nonce: kagemannBureau.nonce
            };
            
            // Send AJAX request
            $.ajax({
                url: kagemannBureau.ajaxUrl,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        showMessage('success', 'Message sent successfully! We\'ll get back to you soon.');
                        $form[0].reset();
                    } else {
                        showMessage('error', response.data || 'Failed to send message. Please try again.');
                    }
                },
                error: function() {
                    showMessage('error', 'An error occurred. Please try again.');
                },
                complete: function() {
                    $submitBtn.text(originalText).prop('disabled', false);
                }
            });
        });
    }

    /**
     * Show success/error messages
     */
    function showMessage(type, message) {
        var $message = $('<div class="form-message form-message--' + type + '">' + message + '</div>');
        $('.contact-form').prepend($message);
        
        // Auto-hide after 5 seconds
        setTimeout(function() {
            $message.fadeOut(function() {
                $(this).remove();
            });
        }, 5000);
    }

    /**
     * Initialize scroll animations
     */
    function initAnimations() {
        // Check if element is in viewport
        function isInViewport(element) {
            var elementTop = $(element).offset().top;
            var elementBottom = elementTop + $(element).outerHeight();
            var viewportTop = $(window).scrollTop();
            var viewportBottom = viewportTop + $(window).height();
            
            return elementBottom > viewportTop && elementTop < viewportBottom;
        }

        // Animate elements on scroll
        function animateOnScroll() {
            $('.fade-in, .slide-in-left, .slide-in-right').each(function() {
                if (isInViewport(this) && !$(this).hasClass('visible')) {
                    $(this).addClass('visible');
                }
            });
        }

        // Run on scroll and load
        $(window).on('scroll', animateOnScroll);
        animateOnScroll();
    }

    /**
     * Initialize mobile menu
     */
    function initMobileMenu() {
        // Create mobile menu toggle if it doesn't exist
        if ($('.mobile-menu-toggle').length === 0) {
            $('.site-header').append('<button class="mobile-menu-toggle" aria-label="Toggle mobile menu"><span></span><span></span><span></span></button>');
        }

        // Toggle mobile menu
        $('.mobile-menu-toggle').on('click', function() {
            $(this).toggleClass('active');
            $('.site-navigation').toggleClass('mobile-open');
            $('body').toggleClass('menu-open');
        });

        // Close mobile menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.site-header').length) {
                $('.mobile-menu-toggle').removeClass('active');
                $('.site-navigation').removeClass('mobile-open');
                $('body').removeClass('menu-open');
            }
        });

        // Close mobile menu on window resize
        $(window).on('resize', function() {
            if ($(window).width() > 768) {
                $('.mobile-menu-toggle').removeClass('active');
                $('.site-navigation').removeClass('mobile-open');
                $('body').removeClass('menu-open');
            }
        });
    }

    /**
     * Service package hover effects
     */
    $('.service-package').hover(
        function() {
            $(this).addClass('hovered');
        },
        function() {
            $(this).removeClass('hovered');
        }
    );

    /**
     * Lazy loading for images
     */
    function initLazyLoading() {
        if ('IntersectionObserver' in window) {
            var imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(function(img) {
                imageObserver.observe(img);
            });
        }
    }

    // Initialize lazy loading
    initLazyLoading();

    /**
     * Back to top button
     */
    function initBackToTop() {
        // Create back to top button
        $('body').append('<button class="back-to-top" aria-label="Back to top"><span>↑</span></button>');

        // Show/hide button based on scroll position
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 300) {
                $('.back-to-top').addClass('visible');
            } else {
                $('.back-to-top').removeClass('visible');
            }
        });

        // Scroll to top when clicked
        $('.back-to-top').on('click', function() {
            $('html, body').animate({scrollTop: 0}, 800);
        });
    }

    // Initialize back to top
    initBackToTop();

})(jQuery);
