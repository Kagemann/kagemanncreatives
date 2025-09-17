/**
 * Frontend JavaScript - {{CLIENT_TITLE}}
 * 
 * This file contains JavaScript functionality for the frontend of the website.
 * It includes accessibility enhancements, performance optimizations, and
 * interactive features.
 * 
 * @package {{CLIENT_SLUG}}
 * @since 1.0.0
 */

(function($) {
    'use strict';

    // Wait for DOM to be ready
    $(document).ready(function() {
        
        // Initialize all functionality
        initAccessibility();
        initPerformance();
        initInteractions();
        initForms();
        initAnalytics();
        
    });

    /**
     * Accessibility enhancements
     */
    function initAccessibility() {
        
        // Skip link functionality
        $('.skip-link').on('click', function(e) {
            var target = $(this).attr('href');
            if (target && target !== '#') {
                $(target).attr('tabindex', '-1').focus();
            }
        });
        
        // Keyboard navigation for dropdowns
        $('.menu-item-has-children > a').on('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                $(this).next('.sub-menu').toggle();
            }
        });
        
        // Focus management for modals
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                $('.modal:visible').hide();
                $('.modal:visible').attr('aria-hidden', 'true');
            }
        });
        
        // Announce dynamic content changes
        function announceToScreenReader(message) {
            var announcement = $('<div>', {
                'aria-live': 'polite',
                'aria-atomic': 'true',
                'class': 'screen-reader-text',
                'text': message
            });
            $('body').append(announcement);
            setTimeout(function() {
                announcement.remove();
            }, 1000);
        }
        
        // Make announcements available globally
        window.announceToScreenReader = announceToScreenReader;
        
    }

    /**
     * Performance optimizations
     */
    function initPerformance() {
        
        // Lazy load images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
        
        // Preload critical resources
        function preloadResource(href, as) {
            const link = document.createElement('link');
            link.rel = 'preload';
            link.href = href;
            link.as = as;
            document.head.appendChild(link);
        }
        
        // Preload hero images
        $('.hero-image').each(function() {
            const src = $(this).attr('src');
            if (src) {
                preloadResource(src, 'image');
            }
        });
        
        // Debounce scroll events
        let scrollTimeout;
        $(window).on('scroll', function() {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(function() {
                // Handle scroll events here
                updateScrollPosition();
            }, 100);
        });
        
        function updateScrollPosition() {
            const scrollTop = $(window).scrollTop();
            const windowHeight = $(window).height();
            const documentHeight = $(document).height();
            
            // Update progress bar if exists
            const progress = (scrollTop / (documentHeight - windowHeight)) * 100;
            $('.scroll-progress').css('width', progress + '%');
            
            // Show/hide back to top button
            if (scrollTop > 300) {
                $('.back-to-top').addClass('visible');
            } else {
                $('.back-to-top').removeClass('visible');
            }
        }
        
    }

    /**
     * Interactive features
     */
    function initInteractions() {
        
        // Smooth scrolling for anchor links
        $('a[href*="#"]:not([href="#"])').on('click', function(e) {
            const target = $(this.getAttribute('href'));
            if (target.length) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - 80
                }, 800, 'swing');
                
                // Update focus for accessibility
                target.attr('tabindex', '-1').focus();
            }
        });
        
        // Back to top button
        $('.back-to-top').on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, 800, 'swing');
        });
        
        // Mobile menu toggle
        $('.mobile-menu-toggle').on('click', function(e) {
            e.preventDefault();
            const menu = $('.mobile-menu');
            const isExpanded = $(this).attr('aria-expanded') === 'true';
            
            $(this).attr('aria-expanded', !isExpanded);
            menu.toggleClass('open');
            
            // Announce to screen readers
            if (window.announceToScreenReader) {
                window.announceToScreenReader(
                    isExpanded ? 'Menu closed' : 'Menu opened'
                );
            }
        });
        
        // Search toggle
        $('.search-toggle').on('click', function(e) {
            e.preventDefault();
            const searchForm = $('.search-form');
            const isVisible = searchForm.is(':visible');
            
            if (isVisible) {
                searchForm.slideUp();
            } else {
                searchForm.slideDown();
                searchForm.find('input[type="search"]').focus();
            }
        });
        
        // Tab functionality
        $('.tab-trigger').on('click', function(e) {
            e.preventDefault();
            const target = $(this).attr('href');
            const tabContent = $(target);
            
            // Update active states
            $('.tab-trigger').removeClass('active');
            $('.tab-content').removeClass('active');
            
            $(this).addClass('active');
            tabContent.addClass('active');
            
            // Announce to screen readers
            if (window.announceToScreenReader) {
                window.announceToScreenReader('Tab changed to ' + $(this).text());
            }
        });
        
    }

    /**
     * Form enhancements
     */
    function initForms() {
        
        // Contact form handling
        $('.contact-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const formData = form.serialize();
            const submitButton = form.find('button[type="submit"]');
            const originalText = submitButton.text();
            
            // Show loading state
            submitButton.prop('disabled', true).text('Sending...');
            
            // Submit via AJAX
            $.ajax({
                url: {{CLIENT_SLUG}}_ajax.ajax_url,
                type: 'POST',
                data: formData + '&action=contact_form&nonce=' + {{CLIENT_SLUG}}_ajax.nonce,
                success: function(response) {
                    if (response.success) {
                        form.html('<div class="success-message">' + response.data + '</div>');
                        if (window.announceToScreenReader) {
                            window.announceToScreenReader('Form submitted successfully');
                        }
                    } else {
                        form.prepend('<div class="error-message">' + response.data + '</div>');
                        if (window.announceToScreenReader) {
                            window.announceToScreenReader('Form submission failed');
                        }
                    }
                },
                error: function() {
                    form.prepend('<div class="error-message">' + {{CLIENT_SLUG}}_ajax.strings.error + '</div>');
                    if (window.announceToScreenReader) {
                        window.announceToScreenReader('Form submission failed');
                    }
                },
                complete: function() {
                    submitButton.prop('disabled', false).text(originalText);
                }
            });
        });
        
        // Form validation
        $('input[required], textarea[required], select[required]').on('blur', function() {
            const field = $(this);
            const value = field.val().trim();
            
            if (value === '') {
                field.addClass('error');
                field.attr('aria-invalid', 'true');
            } else {
                field.removeClass('error');
                field.attr('aria-invalid', 'false');
            }
        });
        
        // Email validation
        $('input[type="email"]').on('blur', function() {
            const field = $(this);
            const email = field.val().trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email && !emailRegex.test(email)) {
                field.addClass('error');
                field.attr('aria-invalid', 'true');
            } else {
                field.removeClass('error');
                field.attr('aria-invalid', 'false');
            }
        });
        
        // Clear error states on input
        $('input, textarea, select').on('input', function() {
            $(this).removeClass('error');
            $(this).attr('aria-invalid', 'false');
        });
        
    }

    /**
     * Analytics and tracking
     */
    function initAnalytics() {
        
        // Track form submissions
        $('.contact-form').on('submit', function() {
            if (typeof gtag !== 'undefined') {
                gtag('event', 'form_submit', {
                    'event_category': 'engagement',
                    'event_label': 'contact_form'
                });
            }
        });
        
        // Track button clicks
        $('.wp-block-button__link, .button').on('click', function() {
            if (typeof gtag !== 'undefined') {
                const buttonText = $(this).text().trim();
                gtag('event', 'click', {
                    'event_category': 'engagement',
                    'event_label': buttonText
                });
            }
        });
        
        // Track external links
        $('a[href^="http"]:not([href*="' + window.location.hostname + '"])').on('click', function() {
            if (typeof gtag !== 'undefined') {
                gtag('event', 'click', {
                    'event_category': 'outbound',
                    'event_label': $(this).attr('href')
                });
            }
        });
        
        // Track scroll depth
        let scrollDepth = 0;
        $(window).on('scroll', function() {
            const scrollTop = $(window).scrollTop();
            const windowHeight = $(window).height();
            const documentHeight = $(document).height();
            const currentDepth = Math.round((scrollTop / (documentHeight - windowHeight)) * 100);
            
            if (currentDepth > scrollDepth && currentDepth % 25 === 0) {
                scrollDepth = currentDepth;
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'scroll', {
                        'event_category': 'engagement',
                        'event_label': scrollDepth + '%'
                    });
                }
            }
        });
        
    }

    /**
     * Utility functions
     */
    
    // Debounce function
    function debounce(func, wait, immediate) {
        let timeout;
        return function() {
            const context = this;
            const args = arguments;
            const later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }
    
    // Throttle function
    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }
    
    // Check if element is in viewport
    function isInViewport(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }
    
    // Make utility functions available globally
    window.debounce = debounce;
    window.throttle = throttle;
    window.isInViewport = isInViewport;

})(jQuery);
