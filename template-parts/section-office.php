<?php
/**
 * template-parts/section-office.php
 * 会社概要 社屋紹介 用テンプレートパーツ
 *
 * @package Sanai_WP_Theme
 * @since 1.0.0
 */
?>

<section class="office section container">
  <h2 class="section-title">
    <?php esc_html_e( '社屋紹介', 'sanai-textdomain' ); ?>
  </h2>
  <div class="office__photo">
    <img
      src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/test.jpg' ); ?>"
      alt="<?php esc_attr_e( '社屋写真', 'sanai-textdomain' ); ?>"
    >
    <p>
      <?php esc_html_e(
        'ダミーテキスト当社社屋はJR○○駅から～。近代的なデザインのオフィスビル内に位置し、周辺には商業施設も充実しています。ダミーテキスト',
        'sanai-textdomain'
      ); ?>
    </p>
  </div>
</section>
