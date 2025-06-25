<?php
/* =====================================================
 * 03. contact/contact_send.php – メール送信＆完了画面遷移
 *  テーマ配下 /contact/ に配置
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

$inquiry_type_label = $type_labels[ $data['inquiry_type'] ] ?? $data['inquiry_type'];
$reply_type_label   = $reply_labels[ $data['reply_type'] ]   ?? $data['reply_type'];

/* ─────────────────────────────────────────────
 * 5) 送信先（管理者 & ユーザー）を決定
 * ─────────────────────────────────────────── */

/** 5-1) 管理者ロールのメールアドレスをすべて取得 */
$admins = get_users(
	[
		'role'    => 'administrator',
		'fields'  => [ 'user_email' ],
		'orderby' => 'ID',
	]
);
$admin_emails = wp_list_pluck( $admins, 'user_email' ); // ['owner@example.jp', 'staff@example.jp', …]

/** 5-2) 取得できなかった場合は fallback として一般設定の管理者メールを使用 */
if ( empty( $admin_emails ) ) {
	$admin_emails = [ get_option( 'admin_email' ) ];
}

/** 5-3) 送信者本人のメールアドレス */
$user_email = $data['email'];

/* ─────────────────────────────────────────────
 * 6) メール本文を組み立て
 * ─────────────────────────────────────────── */
$subject_admin = sprintf( __( '【お問い合わせ】%s 様より', 'sanai-textdomain' ), $data['user_name'] );
$subject_user  = __( 'お問い合わせありがとうございます', 'sanai-textdomain' );

$headers = [ 'Content-Type: text/plain; charset=UTF-8' ];

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
 * 7) メール送信
 * ─────────────────────────────────────────── */

/** 7-1) 管理者全員へ送信（配列渡し OK） */
wp_mail( $admin_emails, $subject_admin, $message, $headers );

/** 7-2) 送信者本人へ控えを送信 */
wp_mail( $user_email, $subject_user, $message, $headers );

/* ─────────────────────────────────────────────
 * 8) セッションを破棄して完了ページへ遷移
 * ─────────────────────────────────────────── */
unset( $_SESSION['contact_data'] );

wp_safe_redirect( get_theme_file_uri( 'contact/thanks.php' ) );
exit;
