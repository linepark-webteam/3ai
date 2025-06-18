<?php
/**
 * template-parts/section-cta.php
 * お問い合わせ CTA 用テンプレートパーツ
 *
 * @package Sanai_WP_Theme
 * @since 1.0.0
 */
?>
<section id="contact" class="cta section" aria-label="<?php esc_attr_e( 'お問い合わせ', 'sanai-textdomain' ); ?>">
  <!-- オーバーレイ -->
  <div class="cta__overlay" aria-hidden="true"></div>

  <div class="cta__inner container text-center position-relative">
    <h2 class="cta__title">
      <?php esc_html_e( 'お問い合わせ', 'sanai-textdomain' ); ?>
    </h2>

    <p class="cta__tel">
      <a href="tel:0459512722">
        <i class="bi bi-telephone-fill"></i>
        045-951-2722
      </a>
    </p>

    <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn--cta">
      <?php esc_html_e( 'お問い合わせはこちら', 'sanai-textdomain' ); ?>
    </a>
  </div>
</section>

