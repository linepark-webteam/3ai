<?php

/**
 * template-parts/single-property.php
 * Single Template for Property
 *
 * @package Sanai_WP_Theme
 */
get_header();

/* ---------- 改行を安全に <br> 出力 ---------- */
function sanai_nl2br_safe(string $v)
{
    return $v === '' ? '' : wp_kses_post(nl2br(esc_html($v)));
}
?>

<main id="mainContent" class="single-property section container">
    <article <?php post_class('property-detail'); ?>>

        <?php
        /* ===== 1. 画像 ===== */
        $gallery_ids = (array) get_post_meta(get_the_ID(), 'property_images', true);
        $main_id     = get_post_thumbnail_id(get_the_ID());

        /* アイキャッチがあれば先頭に差し込む（重複防止） */
        if ($main_id) {
            array_unshift($gallery_ids, $main_id);
            $gallery_ids = array_unique($gallery_ids);
        }

        /* メイン画像ソース */
        if ($main_id) {
            $main_img = wp_get_attachment_image($main_id, 'large', false, ['class' => 'property-main-img', 'id' => 'propertyMainImg']);
        } elseif (! empty($gallery_ids)) {
            $main_img = wp_get_attachment_image($gallery_ids[0], 'large', false, ['class' => 'property-main-img', 'id' => 'propertyMainImg']);
        } else {
            $main_img = sprintf(
                '<img id="propertyMainImg" src="%s" alt="%s" class="property-main-img" />',
                esc_url(get_template_directory_uri() . '/assets/img/coming-soon.png'),
                esc_attr__('Coming Soon', 'sanai-textdomain')
            );
        }

        $map_img = get_post_meta(get_the_ID(), 'map_image', true);
        ?>

        <div class="property-images">
            <?php echo $main_img; ?>

            <?php if ($map_img) : ?>
                <div class="property-map-thumb">
                    <img src="<?php echo esc_url($map_img); ?>" alt="<?php esc_attr_e('地図', 'sanai-textdomain'); ?>">
                </div>
            <?php endif; ?>

            <?php if (! empty($gallery_ids)) : ?>
                <ul class="property-gallery" id="propertyGallery">
                    <?php foreach ($gallery_ids as $gid) : ?>
                        <li>
                            <?php echo wp_get_attachment_image($gid, 'thumbnail', false, ['data-full' => wp_get_attachment_url($gid)]); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <?php
        /* ===== 2. サマリー ===== */
        $summary_map = [
            'address'    => __('所在地', 'sanai-textdomain'),
            'access'     => __('アクセス', 'sanai-textdomain'),
            'layout'     => __('間取り', 'sanai-textdomain'),
            'floor_size' => __('専有面積', 'sanai-textdomain'),
            'price'      => __('価格', 'sanai-textdomain'),
        ];
        ?>
        <header class="property-head">
            <h1 class="property-title"><?php echo sanai_nl2br_safe(get_the_title()); ?></h1>

            <ul class="property-summary">
                <?php
                foreach ($summary_map as $meta_key => $label) {
                    $key = in_array($meta_key, ['layout', 'floor_size'], true) ? 'ov_' . $meta_key : $meta_key;
                    printf(
                        '<li class="summary-item"><span class="summary-label">%1$s</span>：<span class="summary-value">%2$s</span></li>',
                        esc_html($label),
                        sanai_nl2br_safe(get_post_meta(get_the_ID(), $key, true))
                    );
                }
                ?>
            </ul>
        </header>

        <!-- ===== 3. 物件概要 ===== -->
        <section class="property-spec">
            <h2 class="property-overview"><?php esc_html_e('物件概要', 'sanai-textdomain'); ?></h2>
            <table class="property-spec__table">
                <tbody>
                    <?php
                    $overview = [
                        'name' => '物件名称',
                        'land_right' => '土地権利',
                        'type' => '物件種別',
                        'land_size' => '土地面積',
                        'units' => '販売棟数',
                        'floor_size' => '物件（専有）面積',
                        'layout' => '間取',
                        'structure' => '建物構造',
                        'completion' => '完成',
                        'parking' => '駐車場',
                        'transaction' => '取引態様',
                        'road' => '接道状況',
                        'zone' => '用途地域',
                        'coverage' => '建ぺい率',
                        'floor_area' => '容積率',
                        'management_cmp' => '管理会社',
                        'management_form' => '管理形態',
                        'fee' => 'マンション管理費',
                        'repair' => '修繕費関係',
                        'note' => '備考'
                    ];
                    foreach ($overview as $k => $label) {
                        printf(
                            '<tr><th>%1$s</th><td>%2$s</td></tr>',
                            esc_html($label),
                            sanai_nl2br_safe(get_post_meta(get_the_ID(), 'ov_' . $k, true))
                        );
                    }
                    ?>
                </tbody>
            </table>
        </section>

    </article>
</main>

<?php get_footer(); ?>