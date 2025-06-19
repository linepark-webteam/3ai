<?php
/**
 * Template Name: 事業内容ページ
 *
 * @package Sanai_WP_Theme
 * @since 1.0.0
 */
get_header();
?>

<main id="mainContent" class="page-services">

	<?php get_template_part( 'template-parts/section', 'subhero' ); ?>

	<?php get_template_part( 'template-parts/section-services', 'overview' ); ?>

	<?php get_template_part( 'template-parts/section-services', 'nav' ); ?>

	<?php get_template_part( 'template-parts/section-services', 'details' ); ?>

	<?php get_template_part( 'template-parts/section', 'cta' ); ?>

</main>

<?php
// ──────────────────────────────────────────────
// Intersection Observer & Smooth-Scroll
// ──────────────────────────────────────────────
wp_enqueue_script(
	'sanai-services',
	get_template_directory_uri() . '/assets/js/services.js',
	array(),
	null,
	true
);
get_footer();
