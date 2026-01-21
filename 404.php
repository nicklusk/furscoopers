<?php
/**
 * The template for displaying 404 pages (not found)
 */

if (!defined('ABSPATH')) { exit; }

get_header(); ?>

<main id="main" class="site-main" role="main">
    <div class="error-404-content">
        <div class="container">
            <div class="section">
                <div class="error-404-inner">
                    <header class="page-header">
                        <h1 class="page-title"><?php _e('Oops! Page Not Found', 'furscoopers'); ?></h1>
                    </header>

                    <div class="page-content">
                        <div class="error-message">
                            <h2><?php _e('Sorry, we couldn\'t find what you\'re looking for!', 'furscoopers'); ?></h2>
                            <p><?php _e('It looks like nothing was found at this location. Maybe try one of the options below or search for what you\'re looking for.', 'furscoopers'); ?></p>
                        </div>

                        <div class="error-actions">
                            <div class="search-section">
                                <h3><?php _e('Search Our Site', 'furscoopers'); ?></h3>
                                <p><?php _e('Try searching for what you need:', 'furscoopers'); ?></p>
                                <?php get_search_form(); ?>
                            </div>

                            <div class="navigation-section">
                                <h3><?php _e('Quick Navigation', 'furscoopers'); ?></h3>
                                <div class="quick-links">
                                    <a href="<?php echo esc_url(home_url('/')); ?>" class="cta-button">
                                        <?php _e('Go to Homepage', 'furscoopers'); ?>
                                    </a>
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

                            <?php if (function_exists('wp_tag_cloud')) : ?>
                                <div class="tag-cloud-section">
                                    <h3><?php _e('Popular Tags', 'furscoopers'); ?></h3>
                                    <?php
                                    $tag_cloud = wp_tag_cloud(array(
                                        'echo' => false,
                                        'taxonomy' => 'post_tag',
                                        'number' => 20,
                                        'smallest' => 12,
                                        'largest' => 18,
                                        'unit' => 'px'
                                    ));
                                    
                                    if ($tag_cloud) {
                                        echo $tag_cloud;
                                    } else {
                                        echo '<p>' . __('No tags available.', 'furscoopers') . '</p>';
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>

                            <div class="recent-posts-section">
                                <h3><?php _e('Recent Posts', 'furscoopers'); ?></h3>
                                <?php
                                $recent_posts = wp_get_recent_posts(array(
                                    'numberposts' => 5,
                                    'post_status' => 'publish'
                                ));

                                if ($recent_posts) : ?>
                                    <ul class="recent-posts-list">
                                        <?php foreach ($recent_posts as $post) : ?>
                                            <li>
                                                <a href="<?php echo esc_url(get_permalink($post['ID'])); ?>">
                                                    <?php echo esc_html($post['post_title']); ?>
                                                </a>
                                                <span class="post-date"><?php echo get_the_date('', $post['ID']); ?></span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else : ?>
                                    <p><?php _e('No recent posts available.', 'furscoopers'); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="help-section">
                            <h3><?php _e('Need Help?', 'furscoopers'); ?></h3>
                            <p><?php _e('If you\'re looking for our dog waste removal services, you\'re in the right place! Feel free to contact us directly:', 'furscoopers'); ?></p>
                            <div class="contact-info">
                                <p><strong><?php _e('Phone:', 'furscoopers'); ?></strong> <a href="tel:9195376714">(919) 537-6714</a></p>
                                <p><strong><?php _e('Email:', 'furscoopers'); ?></strong> <a href="mailto:info@furscoopers.com">info@furscoopers.com</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>