  <!-- フッター -->
  <footer class="site-footer">
    <div class="footer-inner container">
      <!-- フッターナビゲーション -->
      <?php
      wp_nav_menu(
        array(
          'theme_location' => 'footer_nav',
          'container'      => 'nav',
          'container_class'=> 'footer-nav',
          'menu_class'     => 'footer-nav__list',
          'fallback_cb'    => false,
          'depth'          => 1,
        )
      );
      ?>

      <!-- 住所（固定テキスト or ウィジェット化してもよい） -->
      <address class="footer-address">〒000-0000 千葉県松戸市根本155-2 ウィズプラス松戸201</address>
      <p class="copyright">&copy; <?php echo date( 'Y' ); ?> 三愛不動産管理. All Rights Reserved.</p>
    </div>
  </footer>

  <?php wp_footer(); ?>
</body>
</html>
