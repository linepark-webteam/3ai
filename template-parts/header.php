<?php

/**
 * ヘッダーテンプレート (template-parts/header.php)
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <!-- ヘッダー -->
  <header class="site-header">
    <div class="header-inner container">
      <!-- サイトロゴ（カスタムロゴを有効化している場合は以下のように出力可能） -->
      <?php if (function_exists('the_custom_logo') && has_custom_logo()) : ?>
        <div class="logo"><?php the_custom_logo(); ?></div>
      <?php else : ?>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
          <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/logo.png" alt="<?php bloginfo('name'); ?>" />
        </a>
      <?php endif; ?>

      <?php
      // グローバルナビゲーション（PC用）
      wp_nav_menu([
        'theme_location'  => 'global_nav',
        'container'       => 'nav',
        'container_class' => 'global-nav',
        'menu_class'      => 'global-nav__list',
        'depth'           => 1,
        // メニュー未設定時にはデフォルトの「サービス…」リストを出力
        'fallback_cb'     => 'sanai_default_global_nav',
      ]);
      ?>

      <!-- ハンバーガーメニュー -->
      <button class="hamburger" aria-label="メニューを開く">
        <span class="hamburger__line"></span>
        <span class="hamburger__line"></span>
        <span class="hamburger__line"></span>
      </button>

      <?php
      // モバイルメニュー
      wp_nav_menu([
        'theme_location'  => 'global_nav',
        'container'       => 'nav',
        'container_class' => 'mobile-nav',
        'menu_class'      => 'mobile-nav__list',
        'depth'           => 1,
        'fallback_cb'     => 'sanai_default_mobile_nav',
      ]);
      ?>
    </div>
  </header>