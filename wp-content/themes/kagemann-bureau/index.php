<?php
/**
 * The main template file
 *
 * @package KagemannBureau
 * @since 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="posts-container">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
                        <header class="entry-header">
                            <?php if (is_singular()) : ?>
                                <h1 class="entry-title"><?php the_title(); ?></h1>
                            <?php else : ?>
                                <h2 class="entry-title">
                                    <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                                </h2>
                            <?php endif; ?>
                            
                            <?php if ('post' === get_post_type()) : ?>
                                <div class="entry-meta">
                                    <span class="posted-on">
                                        <time class="entry-date published" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                            <?php echo esc_html(get_the_date()); ?>
                                        </time>
                                    </span>
                                    <span class="byline">
                                        by <span class="author vcard"><?php the_author(); ?></span>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </header>

                        <?php if (has_post_thumbnail() && !is_singular()) : ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('large'); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="entry-content">
                            <?php
                            if (is_singular()) {
                                the_content();
                            } else {
                                the_excerpt();
                            }
                            ?>
                        </div>

                        <?php if (!is_singular()) : ?>
                            <footer class="entry-footer">
                                <a href="<?php the_permalink(); ?>" class="read-more">
                                    Read More <span class="screen-reader-text">about <?php the_title(); ?></span>
                                </a>
                            </footer>
                        <?php endif; ?>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php
            // Pagination
            the_posts_pagination(array(
                'prev_text' => __('Previous', 'kagemann-bureau'),
                'next_text' => __('Next', 'kagemann-bureau'),
            ));
            ?>

        <?php else : ?>
            <div class="no-posts">
                <h2><?php _e('Nothing Found', 'kagemann-bureau'); ?></h2>
                <p><?php _e('It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'kagemann-bureau'); ?></p>
                <?php get_search_form(); ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
