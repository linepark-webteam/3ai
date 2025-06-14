<?php

/**
 * Template Name: 事業内容ページ
 * template-parts/page-services.php
 * 
 * @package Sanai_WP_Theme
 * @since 1.0.0
 */
get_header();
?>

<main id="mainContent" class="page-services">

    <!-- Subhero -->
    <?php get_template_part('template-parts/section', 'subhero'); ?>

    <!-- Overview -->
    <?php get_template_part('template-parts/section-services', 'overview'); ?>

    <!-- Navigation -->
    <?php get_template_part('template-parts/section-services', 'nav'); ?>

    <!-- Service Details -->
    <?php get_template_part('template-parts/section-services', 'details'); ?>

    <!-- CTA -->
    <?php get_template_part('template-parts/section', 'cta'); ?>

</main>

<?php get_footer(); ?>