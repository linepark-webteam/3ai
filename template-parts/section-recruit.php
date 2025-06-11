<?php
/**
 * template-parts/section-recruit.php
 * 採用情報セクション（固定ページのコンテンツ有無で表示を切り替え）
 */

$post_content = get_post_field( 'post_content', get_the_ID() );
// HTMLタグや空白だけの場合も「空」とみなす
$trimmed_content = trim( wp_strip_all_tags( $post_content ) );
?>
<section id="recruit" class="recruit section container">
  <div class="recruit__content">
    <?php if ( $trimmed_content !== '' ) : ?>
      <?php
      // 本文がある場合はそのまま出力
      while ( have_posts() ) {
        the_post();
        the_content();
      }
      ?>
    <?php else : ?>
      <?php
      // 本文が空の場合は「準備中」文言を出力
      ?>
      <p class="text-center py-5">
        <?php esc_html_e( '只今準備中です。掲載まで今しばらくお待ちください。', 'sanai-textdomain' ); ?>
      </p>
    <?php endif; ?>
  </div>
</section>
