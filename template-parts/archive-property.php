<?php

/**
 * Archive template for Property (物件一覧ページ)
 * template-parts/archive-property.php
 *
 * @package Sanai_WP_Theme
 * @since   1.0.0
 */
get_header();

/** ユーティリティ: 改行を <br> に変換して安全に返す */
function sanai_nl2br_safe(string $value, string $placeholder = '—')
{
    if ($value === '') return esc_html($placeholder);
    return wp_kses_post(nl2br(esc_html($value))); // <br> だけ許可
}
?>

<main id="mainContent" class="archive-property">

    <!-- Sub-hero -->
    <?php get_template_part('template-parts/section', 'subhero'); ?>

    <section id="propertyList" class="property-list section container">

        <?php if (have_posts()) : ?>
            <ul class="property-list__items">
                <?php while (have_posts()) : the_post(); ?>

                    <?php
                    /*──────── 1. カスタムフィールド値 ────────*/
                    $price   = get_post_meta(get_the_ID(), 'price',   true);
                    $address = get_post_meta(get_the_ID(), 'address', true);
                    $access  = get_post_meta(get_the_ID(), 'access',  true);

                    /*──────── 2. 改行を保持した表示用変数 ───*/
                    $placeholder = __('—', 'sanai-textdomain');

                    $title_display   = sanai_nl2br_safe(get_the_title(), $placeholder);
                    $address_display = sanai_nl2br_safe($address,        $placeholder);
                    $access_display  = sanai_nl2br_safe($access,         $placeholder);
                    $price_display   = sanai_nl2br_safe($price,          $placeholder);

                    /*──────── 3. サムネイル取得 ────────*/
                    $thumb_args = [
                        'class' => 'property-list__thumbnail',
                        'alt'   => the_title_attribute(['echo' => false]),
                    ];

                    if (has_post_thumbnail()) {
                        $thumb = get_the_post_thumbnail(get_the_ID(), 'medium', $thumb_args);
                    } else {
                        $ids = (array) get_post_meta(get_the_ID(), 'property_images', true);
                        if (! empty($ids)) {
                            $thumb = wp_get_attachment_image($ids[0], 'medium', false, $thumb_args);
                        } else {
                            $thumb = sprintf(
                                '<img src="%s" alt="%s" class="%s" />',
                                esc_url(get_template_directory_uri() . '/assets/img/coming-soon.png'),
                                esc_attr__('Coming Soon', 'sanai-textdomain'),
                                esc_attr($thumb_args['class'])
                            );
                        }
                    }
                    ?>

                    <li class="property-list__item">
                        <a href="<?php the_permalink(); ?>" class="property-list__link">

                            <!-- 画像 -->
                            <figure class="property-list__image">
                                <?php echo $thumb; ?>
                            </figure>

                            <div class="property-list__info">
                                <!-- タイトル -->
                                <h2 class="property-list__title"><?php echo $title_display; ?></h2>

                                <!-- 住所 -->
                                <p class="property-list__address">
                                    <i class="bi bi-geo-alt-fill me-1"></i>
                                    <?php echo $address_display; ?>
                                </p>

                                <!-- アクセス -->
                                <p class="property-list__access">
                                    <i class="bi bi-train-front-fill me-1"></i>
                                    <?php echo $access_display; ?>
                                </p>

                                <!-- 価格 -->
                                <p class="property-list__price">
                                    <i class="bi bi-currency-yen me-1"></i>
                                    <?php echo $price_display; ?>
                                </p>
                            </div>
                        </a>
                    </li>

                <?php endwhile; ?>
            </ul>

            <!-- ページネーション -->
            <?php
            echo get_the_posts_pagination(
                [
                    'mid_size'           => 2,
                    'prev_text'          => __('« 前へ', 'sanai-textdomain'),
                    'next_text'          => __('次へ »', 'sanai-textdomain'),
                    'screen_reader_text' => __('物件一覧ページナビゲーション', 'sanai-textdomain'),
                ]
            );
            ?>

        <?php else : ?>
            <p><?php esc_html_e('現在、物件情報はありません。', 'sanai-textdomain'); ?></p>
        <?php endif; ?>
    </section>

    <!-- CTA -->
    <?php get_template_part('template-parts/section', 'cta'); ?>

</main>

<?php get_footer(); ?>