<?php
/**
 * inc/custom-post-types.php
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
// カスタム投稿タイプ「物件」を登録する
function sanai_register_property_cpt() {
    $labels = array(
        'name'                  => __( '物件一覧', 'sanai-textdomain' ),
        'singular_name'         => __( '物件', 'sanai-textdomain' ),
        'menu_name'             => __( '物件情報', 'sanai-textdomain' ),
        'name_admin_bar'        => __( '物件', 'sanai-textdomain' ),
        'add_new'               => __( '新規追加', 'sanai-textdomain' ),
        'add_new_item'          => __( '新規物件を追加', 'sanai-textdomain' ),
        'new_item'              => __( '新しい物件', 'sanai-textdomain' ),
        'edit_item'             => __( '物件を編集', 'sanai-textdomain' ),
        'view_item'             => __( '物件を表示', 'sanai-textdomain' ),
        'all_items'             => __( 'すべての物件', 'sanai-textdomain' ),
        'search_items'          => __( '物件を検索', 'sanai-textdomain' ),
        'not_found'             => __( '物件が見つかりません', 'sanai-textdomain' ),
        'not_found_in_trash'    => __( 'ゴミ箱に物件が見つかりません', 'sanai-textdomain' ),
        'archives'              => __( '物件アーカイブ', 'sanai-textdomain' ),
        'insert_into_item'      => __( '物件に挿入', 'sanai-textdomain' ),
        'uploaded_to_this_item' => __( 'この物件にアップロード', 'sanai-textdomain' ),
        'filter_items_list'     => __( '物件リストを絞り込む', 'sanai-textdomain' ),
        'items_list_navigation' => __( '物件リストナビゲーション', 'sanai-textdomain' ),
        'items_list'            => __( '物件リスト', 'sanai-textdomain' ),
    );

    $args = [
        'labels'             => $labels,
        'public'             => true,          // フロント表示は維持
        'has_archive'        => 'corp-property-list',
        'show_in_rest'       => true,          // REST API / Gutenberg 用
        /* ▼ ここを追加・変更 ▼ */
        'show_ui'            => false,         // 投稿一覧・編集画面を非表示
        'show_in_menu'       => false,         // サイドバーのメニューも非表示
        /* ▲ ここまで ▲ */
        'menu_position'      => 5,             // （非表示なので無視される）
        'menu_icon'          => 'dashicons-building',
        'supports'           => [ 'title', 'editor', 'thumbnail', 'custom-fields' ],
        'rewrite'            => [
            'slug'       => 'corp-property-list',
            'with_front' => false,
        ],
        'taxonomies'         => [ 'category', 'post_tag' ],
        'hierarchical'       => false,
        'publicly_queryable' => true,
    ];

    register_post_type( 'property', $args );
}
add_action( 'init', 'sanai_register_property_cpt' );


// カスタム投稿タイプ「お知らせ」を登録
function sanai_register_notice_cpt() {
    $labels = [
        'name'               => __( 'お知らせ', 'sanai-textdomain' ),
        'singular_name'      => __( 'お知らせ', 'sanai-textdomain' ),
        'menu_name'          => __( 'お知らせ管理', 'sanai-textdomain' ),
        'add_new_item'       => __( '新規お知らせを追加', 'sanai-textdomain' ),
        'edit_item'          => __( 'お知らせを編集', 'sanai-textdomain' ),
        'new_item'           => __( '新しいお知らせ', 'sanai-textdomain' ),
        'view_item'          => __( 'お知らせを表示', 'sanai-textdomain' ),
        'search_items'       => __( 'お知らせを検索', 'sanai-textdomain' ),
        'not_found'          => __( 'お知らせはありません', 'sanai-textdomain' ),
        'not_found_in_trash' => __( 'ゴミ箱にお知らせはありません', 'sanai-textdomain' ),
    ];
    $args = [
        'labels'        => $labels,
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => [ 'slug' => 'notice' ],
        'show_in_rest'  => true,
        'supports'      => [ 'title' ],
        'menu_position' => 6,
        'menu_icon'     => 'dashicons-megaphone',
    ];
    register_post_type( 'notice', $args );
}
add_action( 'init', 'sanai_register_notice_cpt' );

