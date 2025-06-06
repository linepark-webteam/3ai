<?php
// index.php（最終的なフォールバックテンプレート）

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ヘッダー部分を読み込む
get_header(); 
?>

<main class="site-main container">
  <?php
  if ( have_posts() ) :
      // 投稿ループ部分
      get_template_part( 'template-parts/content', 'loop' );

  else :
      // 投稿がないときのテンプレート（必要ならこちらもサブフォルダ化可）
      echo '<p>' . esc_html__( '投稿が見つかりません。', 'sanai-textdomain' ) . '</p>';
  endif;
  ?>
</main>

<?php
// フッター部分を読み込む
get_footer();
