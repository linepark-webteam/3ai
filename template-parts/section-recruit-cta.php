<?php
/**
 * template-parts/section-recruit-cta.php
 * Recruit ctaバナー用テンプレートパーツ
 * 
 * @package Sanai_WP_Theme
 * @since 1.0.0
 */
?>
<section id="recruit" class="recruit-banner">
  <div class="recruit-banner__overlay"></div>
  <div class="recruit-banner__inner container text-center">
    <h2 class="recruit-banner__title">
      <?php esc_html_e( '一緒に働きませんか？', 'sanai-textdomain' ); ?>
    </h2>
    <p class="recruit-banner__text">
      <?php esc_html_e( '未経験者歓迎！経験者優遇！まずはご応募ください。', 'sanai-textdomain' ); ?>
    </p>
    <a href="<?php echo esc_url( home_url( '/recruit/' ) ); ?>" class="btn btn--large">
      <?php esc_html_e( '採用情報をみる', 'sanai-textdomain' ); ?>
    </a>
  </div>
</section>
