<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

// モジュール読み込み
foreach ( [ 'register-menu', 'form', 'save' ] as $m ) {
	require_once __DIR__ . "/{$m}.php";
}

// 管理画面で JS/CSS を読み込む
add_action( 'admin_enqueue_scripts', function( $hook ) {
	// メニュー slug と同じ      ↓
	if ( $hook !== 'toplevel_page_sanai_property_entry' ) return;

	// SortableJS CDN
	wp_enqueue_script( 'sortablejs', 'https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js', [], '1.15.0', true );

	// オリジナル JS
	wp_enqueue_script( 'sanai-property-entry', get_stylesheet_directory_uri() . '/inc/property-entry/assets/js/property-entry.js', [ 'sortablejs' ], '20250624', true );
} );