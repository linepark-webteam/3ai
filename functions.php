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

// 4.独自物件投稿フォーム
require_once get_template_directory() . '/inc/property-entry/loader.php';

// 5. デフォルトナビコールバック
require_once get_template_directory() . '/inc/navigation.php';

// 6. 一覧表示件数など WP_Query の調整
require_once get_template_directory() . '/inc/query-filters.php';
