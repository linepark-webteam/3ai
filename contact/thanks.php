<?php
/* =====================================================
 * 04. contact/thanks.php – 送信完了画面
 *  テーマ配下 /contact/ に配置
 * ===================================================*/

/* ─────────────────────────────────────────────
 * WordPress コア読み込み
 *   contact/ → テーマ → themes → wp-content → ルート
 * ─────────────────────────────────────────── */
/* =====================================================
 * contact/thanks.php – 送信完了画面
 * ===================================================*/
require_once dirname(__DIR__, 4) . '/wp-load.php';
session_start();

/* enqueue */
wp_enqueue_style(
  'sanai-contact-common',
  get_theme_file_uri('assets/css/contact-common.css'),
  ['sanai-common'],
  '1.0.0'
);
wp_enqueue_style(
  'sanai-contact-thanks',
  get_theme_file_uri('assets/css/contact_thanks.css'),
  ['sanai-contact-common'],
  '1.0.0'
);

/* 念のためセッション破棄 */
if (isset($_SESSION['contact_data'])) {
  unset($_SESSION['contact_data']);
}

get_header();
?>

<main id="primary" class="site-main">
  <section class="contact-thanks section container text-center">

    <?php get_template_part('template-parts/contact', 'progress', ['step' => 3]); ?>

    <h1 class="section-title"><?php esc_html_e('送信が完了しました', 'sanai-textdomain'); ?></h1>
    <p class="text-start">
      <?php esc_html_e('この度はお問い合わせいただき、誠にありがとうございます。内容を確認のうえ、担当より折り返しご連絡いたします。', 'sanai-textdomain'); ?>
    </p>

    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary mt-4">
      <?php esc_html_e('トップページへ戻る', 'sanai-textdomain'); ?>
    </a>
  </section>
</main>

<script>
  if (history.replaceState) {
    history.replaceState(null, '', '<?php echo esc_url( home_url( '/contact/' ) ); ?>');
  }
</script>

<?php get_footer(); ?>
