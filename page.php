<?php
/**
 * The template for displaying all pages
 * This is the template that displays all pages by default.
 */

if (!defined('ABSPATH')) { exit; }

get_header(); ?>

<main id="main" class="site-main" role="main">
    <?php while (have_posts()) : the_post(); ?>
        <div class="page-content">
            <div class="container">
                <?php
                // Check if this is a WooCommerce page
                if (function_exists('is_woocommerce') && (is_woocommerce() || is_cart() || is_checkout() || is_account_page())) {
                    // For WooCommerce pages, just display the content without extra wrapper
                    the_content();
                } else {
                    // For regular pages, use the theme's styling
                    ?>
                    <div class="section">
                        <h1 class="page-title"><?php the_title(); ?></h1>
                        <div class="page-content-inner">
                            <?php the_content(); ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>