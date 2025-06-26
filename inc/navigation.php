<?php

/**
 * inc/navigation.php
 * デフォルトナビゲーションメニューのコールバック定義
 */

if (! defined('ABSPATH')) {
    exit;
}
/**
 * ドロワーナビ（PC・SP 共通）
 */
function sanai_default_drawer_nav()
{
    $items = [
        ['title' => '事業内容',    'url' => home_url('/services')],
        ['title' => '物件情報',    'url' => home_url('/corp-property-list')],
        ['title' => '会社概要',    'url' => home_url('/company')],
        ['title' => '採用情報',    'url' => home_url('/recruit')],
        ['title' => 'お知らせ',    'url' => home_url('/notice')],
    ];

    echo '<nav id="drawerNav" class="drawer-nav"><ul class="drawer-nav__list">';
    foreach ($items as $item) {
        printf(
            '<li class="drawer-nav__item"><a href="%s">%s</a></li>',
            esc_url($item['url']),
            esc_html($item['title'])
        );
    }
    echo '</ul>';

    // CTA ボタン
?>
    <div class="drawer-nav__cta">
        <a href="<?php echo esc_url(home_url('/contact/')); ?>"
            class="btn drawer-nav__btn">
            <?php esc_html_e('お問い合わせ', 'sanai-textdomain'); ?>
        </a>
        <a href="tel:045-951-2722"
            class="btn drawer-nav__btn">
            <i class="bi bi-telephone-fill"></i> 045-951-2722
        </a>
    </div>
    </nav>
<?php
}

/**
 * デフォルトフッターナビ
 */
function sanai_default_footer_nav()
{
    $items = [
        ['title' => '事業内容',    'url' => home_url('/services')],
        ['title' => '物件情報',    'url' => home_url('/corp-property-list')],
        ['title' => '会社概要',    'url' => home_url('/company')],
        ['title' => '採用情報',    'url' => home_url('/recruit')],
        ['title' => 'お知らせ',    'url' => home_url('/notice')],
        ['title' => 'お問い合わせ', 'url' => home_url('/contact')],
        ['title' => 'プライバシーポリシー', 'url' => home_url('/privacy-policy')],
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
