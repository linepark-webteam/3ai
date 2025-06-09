<?php

/**
 * フッターテンプレート (template-parts/footer.php)
 */
?>
<!-- フッター -->
<footer class="site-footer">
  <div class="footer-inner container">

    <?php
    // フッターナビゲーション
    wp_nav_menu([
      'theme_location'  => 'footer_nav',
      'container'       => 'nav',
      'container_class' => 'footer-nav',
      'menu_class'     => 'footer-nav__list',
      'depth'          => 1,
      // 未設定時はデフォルトのナビゲーションを出力
      'fallback_cb'     => 'sanai_default_global_nav',
    ]);
    ?>

    <!-- 住所（固定テキスト or ウィジェット化してもよい） -->
    <address class="footer-address">〒000-0000 ダミーアドレス</address>
    <p class="copyright">&copy; <?php echo date('Y'); ?> 三愛不動産管理. All Rights Reserved.</p>
  </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>