<?php

/**
 * inc/custom-post-types.php
 */

if (! defined('ABSPATH')) {
    exit;
}
/**
 * 「物件」カスタム投稿タイプを登録
 *
 * - 編集フォームは自作（property-entry.php）
 * - 標準メニューは非表示
 * - 一覧テーブルだけ再利用（物件登録 › 物件一覧）
 */
function sanai_register_property_cpt(): void
{

    $labels = [
        'name'          => __('物件一覧',     'sanai-textdomain'),
        'singular_name' => __('物件',         'sanai-textdomain'),
        'add_new_item'  => __('新規物件を追加', 'sanai-textdomain'),
        'edit_item'     => __('物件を編集',     'sanai-textdomain'),
        'view_item'     => __('物件を表示',     'sanai-textdomain'),
        'all_items'     => __('物件一覧',       'sanai-textdomain'),
        'search_items'  => __('物件を検索',     'sanai-textdomain'),
        'not_found'     => __('物件が見つかりません', 'sanai-textdomain'),
    ];

    $args = [
        // ───────── 公開設定 ─────────
        'public'             => true,                 // フロントでも表示
        'publicly_queryable' => true,
        'has_archive' => 'corp-property-list',         // アーカイブ
        'rewrite'     => [
            'slug'       => 'corp-property',   // 個別投稿
            'with_front' => false,
        ],

        // ───────── 管理画面 UI ─────────
        'show_ui'      => true,   // 一覧・個別編集 URL を生成
        'show_in_menu' => false,  // 標準サイドメニューは隠す（自作メニューのみ表示）

        // ───────── Gutenberg / REST ─────────
        'show_in_rest' => true,

        // ───────── 投稿タイプ能力 ─────────
        'capability_type' => 'post', // 通常投稿と同権限
        'supports'        => [       // 必須最低限（title はあっても OK）
            'title',
            'thumbnail',
            'custom-fields',
        ],

        // ───────── ラベル ─────────
        'labels'      => $labels,
        'menu_icon'   => 'dashicons-building',
    ];
    register_post_type('property', $args);
}
add_action('init', 'sanai_register_property_cpt');


// カスタム投稿タイプ「お知らせ」を登録
function sanai_register_notice_cpt()
{
    $labels = [
        'name'               => __('お知らせ', 'sanai-textdomain'),
        'singular_name'      => __('お知らせ', 'sanai-textdomain'),
        'menu_name'          => __('お知らせ管理', 'sanai-textdomain'),
        'add_new_item'       => __('新規お知らせを追加', 'sanai-textdomain'),
        'edit_item'          => __('お知らせを編集', 'sanai-textdomain'),
        'new_item'           => __('新しいお知らせ', 'sanai-textdomain'),
        'view_item'          => __('お知らせを表示', 'sanai-textdomain'),
        'search_items'       => __('お知らせを検索', 'sanai-textdomain'),
        'not_found'          => __('お知らせはありません', 'sanai-textdomain'),
        'not_found_in_trash' => __('ゴミ箱にお知らせはありません', 'sanai-textdomain'),
    ];
    $args = [
        'labels'        => $labels,
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => ['slug' => 'notice'],
        'show_in_rest'  => true,
        'supports'      => ['title'],
        'menu_position' => 6,
        'menu_icon'     => 'dashicons-megaphone',
    ];
    register_post_type('notice', $args);
}
add_action('init', 'sanai_register_notice_cpt');
