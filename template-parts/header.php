  <?php
// header.php
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <!-- ヘッダー -->
  <header class="site-header">
    <div class="header-inner container">
      <!-- サイトロゴ（カスタムロゴを有効化している場合は以下のように出力可能） -->
      <?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) : ?>
        <div class="logo"><?php the_custom_logo(); ?></div>
      <?php else : ?>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/logo.png" alt="<?php bloginfo( 'name' ); ?>" />
        </a>
      <?php endif; ?>

      <!-- グローバルナビゲーション（PC用） -->
      <?php
      wp_nav_menu(
        array(
          'theme_location' => 'global_nav',
          'container'      => 'nav',
          'container_class'=> 'global-nav',
          'menu_class'     => 'global-nav__list',
          'fallback_cb'    => false,
          'depth'          => 1,
          'link_before'    => '', 
          'link_after'     => '',
        )
      );
      ?>

      <!-- ハンバーガーメニュー -->
      <button class="hamburger" aria-label="メニューを開く">
        <span class="hamburger__line"></span>
        <span class="hamburger__line"></span>
        <span class="hamburger__line"></span>
      </button>

      <!-- モバイルメニュー -->
      <?php
      // 例として同じグローバルメニューをモバイルメニューとして流用
      wp_nav_menu(
        array(
          'theme_location' => 'global_nav',
          'container'      => 'nav',
          'container_class'=> 'mobile-nav',
          'menu_class'     => 'mobile-nav__list',
          'fallback_cb'    => false,
          'depth'          => 1,
        )
      );
      ?>
    </div>
  </header>
