<?php
/**
 * template-parts/content-notice.php
 * カスタム投稿タイプ notice のループ用パーツ
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<li class="notice__item">
  <time class="notice__date"
        datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>">
    <?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?>
  </time>
  <span class="notice__title"><?php the_title(); ?></span>
</li>
