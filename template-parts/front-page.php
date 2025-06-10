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
<main>
  <!-- Hero -->
  <?php get_template_part('template-parts/section', 'hero'); ?>

  <!-- Service -->
  <?php get_template_part('template-parts/section', 'service'); ?>

  <!-- Property -->
  <?php get_template_part('template-parts/section', 'property'); ?>

  <!-- Topics -->
  <?php get_template_part('template-parts/section', 'topics'); ?>

  <!-- Recruit -->
  <?php // get_template_part('template-parts/section', 'recruit'); ?>

  <!-- CTA -->
  <?php get_template_part('template-parts/section', 'cta'); ?>
</main>

</main>

<?php
get_footer();
