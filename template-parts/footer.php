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
      'menu_class'      => 'footer-nav__list',
      'depth'           => 1,
      // 未設定時はデフォルトのナビゲーションを出力
      'fallback_cb'     => 'sanai_default_global_nav',
    ]);
    ?>

    <!-- 会社情報 -->
    <div class="footer-company">
      <p>免許番号：神奈川県知事（7）第21620号</p>
      <address>
        〒241-0022<br>
        横浜市旭区鶴ヶ峰2丁目2-3<br>
        TEL：<a href="tel:045-951-2722">045-951-2722</a>　FAX：045-951-2725
      </address>
      <p>営業時間：9:30～18:30</p>
      <p>定休日：水曜日</p>
    </div>

    <!-- コピーライト -->
    <p class="copyright">&copy; <?php echo date('Y'); ?> 三愛不動産管理. All Rights Reserved.</p>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
