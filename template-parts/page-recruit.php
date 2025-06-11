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
  <!-- Hero -->
  <?php get_template_part( 'template-parts/section', 'hero' ); ?>

  <!-- Recruit -->
      <section id="recruit" class="recruit section container">
        <div class="recruit__content text-center py-5">
          <p><?php esc_html_e( '只今準備中です。掲載まで今しばらくお待ちください。', 'sanai-textdomain' ); ?></p>
        </div>
      </section>

  <!-- CTA -->
  <?php get_template_part( 'template-parts/section', 'cta' ); ?>
</main>

<?php
get_footer();
