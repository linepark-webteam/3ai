<?php
/**
 * inc/query-filters.php
 * WP_Query のカスタム調整（一覧表示件数など）
 *
 * @package Sanai_WP_Theme
 * @since   1.0.0
 */

/**
 * 物件カスタム投稿アーカイブを 12 件 / ページに固定
 */
add_action( 'pre_get_posts', function ( WP_Query $q ) {

	// 管理画面・REST API・メインクエリ以外は対象外
	if ( is_admin() || ! $q->is_main_query() || $q->is_rest ) {
		return;
	}

	// property 投稿タイプのアーカイブ一覧のみ
	if ( $q->is_post_type_archive( 'property' ) ) {
		$q->set( 'posts_per_page', 12 );
	}
} );
