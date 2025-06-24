<?php

/**
 * template-parts/single-property.php
 * Single Template for Property
 *
 * @package Sanai_WP_Theme
 * @since   1.0.0
 */
get_header();

/* ---------- ユーティリティ：改行付きテキストを安全に出力（空なら空文字） ---------- */
function sanai_nl2br_safe(string $val)
{
    if ($val === '') return '';
    return wp_kses_post(nl2br(esc_html($val)));
}
?>

<main id="mainContent" class="single-property section container">

    <article <?php post_class('property-detail'); ?>>

        <?php
        /* ====================== 1. 画像 ====================== */
        $gallery_ids = (array) get_post_meta(get_the_ID(), 'property_images', true);

        if (has_post_thumbnail()) {
            $main_img = get_the_post_thumbnail(get_the_ID(), 'large', ['class' => 'property-main-img']);
        } elseif (! empty($gallery_ids)) {
            $main_img = wp_get_attachment_image($gallery_ids[0], 'large', false, ['class' => 'property-main-img']);
        } else {
            $main_img = sprintf(
                '<img src="%s" alt="%s" class="property-main-img" />',
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
                <ul class="property-gallery">
                    <?php foreach ($gallery_ids as $gid) : ?>
                        <li><?php echo wp_get_attachment_image($gid, 'thumbnail'); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <?php
        /* ====================== 2. サマリー用メタ ====================== */
        $meta_map = [
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
                foreach ($meta_map as $key => $label) {
                    // layout と floor_size は ov_ プレフィクスに合わせる
                    $meta_key = in_array($key, ['layout', 'floor_size'], true) ? 'ov_' . $key : $key;
                    $val      = get_post_meta(get_the_ID(), $meta_key, true);

                    printf(
                        '<li class="summary-item"><span class="summary-label">%1$s</span>：<span class="summary-value">%2$s</span></li>',
                        esc_html($label),
                        sanai_nl2br_safe($val)
                    );
                }
                ?>
            </ul>

        </header>


        <!-- ====================== 3. 物件概要 ====================== -->
        <section class="property-spec">
            <h2 class="property-overview"><?php esc_html_e('物件概要', 'sanai-textdomain'); ?></h2>
            <table class="property-spec__table">
                <tbody>
                    <?php
                    $overview_fields = [
                        'name'            => '物件名称',
                        'land_right'      => '土地権利',
                        'type'            => '物件種別',
                        'land_size'       => '土地面積',
                        'units'           => '販売棟数',
                        'floor_size'      => '物件（専有）面積',
                        'layout'          => '間取',
                        'structure'       => '建物構造',
                        'completion'      => '完成',
                        'parking'         => '駐車場',
                        'transaction'     => '取引態様',
                        'road'            => '接道状況',
                        'zone'            => '用途地域',
                        'coverage'        => '建ぺい率',
                        'floor_area'      => '容積率',
                        'management_cmp'  => '管理会社',
                        'management_form' => '管理形態',
                        'fee'             => 'マンション管理費',
                        'repair'          => '修繕費関係',
                        'note'            => '備考',
                    ];

                    foreach ($overview_fields as $key => $label) {
                        $val = get_post_meta(get_the_ID(), 'ov_' . $key, true);
                        printf(
                            '<tr><th>%1$s</th><td>%2$s</td></tr>',
                            esc_html($label),
                            sanai_nl2br_safe($val)
                        );
                    }
                    ?>
                </tbody>
            </table>
        </section>

    </article>
</main>

<?php get_footer(); ?>