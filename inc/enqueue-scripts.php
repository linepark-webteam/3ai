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
    wp_enqueue_style(
        'sanai-header',
        get_template_directory_uri() . '/assets/css/header.css',
        array('sanai-reset'),
        $theme_version,
        'all'
    );

    //  top.css（トップページ用）
    if (is_front_page() || is_home()) {
        wp_enqueue_style(
            'sanai-top',
            get_template_directory_uri() . '/assets/css/top.css',
            array('sanai-common'),
            $theme_version,
            'all'
        );
    }

    //  service.css（事業内容ページ専用）
    //  template-parts/ 以下ではなく、ルート直下の page-service.php を指定
    if (is_page('services')) {
        wp_enqueue_style(
            'sanai-services',
            get_template_directory_uri() . '/assets/css/services.css',
            array('sanai-common'),
            $theme_version,
            'all'
        );
    }

    //  property-list.css（物件一覧アーカイブ用）
    if (is_post_type_archive('property')) {
        wp_enqueue_style(
            'sanai-property-list',
            get_template_directory_uri() . '/assets/css/property-list.css',
            array('sanai-common'),
            $theme_version,
            'all'
        );
    }

    //  company.css（会社概要ページ専用）
    //  template-parts/ 以下ではなく、ルート直下の page-company.php を指定
    if (is_page('company')) {
        wp_enqueue_style(
            'sanai-company',
            get_template_directory_uri() . '/assets/css/company.css',
            array('sanai-common'),
            $theme_version,
            'all'
        );
    }

    //  recruit.css（採用ページ専用）
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

    //  contact-common.css（/contact/ 以下で共通）
    if (preg_match('#/contact/#', $_SERVER['REQUEST_URI'])) {
        wp_enqueue_style(
            'sanai-contact-common',
            get_template_directory_uri() . '/assets/css/contact-common.css',
            array('sanai-common'),   // 必要なら依存を変更
            $theme_version,
            'all'
        );
    }

    //  contact.css（お問い合わせフォーム専用）
    if (is_page_template('contact/index.php')) {
        wp_enqueue_style(
            'sanai-contact',
            get_template_directory_uri() . '/assets/css/contact.css',
            array('sanai-contact-common'),     // 依存関係：contact-common.css の後に読み込む
            $theme_version,
            'all'
        );
    }



    //  テーマ独自の JS
    wp_enqueue_script(
      'sanai-main-js',
      get_template_directory_uri() . '/assets/js/main.js',
      array( 'jquery' ),
      $theme_version,
      true
    );
}
add_action('wp_enqueue_scripts', 'sanai_enqueue_assets');
