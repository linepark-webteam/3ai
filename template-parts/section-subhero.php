<?php
/**
 * template-parts/section-subhero.php
 * Subhero セクション用テンプレートパーツ
 */

// アイキャッチ画像があればその URL、なければ共通の背景画像を指定
if ( has_post_thumbnail() ) {
    $bg_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
} else {
    $bg_url = get_template_directory_uri() . '/assets/img/subhero-common-bg.jpg';
}
?>
<section
  id="subhero"
  class="subhero"
  style="background-image: url('<?php echo esc_url( $bg_url ); ?>');"
>
  <div class="subhero__overlay"></div>
  <div class="subhero__inner container text-center">
    <h1 class="subhero__title"><?php the_title(); ?></h1>
  </div>
</section>
