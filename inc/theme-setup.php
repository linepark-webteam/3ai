<?php

/**
 * inc/theme-setup.php
 * テーマサポート設定や i18n 読み込み
 */

if (! defined('ABSPATH')) {
    exit;
}

function sanai_theme_setup()
{
    // 翻訳ファイルを読み込む
    load_theme_textdomain('sanai-textdomain', get_template_directory() . '/languages');

    // <title> タグを WordPress に任せる
    add_theme_support('title-tag');

    // RSS フィードリンクを自動挿入
    add_theme_support('automatic-feed-links');

    // 投稿サムネイル（アイキャッチ画像）を有効化
    add_theme_support('post-thumbnails');

    // カスタムメニューを登録
    register_nav_menus(
        array(
            'global_nav' => __('グローバルナビゲーション', 'sanai-textdomain'),
            'footer_nav' => __('フッターナビゲーション', 'sanai-textdomain'),
        )
    );
    // デフォルトメニューのコールバックを読み込む
    require_once get_template_directory() . '/inc/navigation.php';

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
