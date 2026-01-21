<?php
/**
 * The template for displaying single posts
 */

if (!defined('ABSPATH')) { exit; }

get_header(); ?>

<main id="main" class="site-main" role="main">
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="single-post-content">
                <div class="container">
                    <div class="section">
                        <header class="entry-header">
                            <h1 class="entry-title"><?php the_title(); ?></h1>
                            <div class="entry-meta">
                                <span class="posted-on">
                                    <time class="entry-date published" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                        <?php echo get_the_date(); ?>
                                    </time>
                                </span>
                                <span class="byline">
                                    by <span class="author vcard">
                                        <a class="url fn n" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                            <?php echo esc_html(get_the_author()); ?>
                                        </a>
                                    </span>
                                </span>
                                <?php if (has_category()) : ?>
                                    <span class="cat-links">
                                        Posted in <?php the_category(', '); ?>
                                    </span>
                                <?php endif; ?>
                                <?php if (has_tag()) : ?>
                                    <span class="tags-links">
                                        Tagged <?php the_tags('', ', ', ''); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </header>

                        <div class="entry-content">
                            <?php
                            the_content();
                            
                            wp_link_pages(array(
                                'before' => '<div class="page-links">',
                                'after'  => '</div>',
                            ));
                            ?>
                        </div>

                        <footer class="entry-footer">
                            <?php
                            // Post navigation
                            $prev_post = get_previous_post();
                            $next_post = get_next_post();
                            
                            if ($prev_post || $next_post) : ?>
                                <nav class="post-navigation">
                                    <div class="nav-links">
                                        <?php if ($prev_post) : ?>
                                            <div class="nav-previous">
                                                <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" rel="prev">
                                                    <span class="nav-subtitle">Previous Post</span>
                                                    <span class="nav-title"><?php echo esc_html(get_the_title($prev_post->ID)); ?></span>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($next_post) : ?>
                                            <div class="nav-next">
                                                <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" rel="next">
                                                    <span class="nav-subtitle">Next Post</span>
                                                    <span class="nav-title"><?php echo esc_html(get_the_title($next_post->ID)); ?></span>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </nav>
                            <?php endif; ?>
                        </footer>
                    </div>
                </div>
            </div>
        </article>

        <?php
        // If comments are open or we have at least one comment, load up the comment template.
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
        ?>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>