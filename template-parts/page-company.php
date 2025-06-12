<?php

/**
 * Template Name: 会社概要ページ
 * template-parts/page-company.php
 * 
 * @package Sanai_WP_Theme
 * @since 1.0.0
 */
get_header();
?>

<main id="mainContent">

    <!-- Subhero -->
    <?php get_template_part('template-parts/section', 'subhero'); ?>

    <!-- 代表挨拶 -->
    <?php get_template_part('template-parts/section', 'greeting'); ?>

    <!-- 会社情報テーブル -->
    <?php get_template_part('template-parts/section', 'company-info'); ?>

    <!-- 社屋紹介 -->
    <?php get_template_part('template-parts/section', 'office'); ?>

    <!-- 地図埋め込み -->
    <?php get_template_part('template-parts/section', 'map'); ?>

    <!-- CTA -->
    <?php get_template_part('template-parts/section', 'cta'); ?>

</main>

<?php get_footer(); ?>