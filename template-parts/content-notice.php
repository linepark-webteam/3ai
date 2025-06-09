<?php
/**
 * template-parts/content-notice.php
 * カスタム投稿タイプ notice のループ用パーツ
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<li class="topics__item">
  <time class="topics__date"
        datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>">
    <?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?>
  </time>
  <span class="topics__title"><?php the_title(); ?></span>
</li>
