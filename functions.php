<?php

/**
 * 三愛不動産管理テーマの関数定義
 */

if (! defined('ABSPATH')) {
    exit; // 直接アクセスを防ぐ
}

/**
 * CSS / JS 読み込み設定
 */
function sanai_enqueue_assets()
{
    // テーマのバージョン番号（キャッシュ対策用に使えます）
    $theme_version = wp_get_theme()->get('Version');

    // 1. reset.css
    wp_enqueue_style(
        'sanai-reset',
        get_template_directory_uri() . '/assets/css/reset.css',
        array(),
        $theme_version,
        'all'
    );

    // 2. common.css（reset.css の後に適用）
    wp_enqueue_style(
        'sanai-common',
        get_template_directory_uri() . '/assets/css/common.css',
        array('sanai-reset'),
        $theme_version,
        'all'
    );

    // 3. top.css（common.css の後に適用）
    //    ※フロントページのみ読み込む場合は条件分岐を追加できます
    if (is_front_page() || is_home()) {
        wp_enqueue_style(
            'sanai-top',
            get_template_directory_uri() . '/assets/css/top.css',
            array('sanai-common'),
            $theme_version,
            'all'
        );
    }

    // 4. Bootstrap CSS（CDN）は先にテーマ外で読み込んでいるので不要。
    //    もしテーマ側で読み込みたい場合は下記のように記述します：
    // wp_enqueue_style(
    //   'bootstrap-cdn',
    //   'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
    //   array(),
    //   '5.3.3',
    //   'all'
    // );

    // 5. Bootstrap Icons (CDN) も同様にテーマで読み込むなら：
    // wp_enqueue_style(
    //   'bootstrap-icons',
    //   'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css',
    //   array(),
    //   '1.11.3',
    //   'all'
    // );

    // 6. 必要ならテーマ独自の JS を読み込む
    // wp_enqueue_script(
    //   'sanai-main-js',
    //   get_template_directory_uri() . '/assets/js/main.js',
    //   array( 'jquery' ), // 依存スクリプト
    //   $theme_version,
    //   true // フッター読み込み
    // );
}
add_action('wp_enqueue_scripts', 'sanai_enqueue_assets');

/**
 * テーマサポートの設定（例：タイトルタグ自動生成、カスタムロゴ、メニューの登録など）
 */
function sanai_theme_setup()
{
    // <title>タグを WordPress に任せる
    add_theme_support('title-tag');

    // RSS フィードリンクを自動挿入
    add_theme_support('automatic-feed-links');

    // 投稿サムネイル（アイキャッチ画像）を有効化
    add_theme_support('post-thumbnails');

    // カスタムメニューを登録
    register_nav_menus(
        array(
            'global_nav' => 'グローバルナビゲーション',
            'footer_nav' => 'フッターナビゲーション',
        )
    );

    // HTML5 マークアップをサポート
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        )
    );
}
add_action('after_setup_theme', 'sanai_theme_setup');


// 新規物件登録用カスタム投稿タイプ
function sanai_register_property_cpt() {
  $labels = array(
    'name'          => '物件',
    'singular_name' => '物件',
    // その他のラベルをここに設定
  );
  $args = array(
    'labels'             => $labels,
    'public'             => true,
    'has_archive'        => true,
    'supports'           => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
    'menu_position'      => 5,
    'menu_icon'          => 'dashicons-admin-multisite',
    'show_in_rest'       => true,
    'rewrite'            => array( 'slug' => 'property' ),
  );
  register_post_type( 'property', $args );
}
add_action( 'init', 'sanai_register_property_cpt' );
