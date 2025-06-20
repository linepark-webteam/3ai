<?php

/**
 * inc/enqueue-scripts.php
 * CSS / JS 読み込み設定をまとめたファイル
 */

if (! defined('ABSPATH')) {
    exit;
}
function sanai_enqueue_assets() {
    $ver = wp_get_theme()->get( 'Version' );

    /* --- 共通 CSS --- */
    wp_enqueue_style( 'bootstrap-cdn',  'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', [], '5.3.3', 'all' );
    wp_enqueue_style( 'bootstrap-icons','https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css', ['bootstrap-cdn'], '1.11.3', 'all' );
    wp_enqueue_style( 'sanai-reset',   get_template_directory_uri() . '/assets/css/reset.css', ['bootstrap-icons'], $ver );
    wp_enqueue_style( 'sanai-common',  get_template_directory_uri() . '/assets/css/common.css', ['sanai-reset'],    $ver );
    wp_enqueue_style( 'sanai-header',  get_template_directory_uri() . '/assets/css/header.css', ['sanai-common'],   $ver );

    /* --- ページ／投稿タイプ別 CSS --- */
    if ( is_front_page() || is_home() ) {
        wp_enqueue_style( 'sanai-top', get_template_directory_uri() . '/assets/css/top.css', ['sanai-common'], $ver );
    }

    if ( is_page( 'services' ) ) {
        wp_enqueue_style( 'sanai-services', get_template_directory_uri() . '/assets/css/services.css', ['sanai-common'], $ver );
    }

    if ( is_post_type_archive( 'property' ) ) {
        wp_enqueue_style( 'sanai-list-property', get_template_directory_uri() . '/assets/css/list-property.css', ['sanai-common'], $ver );
    }

    if ( is_singular( 'property' ) ) {          // ← 詳細ページ専用
        wp_enqueue_style( 'sanai-property', get_template_directory_uri() . '/assets/css/property.css', ['sanai-common'], $ver );
    }

    if ( is_post_type_archive( 'notice' ) ) {
        wp_enqueue_style( 'sanai-list-notice', get_template_directory_uri() . '/assets/css/list-notice.css', ['sanai-common'], $ver );
    }

    if ( is_page( 'company' ) ) {
        wp_enqueue_style( 'sanai-company', get_template_directory_uri() . '/assets/css/company.css', ['sanai-common'], $ver );
    }

    if ( is_page( 'recruit' ) ) {
        wp_enqueue_style( 'sanai-recruit', get_template_directory_uri() . '/assets/css/recruit.css', ['sanai-common'], $ver );
    }

    if ( preg_match( '#/contact/#', $_SERVER['REQUEST_URI'] ) ) {
        wp_enqueue_style( 'sanai-contact-common', get_template_directory_uri() . '/assets/css/contact-common.css', ['sanai-common'], $ver );
    }
    if ( is_page_template( 'contact/index.php' ) ) {
        wp_enqueue_style( 'sanai-contact', get_template_directory_uri() . '/assets/css/contact.css', ['sanai-contact-common'], $ver );
    }

    /* --- 共通 JS --- */
    wp_enqueue_script(
        'sanai-main-js',
        get_template_directory_uri() . '/assets/js/main.js',
        [ 'jquery' ],
        $ver,
        true
    );
}
add_action( 'wp_enqueue_scripts', 'sanai_enqueue_assets' );
