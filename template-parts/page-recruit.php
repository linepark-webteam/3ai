<?php

/**
 * Template Name: 採用ページ
 * template-parts/page-recruit.php
 * 
 * @package Sanai_WP_Theme
 * @since 1.0.0
 */

get_header();
?>

<main>
  <!-- Subhero -->
  <?php get_template_part( 'template-parts/section', 'subhero' ); ?>

  <!-- Recruit -->
  <?php get_template_part('template-parts/section', 'recruit'); ?>

  <!-- CTA -->
  <?php get_template_part('template-parts/section', 'cta'); ?>
</main>

<?php
get_footer();
