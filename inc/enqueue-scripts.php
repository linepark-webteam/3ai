<?php

/**
 * inc/enqueue-scripts.php
 * CSS / JS 読み込み設定
 */
if (!defined('ABSPATH')) {
    exit;
}

function sanai_enqueue_assets()
{
    $ver = wp_get_theme()->get('Version');

    /* --- 共通 CSS --- */
    wp_enqueue_style('bootstrap-cdn',  'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', [], '5.3.3');
    wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css', ['bootstrap-cdn'], '1.11.3');
    wp_enqueue_style('sanai-reset',   get_template_directory_uri() . '/assets/css/reset.css',   ['bootstrap-icons'], $ver);
    wp_enqueue_style('sanai-common',  get_template_directory_uri() . '/assets/css/common.css',  ['sanai-reset'],    $ver);
    wp_enqueue_style('sanai-header',  get_template_directory_uri() . '/assets/css/header.css',  ['sanai-common'],   $ver);

    /* --- ページ別 CSS --- */
    if (is_front_page() || is_home()) {
        wp_enqueue_style('sanai-top', get_template_directory_uri() . '/assets/css/top.css', ['sanai-common'], $ver);
    }
    if (is_page('services')) {
        wp_enqueue_style('sanai-services', get_template_directory_uri() . '/assets/css/services.css', ['sanai-common'], $ver);
    }
    if (is_post_type_archive('property')) {
        wp_enqueue_style('sanai-list-property', get_template_directory_uri() . '/assets/css/list-property.css', ['sanai-common'], $ver);
    }
    if (is_singular('property')) {
        wp_enqueue_style('sanai-property', get_template_directory_uri() . '/assets/css/property.css', ['sanai-common'], $ver);
    }
    if (is_post_type_archive('notice')) {
        wp_enqueue_style('sanai-list-notice', get_template_directory_uri() . '/assets/css/list-notice.css', ['sanai-common'], $ver);
    }
    if (is_page('company')) {
        wp_enqueue_style('sanai-company', get_template_directory_uri() . '/assets/css/company.css', ['sanai-common'], $ver);
    }
    if (is_page('recruit')) {
        wp_enqueue_style('sanai-recruit', get_template_directory_uri() . '/assets/css/recruit.css', ['sanai-common'], $ver);
    }

    /* --- Contact 共通 CSS & JS --- */
    if (preg_match('#/contact/#', $_SERVER['REQUEST_URI'])) {
        wp_enqueue_style('sanai-contact-common', get_template_directory_uri() . '/assets/css/contact-common.css', ['sanai-common'], $ver);

        /* ★ 追加：クライアントバリデーション用 JS */
        wp_enqueue_script(
            'sanai-contact-form',
            get_template_directory_uri() . '/assets/js/contact-form.js',
            ['jquery'],
            $ver,
            true
        );
    }
    if (is_page_template('contact/index.php')) {
        wp_enqueue_style('sanai-contact', get_template_directory_uri() . '/assets/css/contact.css', ['sanai-contact-common'], $ver);
    }
    if (is_page('privacy-policy')) {
        wp_enqueue_style('sanai-privacy-policy', get_template_directory_uri() . '/assets/css/privacy-policy.css', ['sanai-common'], $ver);
    }

    /* --- GSAP / 共通 JS --- */
    wp_enqueue_script('gsap',              'https://cdn.jsdelivr.net/npm/gsap@3.12.4/dist/gsap.min.js', [], null, true);
    wp_enqueue_script('gsap-scrolltrigger', 'https://cdn.jsdelivr.net/npm/gsap@3.12.4/dist/ScrollTrigger.min.js', ['gsap'], null, true);
    wp_enqueue_script('sanai-main-js', get_template_directory_uri() . '/assets/js/main.js', ['jquery'], $ver, true);

    /* --- 特定ページ JS --- */
    if (is_front_page() || is_home()) {
        wp_enqueue_script('sanai-top-js', get_template_directory_uri() . '/assets/js/top.js', ['gsap', 'gsap-scrolltrigger'], $ver, true);
    }
    wp_enqueue_script('sanai-property-single', get_template_directory_uri() . '/assets/js/property-single.js', [], $ver, true);
}
add_action('wp_enqueue_scripts', 'sanai_enqueue_assets');
