<?php

/**
 * inc/enqueue-scripts.php
 * CSS / JS 読み込み設定をまとめたファイル
 */

if (! defined('ABSPATH')) {
    exit;
}

function sanai_enqueue_assets()
{
    $theme_version = wp_get_theme()->get('Version');

    // 1. Bootstrap CSS（CDN）
    wp_enqueue_style(
        'bootstrap-cdn',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        array(),
        '5.3.3',
        'all'
    );

    // 2. Bootstrap Icons (CDN)
    wp_enqueue_style(
        'bootstrap-icons',
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css',
        array('bootstrap-cdn'),
        '1.11.3',
        'all'
    );

    // 3. reset.css
    wp_enqueue_style(
        'sanai-reset',
        get_template_directory_uri() . '/assets/css/reset.css',
        array('bootstrap-icons'),
        $theme_version,
        'all'
    );

    // 4. common.css
    wp_enqueue_style(
        'sanai-common',
        get_template_directory_uri() . '/assets/css/common.css',
        array('sanai-reset'),
        $theme_version,
        'all'
    );

    // 5. top.css（トップページ用）
    if (is_front_page() || is_home()) {
        wp_enqueue_style(
            'sanai-top',
            get_template_directory_uri() . '/assets/css/top.css',
            array('sanai-common'),
            $theme_version,
            'all'
        );
    }

    // 6. recruit.css（採用ページ専用）
    //  template-parts/ 以下ではなく、ルート直下の page-recruit.php を指定
    if (is_page('recruit')) {
        wp_enqueue_style(
            'sanai-recruit',
            get_template_directory_uri() . '/assets/css/recruit.css',
            array('sanai-common'),
            $theme_version,
            'all'
        );
    }

    // 7. テーマ独自の JS を読み込む場合（必要に応じて）
    // wp_enqueue_script(
    //   'sanai-main-js',
    //   get_template_directory_uri() . '/assets/js/main.js',
    //   array( 'jquery' ),
    //   $theme_version,
    //   true
    // );
}
add_action('wp_enqueue_scripts', 'sanai_enqueue_assets');
