<?php
/* =====================================================
 * 04. contact/thanks.php – 送信完了画面
 *  テーマ配下 /contact/ に配置
 * ===================================================*/

/* ─────────────────────────────────────────────
 * WordPress コア読み込み
 *   contact/ → テーマ → themes → wp-content → ルート
 * ─────────────────────────────────────────── */
require_once dirname( __DIR__, 4 ) . '/wp-load.php';
session_start();

/* ▼ 追加：共通 + thanks 専用 CSS を enqueue */
wp_enqueue_style(
  'sanai-contact-common',
  get_theme_file_uri( 'assets/css/contact-common.css' ),
  [ 'sanai-common' ],
  '1.0.0'
);

wp_enqueue_style(
  'sanai-contact-thanks',
  get_theme_file_uri( 'assets/css/contact_thanks.css' ),
  [ 'sanai-contact-common' ],
  '1.0.0'
);

/* ─────────────────────────────────────────────
 * セッションは使わないので念のため破棄
 * ─────────────────────────────────────────── */
if ( isset( $_SESSION['contact_data'] ) ) {
  unset( $_SESSION['contact_data'] );
}

/* ─────────────────────────────────────────────
 * 画面表示
 * ─────────────────────────────────────────── */
get_header();
?>

<main id="primary" class="site-main">
  <section class="contact-thanks section container text-center">

        <?php
        // index.php  → $step = 1;
        // confirm.php → $step = 2;
        // thanks.php  → $step = 3;
        get_template_part( 'template-parts/contact', 'progress', [ 'step' => 3 ] );
        ?>

    <!-- 完了メッセージ -->
    <h1 class="section-title"><?php esc_html_e( '送信が完了しました', 'sanai-textdomain' ); ?></h1>
    <p class="text-start">
      <?php esc_html_e( 'この度はお問い合わせいただき、誠にありがとうございます。内容を確認のうえ、担当より折り返しご連絡いたします。', 'sanai-textdomain' ); ?>
    </p>

    <!-- トップへ戻るボタン -->
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary mt-4">
      <?php esc_html_e( 'トップページへ戻る', 'sanai-textdomain' ); ?>
    </a>
  </section>
</main>

<?php get_footer(); ?>
