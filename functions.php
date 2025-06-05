<?php
/**
 * functions.php
 * 三愛不動産管理テーマの関数定義
 */

if ( ! defined( 'ABSPATH' ) ) {
    // 直接アクセスは 403 を返して終了
    if ( function_exists( 'status_header' ) ) {
        status_header( 403 );
    }
    exit;
}

// 1. enqueue スクリプト・スタイル
require_once get_template_directory() . '/inc/enqueue-scripts.php';

// 2. テーマサポート・i18n・メニュー登録
require_once get_template_directory() . '/inc/theme-setup.php';

// 3. カスタム投稿タイプ
require_once get_template_directory() . '/inc/custom-post-types.php';

// 必要に応じて、さらに以下のようにファイル分割可能
// require_once get_template_directory() . '/inc/widgets.php';
// require_once get_template_directory() . '/inc/extras.php';
