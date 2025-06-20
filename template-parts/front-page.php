<?php

/**
 * フロントページ用テンプレート
 * template-parts/front-page.php
 * 
 * @package Sanai_WP_Theme
 * @since 1.0.0
 */

get_header();
?>

<main>
  <!-- Hero -->
  <?php get_template_part('template-parts/section', 'hero'); ?>

  <!-- Service -->
  <?php get_template_part('template-parts/section', 'service'); ?>

  <!-- Property -->
  <?php get_template_part('template-parts/section', 'property'); ?>

  <!-- Notice -->
  <?php get_template_part('template-parts/section', 'notice'); ?>

  <!-- Recruit -->
  <?php // get_template_part('template-parts/section', 'recruit'); ?>

  <!-- CTA -->
  <?php get_template_part('template-parts/section', 'cta'); ?>
</main>

<?php
get_footer();
