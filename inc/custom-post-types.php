<?php
/**
 * inc/custom-post-types.php
 * カスタム投稿タイプ「物件」を登録する
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

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

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => 'property',
        'show_in_rest'       => true,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-building',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
        'rewrite'            => array(
            'slug'       => 'property',
            'with_front' => false,
        ),
        'capability_type'    => 'post',
        'taxonomies'         => array( 'category', 'post_tag' ),
        'hierarchical'       => false,
        'exclude_from_search'=> false,
        'publicly_queryable' => true,
    );

    register_post_type( 'property', $args );
}
add_action( 'init', 'sanai_register_property_cpt' );
