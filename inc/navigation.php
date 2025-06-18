<?php

/**
 * inc/navigation.php
 * デフォルトメニューのコールバック定義
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * PC用デフォルトグローバルナビ
 */
function sanai_default_global_nav()
{
    $items = [
        ['title' => '事業内容',    'url' => home_url('/services')],
        ['title' => '物件情報',    'url' => home_url('/corp-property-list')],
        ['title' => '会社概要',    'url' => home_url('/company')],
        ['title' => '採用情報',    'url' => home_url('/recruit')],
        ['title' => 'お問い合わせ', 'url' => home_url('/contact')],
    ];

    echo '<nav class="global-nav"><ul class="global-nav__list">';
    foreach ($items as $item) {
        printf(
            '<li class="global-nav__item"><a href="%s">%s</a></li>',
            esc_url($item['url']),
            esc_html($item['title'])
        );
    }
    echo '</ul></nav>';
}

/**
 * モバイル用デフォルトナビ（＋CTA）
 */
function sanai_default_mobile_nav()
{
    $items = [
        ['title' => '事業内容',    'url' => home_url('/services')],
        ['title' => '物件情報',    'url' => home_url('/corp-property-list')],
        ['title' => '会社概要',    'url' => home_url('/company')],
        ['title' => '採用情報',    'url' => home_url('/recruit')],
    ];

    // ▼ <nav> 内：通常リンク
    echo '<nav class="mobile-nav"><ul class="mobile-nav__list">';
    foreach ($items as $item) {
        printf(
            '<li class="mobile-nav__item"><a href="%s">%s</a></li>',
            esc_url($item['url']),
            esc_html($item['title'])
        );
    }
    echo '</ul>';

    // ▼ <nav> の直後：CTA 固定バー
?>
    <div class="mobile-nav__cta">
        <a href="<?php echo esc_url(home_url('/contact/')); ?>"
            class="btn  mobile-nav__btn">
            お問い合わせ
        </a>
        <a href="tel:045-951-2722"
            class="btn  mobile-nav__btn">
            <i class="bi bi-telephone-fill"></i>
            045-951-2722
        </a>
    </div>
    </nav>
<?php
}
