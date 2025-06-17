<?php
/* =====================================================
 * 03. contact/contact_send.php – メール送信＆完了画面遷移
 *  (テーマ /contact/ フォルダーに配置する想定)
 * ===================================================*/

/* ─────────────────────────────────────────────
 * 1) WordPress コア読み込み
 *    contact/ → テーマ → themes → wp-content → (4 階層戻る)
 * ─────────────────────────────────────────── */
require_once dirname( __DIR__, 4 ) . '/wp-load.php';
session_start();

/* ─────────────────────────────────────────────
 * 2) CSRF（nonce）検証
 * ─────────────────────────────────────────── */
if (
  ! isset( $_POST['contact_send_nonce'] ) ||
  ! wp_verify_nonce( $_POST['contact_send_nonce'], 'contact_send' )
) {
  wp_safe_redirect( home_url( '/contact' ) );
  exit;
}

/* ─────────────────────────────────────────────
 * 3) セッションにデータが無ければ入力画面へ
 * ─────────────────────────────────────────── */
if ( empty( $_SESSION['contact_data'] ) ) {
  wp_safe_redirect( home_url( '/contact' ) );
  exit;
}

$data = $_SESSION['contact_data'];

/* ─────────────────────────────────────────────
 * 4) ラベル変換用配列
 * ─────────────────────────────────────────── */
$type_labels = [
  'property' => __( '物件について', 'sanai-textdomain' ),
  'recruit'  => __( '求人について', 'sanai-textdomain' ),
  'others'   => __( 'その他', 'sanai-textdomain' ),
];

$reply_labels = [
  'email' => __( 'メールでの返信', 'sanai-textdomain' ),
  'tel'   => __( '電話での返信', 'sanai-textdomain' ),
  'any'   => __( 'どちらでも可', 'sanai-textdomain' ),
];

/* 値が配列に存在しない場合はそのまま出力 */
$inquiry_type_label = $type_labels[ $data['inquiry_type'] ] ?? $data['inquiry_type'];
$reply_type_label   = $reply_labels[ $data['reply_type'] ] ?? $data['reply_type'];

/* ─────────────────────────────────────────────
 * 5) メール本文を組み立て
 * ─────────────────────────────────────────── */
$admin_to   = get_option( 'admin_email' );
$user_to    = $data['email'];
$subject    = sprintf( __( '【お問い合わせ】%s 様より', 'sanai-textdomain' ), $data['user_name'] );
$headers    = [ 'Content-Type: text/plain; charset=UTF-8' ];

$message  = "以下の内容でお問い合わせを受け付けました。\n\n";
$message .= "【お問い合わせの種類】\n{$inquiry_type_label}\n\n";
$message .= "【社名】\n{$data['company_name']}\n\n";
$message .= "【氏名】\n{$data['user_name']}\n\n";
$message .= "【電話番号】\n{$data['tel']}\n\n";
$message .= "【メールアドレス】\n{$data['email']}\n\n";
$message .= "【返信方法】\n{$reply_type_label}\n\n";
$message .= "【お問い合わせ内容】\n{$data['message']}\n\n";
$message .= "----------------------------------------\n";
$message .= "※このメールはシステムからの自動送信です。\n";

/* ─────────────────────────────────────────────
 * 6) メール送信（管理者・ユーザー両方へ）
 * ─────────────────────────────────────────── */
wp_mail( $admin_to, $subject, $message, $headers );     // 管理者宛
wp_mail( $user_to,  __( 'お問い合わせありがとうございます', 'sanai-textdomain' ), $message, $headers ); // ご本人宛

/* ─────────────────────────────────────────────
 * 7) セッションを破棄して完了ページへ遷移
 * ─────────────────────────────────────────── */
unset( $_SESSION['contact_data'] );

/* 完了ページへリダイレクト */
wp_safe_redirect( get_theme_file_uri( 'contact/thanks.php' ) );
exit;