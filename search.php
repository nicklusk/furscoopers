<?php
/**
 * The template for displaying search results pages
 */

if (!defined('ABSPATH')) { exit; }

get_header(); ?>

<main id="main" class="site-main" role="main">
    <div class="search-results-content">
        <div class="container">
            <div class="section">
                <header class="page-header">
                    <?php if (have_posts()) : ?>
                        <h1 class="page-title">
                            <?php
                            /* translators: %s: search query. */
                            printf(esc_html__('Search Results for: %s', 'furscoopers'), '<span>' . get_search_query() . '</span>');
                            ?>
                        </h1>
                        <p class="search-results-count">
                            <?php
                            global $wp_query;
                            $total = $wp_query->found_posts;
                            /* translators: %d: number of search results. */
                            printf(_n('%d result found', '%d results found', $total, 'furscoopers'), $total);
                            ?>
                        </p>
                    <?php else : ?>
                        <h1 class="page-title">
                            <?php
                            /* translators: %s: search query. */
                            printf(esc_html__('Nothing found for: %s', 'furscoopers'), '<span>' . get_search_query() . '</span>');
                            ?>
                        </h1>
                    <?php endif; ?>
                </header>

                <?php if (have_posts()) : ?>
                    <div class="search-form-container">
                        <p><?php _e('Search again:', 'furscoopers'); ?></p>
                        <?php get_search_form(); ?>
                    </div>

                    <div class="search-results">
                        <?php while (have_posts()) : the_post(); ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class('search-result-item'); ?>>
                                <header class="entry-header">
                                    <h2 class="entry-title">
                                        <a href="<?php the_permalink(); ?>" rel="bookmark">
                                            <?php the_title(); ?>
                                        </a>
                                    </h2>
                                    <div class="entry-meta">
                                        <span class="post-type">
                                            <?php
                                            $post_type_obj = get_post_type_object(get_post_type());
                                            if ($post_type_obj) {
                                                echo esc_html($post_type_obj->labels->singular_name);
                                            }
                                            ?>
                                        </span>
                                        <span class="posted-on">
                                            <time class="entry-date published" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                                <?php echo get_the_date(); ?>
                                            </time>
                                        </span>
                                        <?php if (get_post_type() === 'post') : ?>
                                            <span class="byline">
                                                by <span class="author vcard">
                                                    <a class="url fn n" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                                        <?php echo esc_html(get_the_author()); ?>
                                                    </a>
                                                </span>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </header>

                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="post-thumbnail">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('thumbnail'); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>

                                <div class="entry-summary">
                                    <?php
                                    // Show excerpt with search term highlighting
                                    $excerpt = get_the_excerpt();
                                    $search_query = get_search_query();
                                    
                                    if ($search_query && $excerpt) {
                                        $highlighted_excerpt = wp_kses(
                                            preg_replace('/(' . preg_quote($search_query, '/') . ')/i', '<mark>$1</mark>', $excerpt),
                                            array('mark' => array())
                                        );
                                        echo $highlighted_excerpt;
                                    } else {
                                        the_excerpt();
                                    }
                                    ?>
                                </div>

                                <footer class="entry-footer">
                                    <a href="<?php the_permalink(); ?>" class="read-more">
                                        <?php
                                        if (get_post_type() === 'page') {
                                            _e('View Page', 'furscoopers');
                                        } else {
                                            _e('Read More', 'furscoopers');
                                        }
                                        ?>
                                        <span class="screen-reader-text">about <?php the_title(); ?></span>
                                    </a>
                                </footer>
                            </article>
                        <?php endwhile; ?>
                    </div>

                    <?php
                    // Pagination
                    the_posts_pagination(array(
                        'mid_size'  => 2,
                        'prev_text' => __('Previous', 'furscoopers'),
                        'next_text' => __('Next', 'furscoopers'),
                    ));
                    ?>

                <?php else : ?>
                    <div class="no-results">
                        <div class="search-form-container">
                            <p><?php _e('Try searching for something else:', 'furscoopers'); ?></p>
                            <?php get_search_form(); ?>
                        </div>

                        <div class="search-suggestions">
                            <h3><?php _e('Search Suggestions', 'furscoopers'); ?></h3>
                            <ul>
                                <li><?php _e('Make sure all words are spelled correctly', 'furscoopers'); ?></li>
                                <li><?php _e('Try different keywords', 'furscoopers'); ?></li>
                                <li><?php _e('Try more general keywords', 'furscoopers'); ?></li>
                                <li><?php _e('Try fewer keywords', 'furscoopers'); ?></li>
                            </ul>
                        </div>

                        <div class="helpful-links">
                            <h3><?php _e('Looking for our services?', 'furscoopers'); ?></h3>
                            <div class="service-links">
                                <a href="<?php echo esc_url(home_url('/#services')); ?>" class="cta-button">
                                    <?php _e('Our Services', 'furscoopers'); ?>
                                </a>
                                <a href="<?php echo esc_url(home_url('/#pricing')); ?>" class="cta-button">
                                    <?php _e('View Pricing', 'furscoopers'); ?>
                                </a>
                                <a href="<?php echo esc_url(home_url('/#contact')); ?>" class="cta-button">
                                    <?php _e('Contact Us', 'furscoopers'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>