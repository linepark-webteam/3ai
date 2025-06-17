<?php
/* =====================================================
 * 04. contact/thanks.php – 送信完了画面
 *  (テーマ /contact/ フォルダーに配置する想定)
 * ===================================================*/

/* ─────────────────────────────────────────────
 * WordPress コア読み込み
 *   contact/ → テーマ → themes → wp-content → ルート
 * ─────────────────────────────────────────── */
require_once dirname( __DIR__, 4 ) . '/wp-load.php';
session_start();

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

    <!-- 進捗インジケーター -->
    <ol class="contact-progress" aria-label="<?php esc_attr_e( 'お問い合わせ手順', 'sanai-textdomain' ); ?>">
      <li class="contact-progress__item"><span>01.</span><?php esc_html_e( 'フォーム入力', 'sanai-textdomain' ); ?></li>
      <li class="contact-progress__item"><span>02.</span><?php esc_html_e( '内容確認', 'sanai-textdomain' ); ?></li>
      <li class="contact-progress__item is-current"><span>03.</span><?php esc_html_e( '送信完了', 'sanai-textdomain' ); ?></li>
    </ol>

    <!-- 完了メッセージ -->
    <h1 class="section-title"><?php esc_html_e( '送信が完了しました', 'sanai-textdomain' ); ?></h1>
    <p>
      <?php esc_html_e( 'この度はお問い合わせいただき、誠にありがとうございます。内容を確認のうえ、担当より折り返しご連絡いたします。', 'sanai-textdomain' ); ?>
    </p>

    <!-- トップへ戻るボタン -->
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary mt-4">
      <?php esc_html_e( 'トップページへ戻る', 'sanai-textdomain' ); ?>
    </a>
  </section>
</main>

<?php get_footer(); ?>
