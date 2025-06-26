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
  <div id="drawerOverlay" class="drawer-overlay" hidden></div>
  <header class="site-header">
    <div class="header-inner container-fluid">

      <!-- ── Logo ──────────────────────────── -->
      <?php if (function_exists('the_custom_logo') && has_custom_logo()) : ?>
        <div class="logo"><?php the_custom_logo(); ?></div>
      <?php else : ?>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
          <img
            src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/logo.webp'); ?>"
            alt="<?php bloginfo('name'); ?>" />
        </a>
      <?php endif; ?>

      <!-- ── Menu Toggle ───────────────────── -->
      <div class="menu-toggle" role="button" tabindex="0">
        <span class="menu-toggle__text" id="menuLabel">Menu</span>
        <button
          id="hamburgerBtn"
          class="hamburger"
          aria-label="<?php esc_attr_e('メニューを開く', 'sanai-textdomain'); ?>"
          aria-controls="drawerNav"
          aria-expanded="false">
          <span class="hamburger__line"></span>
          <span class="hamburger__line"></span>
        </button>
      </div>

      <!-- ── Drawer Navigation  ※PC/SP 共通──────── -->
      <?php
      wp_nav_menu([
        'theme_location'  => 'global_nav',
        'container'       => 'nav',
        'container_class' => 'drawer-nav',          // ← 統一クラス
        'container_id'    => 'drawerNav',
        'menu_class'      => 'drawer-nav__list',
        'depth'           => 1,
        'fallback_cb'     => 'sanai_default_drawer_nav',
      ]);
      ?>

    </div><!-- /.header-inner -->
  </header>