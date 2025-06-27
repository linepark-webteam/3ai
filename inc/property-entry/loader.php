<?php
/**
 * inc/property-entry/loader.php
 */
if (! defined('ABSPATH')) {
	exit;
}

// モジュール読み込み
foreach (['register-menu', 'form', 'save'] as $m) {
	require_once __DIR__ . "/{$m}.php";
}

add_action('admin_enqueue_scripts', function ($hook) {
    if ($hook !== 'toplevel_page_sanai_property_entry') return;

    // ▼ メディアライブラリ用スクリプト／スタイル
    wp_enqueue_media();

    // SortableJS CDN
    wp_enqueue_script(
        'sortablejs',
        'https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js',
        [],
        '1.15.0',
        true
    );

    // オリジナル JS (依存に media-editor を追加)
    wp_enqueue_script(
        'sanai-property-entry',
        get_stylesheet_directory_uri() . '/inc/property-entry/assets/js/property-entry.js',
        ['sortablejs', 'jquery', 'media-editor'],
        '20250628',
        true
    );
});