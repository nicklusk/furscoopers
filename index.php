<?php get_header(); ?>
<div class="section">
  <h2><?php the_title(); ?></h2>
  <div class="section-inner">
    <?php while (have_posts()) : the_post(); the_content(); endwhile; ?>
  </div>
</div>
<?php get_footer(); ?>