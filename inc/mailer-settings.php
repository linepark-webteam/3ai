<?php
/**
 * inc/mailer-settings.php
 * Dotenv で .env を読み込み、wp_mail() 経由の PHPMailer 設定を上書き
 *
 * 必要パッケージ:
 *   composer require vlucas/phpdotenv
 *
 * .env は WordPress ルート直下（wp-config.php と同階層）に配置
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*──────────────────────────────────────
 * 1. Dotenv 読み込み
 *──────────────────────────────────────*/
$autoload_paths = [
    // プロジェクト全体で composer install 済みの場合
    ABSPATH . 'vendor/autoload.php',
    // テーマ単体で composer install している場合
    get_template_directory() . '/vendor/autoload.php',
];

foreach ( $autoload_paths as $path ) {
    if ( file_exists( $path ) ) {
        require_once $path;
        break;
    }
}

if ( class_exists( 'Dotenv\Dotenv' ) ) {
    // WordPress ルート直下の .env を読み込み
    $dotenv = Dotenv\Dotenv::createImmutable( ABSPATH );
    $dotenv->safeLoad();  // 既に読み込まれていても上書きしない
}

/*──────────────────────────────────────
 * 2. PHPMailer 設定をフック
 *──────────────────────────────────────*/
add_action( 'phpmailer_init', function ( PHPMailer\PHPMailer\PHPMailer $phpmailer ) {

    // 必須環境変数の存在を簡易チェック
    if ( empty( $_ENV['SMTP_HOST'] ) || empty( $_ENV['SMTP_USER'] ) ) {
        error_log( '[Mailer] SMTP_HOST / SMTP_USER が未設定です。' );
        return;
    }

    $phpmailer->isSMTP();
    $phpmailer->Host       = $_ENV['SMTP_HOST'];
    $phpmailer->SMTPAuth   = true;
    $phpmailer->Port       = (int) ( $_ENV['SMTP_PORT'] ?? 587 );
    $phpmailer->Username   = $_ENV['SMTP_USER'];
    $phpmailer->Password   = $_ENV['SMTP_PASS'] ?? '';
    $phpmailer->SMTPSecure = $_ENV['SMTP_SECURE'] ?? 'tls';  // 'ssl' or 'tls'
    $phpmailer->CharSet    = 'UTF-8';

    // 既定の差出人情報を上書き
    $from_email = $_ENV['FROM_EMAIL'] ?? $_ENV['SMTP_USER'];
    $from_name  = $_ENV['FROM_NAME']  ?? get_bloginfo( 'name' );

    $phpmailer->setFrom( $from_email, $from_name );

    // TLS/SSL 自動検知（明示設定がなければポート番号で推定）
    if ( empty( $_ENV['SMTP_SECURE'] ) ) {
        if ( 465 === $phpmailer->Port ) {
            $phpmailer->SMTPSecure = 'ssl';
        } else {
            $phpmailer->SMTPSecure = 'tls';
        }
    }
} );
