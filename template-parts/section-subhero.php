<?php
/**
 * template-parts/section-subhero.php
 * Subhero セクション用テンプレートパーツ
 */

// デフォルトの背景は CSS で設定しておく
// CSS: .subhero { background: url("../img/subhero-common-bg.jpg") center/cover no-repeat; }

$inline_style = '';
if ( has_post_thumbnail() ) {
    // アイキャッチがあれば、その URL を取得
    $bg_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
    $inline_style = sprintf(
        'style="background-image: url(%s);"',
        esc_url( $bg_url )
    );
}
?>
<section id="subhero" class="subhero" <?php echo $inline_style; ?>>
  <div class="subhero__overlay"></div>
  <div class="subhero__inner container text-center">
    <h1 class="subhero__title"><?php the_title(); ?></h1>
  </div>
</section>
