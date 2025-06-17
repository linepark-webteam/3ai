<?php
/* =====================================================
 * 02. contact/contact_confirm.php – 内容確認
 * テーマ配下 /contact/ に配置
 * ===================================================*/

require_once dirname( __DIR__, 4 ) . '/wp-load.php';
session_start();


/* ---------- 1) CSRF & リクエストバリデーション ---------- */
if (
  ! isset($_POST['contact_nonce']) ||
  ! wp_verify_nonce($_POST['contact_nonce'], 'contact_submit')
) {
  wp_safe_redirect(home_url('/contact'));
  exit;
}

/* ---------- 2) ハニーポット（Bot）チェック ---------- */
if (! empty($_POST['contact_hp'])) {
  wp_safe_redirect(home_url('/contact'));
  exit;
}

/* ---------- 3) 必須項目チェック ---------- */
$required = ['inquiry_type', 'user_name', 'tel', 'email', 'reply_type', 'message', 'agree'];
$errors   = [];

foreach ($required as $key) {
  if (empty($_POST[$key])) {
    /* 翻訳用 __( '...', 'textdomain' ) に渡すより、人間が読める値へ置換 */
    $labels = [
      'inquiry_type' => __('お問い合わせの種類', 'sanai-textdomain'),
      'user_name'    => __('氏名', 'sanai-textdomain'),
      'tel'          => __('電話番号', 'sanai-textdomain'),
      'email'        => __('メールアドレス', 'sanai-textdomain'),
      'reply_type'   => __('返信方法', 'sanai-textdomain'),
      'message'      => __('お問い合わせ内容', 'sanai-textdomain'),
      'agree'        => __('プライバシーポリシー同意', 'sanai-textdomain'),
    ];
    $errors[] = sprintf(__('%s は必須項目です。', 'sanai-textdomain'), $labels[$key]);
  }
}

if ($errors) {
  /* エラーを入力画面へ返す */
  $_SESSION['contact_errors'] = $errors;
  wp_safe_redirect(home_url('/contact'));
  exit;
}

/* ---------- 4) 入力値を整形してセッション保存 ---------- */
$type_labels = [
  'property' => __( '物件について', 'sanai-textdomain' ),
  'recruit'  => __( '求人について', 'sanai-textdomain' ),
  'others'   => __( 'その他',   'sanai-textdomain' ),
];
$reply_labels = [
  'email' => __( 'メールでの返信', 'sanai-textdomain' ),
  'tel'   => __( '電話での返信',   'sanai-textdomain' ),
  'any'   => __( 'どちらでも可',   'sanai-textdomain' ),
];

$inquiry_label = $type_labels[ $_POST['inquiry_type'] ] ?? '';
$reply_label   = $reply_labels[ $_POST['reply_type'] ] ?? '';

$data = [
  'inquiry_type'        => sanitize_text_field( $_POST['inquiry_type'] ),
  'inquiry_type_label'  => $inquiry_label,
  'company_name'        => sanitize_text_field( $_POST['company_name'] ),
  'user_name'           => sanitize_text_field( $_POST['user_name'] ),
  'tel'                 => sanitize_text_field( $_POST['tel'] ),
  'email'               => sanitize_email( $_POST['email'] ),
  'reply_type'          => sanitize_text_field( $_POST['reply_type'] ),
  'reply_type_label'    => $reply_label,           // ★ ここを追加
  'message'             => sanitize_textarea_field( $_POST['message'] ),
];

$_SESSION['contact_data'] = $data;

/* ---------- 5) 画面表示 ---------- */
get_header();
?>

<main id="primary" class="site-main">
  <section class="contact-confirm section container">
    <h1 class="section-title"><?php esc_html_e('お問い合わせ内容の確認', 'sanai-textdomain'); ?></h1>

    <!-- Progress Indicator -->
    <ol class="contact-progress" aria-label="<?php esc_attr_e('お問い合わせ手順', 'sanai-textdomain'); ?>">
      <li class="contact-progress__item"><span>01.</span> <?php esc_html_e('フォーム入力', 'sanai-textdomain'); ?></li>
      <li class="contact-progress__item is-current"><span>02.</span> <?php esc_html_e('内容確認', 'sanai-textdomain'); ?></li>
      <li class="contact-progress__item"><span>03.</span> <?php esc_html_e('送信完了', 'sanai-textdomain'); ?></li>
    </ol>

    <!-- 入力内容の一覧表示 -->
    <dl class="contact-confirm__list">
      <dt><?php esc_html_e('お問い合わせの種類', 'sanai-textdomain'); ?></dt>
      <dd><?php echo esc_html($data['inquiry_type_label']); ?></dd>

      <dt><?php esc_html_e('社名', 'sanai-textdomain'); ?></dt>
      <dd><?php echo esc_html($data['company_name']); ?></dd>

      <dt><?php esc_html_e('氏名', 'sanai-textdomain'); ?></dt>
      <dd><?php echo esc_html($data['user_name']); ?></dd>

      <dt><?php esc_html_e('電話番号', 'sanai-textdomain'); ?></dt>
      <dd><?php echo esc_html($data['tel']); ?></dd>

      <dt><?php esc_html_e('メールアドレス', 'sanai-textdomain'); ?></dt>
      <dd><?php echo esc_html($data['email']); ?></dd>

      <dt><?php esc_html_e('返信方法', 'sanai-textdomain'); ?></dt>
      <dd><?php echo esc_html( $data['reply_type_label'] ); ?></dd>

      <dt><?php esc_html_e('お問い合わせ内容', 'sanai-textdomain'); ?></dt>
      <dd><?php echo nl2br(esc_html($data['message'])); ?></dd>
    </dl>

    <!-- 送信／戻る -->
    <form
      action="<?php echo esc_url(get_theme_file_uri('contact/contact_send.php')); ?>"
      method="post"
      class="text-center">
      <?php wp_nonce_field('contact_send', 'contact_send_nonce'); ?>

      <button type="submit" class="btn btn-primary btn-lg me-3">
        <?php esc_html_e('送信する', 'sanai-textdomain'); ?>
      </button>

      <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-outline-secondary btn-lg">
        <?php esc_html_e('戻る', 'sanai-textdomain'); ?>
      </a>
    </form>
  </section>
</main>

<?php get_footer(); ?>