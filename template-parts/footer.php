<?php
/**
 * フッターテンプレート (template-parts/footer.php)
 */
?>
<?php
/* ===========================================
 * Back-to-Top Button
 * ======================================== */
?>
<button id="backToTop" class="back-to-top" aria-label="<?php esc_attr_e( 'ページトップへ戻る', 'sanai-textdomain' ); ?>">
  <i class="bi bi-chevron-up" aria-hidden="true"></i>
</button>

<!-- フッター -->
<footer class="site-footer">
  <div class="footer-inner container">

    <?php
    // フッターナビゲーション
    wp_nav_menu( [
      'theme_location'  => 'footer_nav',
      'container'       => 'nav',
      'container_class' => 'footer-nav',
      'menu_class'      => 'footer-nav__list',
      'depth'           => 1,
      // 未設定時はデフォルトのナビゲーションを出力
      'fallback_cb'     => 'sanai_default_global_nav',
    ] );
    ?>

    <!-- 会社情報 -->
    <div class="footer-company">
      <?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) : ?>
        <div class="footer-logo"><?php the_custom_logo(); ?></div>
      <?php else : ?>
        <div class="footer-logo">
        <img
          src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo.png' ); ?>"
          alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
        />
        </div>
      <?php endif; ?>

      <p><?php echo esc_html__( '免許番号：神奈川県知事（7）第21620号', 'sanai-textdomain' ); ?></p>
      <address>
        <p><?php echo esc_html__( '〒241-0022', 'sanai-textdomain' ); ?></p>
        <p><?php echo esc_html__( '横浜市旭区鶴ヶ峰2丁目2-3', 'sanai-textdomain' ); ?></p>
      </address>
      <p>
        <?php echo esc_html__( 'TEL：', 'sanai-textdomain' ); ?>
        <a href="tel:<?php echo esc_attr( '0459512722' ); ?>">
          <?php echo esc_html( '045-951-2722' ); ?>
        </a>
      </p>
      <p>
        <?php echo esc_html__( 'FAX：', 'sanai-textdomain' ); ?>
        <?php echo esc_html( '045-951-2725' ); ?>
      </p>
      <p>
        <?php echo esc_html__( '営業時間：9:30～18:30', 'sanai-textdomain' ); ?>
      </p>
      <p>
        <?php echo esc_html__( '定休日：水曜日', 'sanai-textdomain' ); ?>
      </p>
    </div>

    <!-- コピーライト -->
    <p class="copyright">
      &copy; <?php echo esc_html( date( 'Y' ) ); ?>
      <?php echo esc_html__( '三愛不動産管理. All Rights Reserved.', 'sanai-textdomain' ); ?>
    </p>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
