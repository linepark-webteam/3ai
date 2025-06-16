<?php

/**
 * Archive template for Property  (物件一覧ページ)
 * template-parts/archive-property.php
 * 
 * @package Sanai_WP_Theme
 * @since 1.0.0
 */
get_header();
?>

<main id="mainContent" class="archive-property">

    <!-- Subhero -->
    <?php get_template_part('template-parts/section', 'subhero'); ?>

    <section id="propertyList" class="property-list section container">

        <?php if (have_posts()) : ?>
            <ul class="property-list__items">
                <?php while (have_posts()) : the_post(); ?>
                    <?php
                    // カスタムフィールド取得
                    $price    = get_post_meta(get_the_ID(), 'price', true);
                    $location = get_post_meta(get_the_ID(), 'location', true);
                    // サムネイル処理
                    if (has_post_thumbnail()) {
                        $thumb = get_the_post_thumbnail(get_the_ID(), 'medium', [
                            'class' => 'property-list__thumbnail',
                            'alt'   => the_title_attribute(['echo' => false]),
                        ]);
                    } else {
                        $thumb = '<img src="' . esc_url(get_template_directory_uri() . '/assets/img/no-image.png') . '"'
                            . ' alt="' . esc_attr__('No Image', 'sanai-textdomain') . '"'
                            . ' class="property-list__thumbnail" />';
                    }
                    ?>

                    <li class="property-list__item">
                        <a href="<?php the_permalink(); ?>" class="property-list__link">
                            <figure class="property-list__image">
                                <?php echo $thumb; ?>
                            </figure>
                            <div class="property-list__info">
                                <h2 class="property-list__title"><?php the_title(); ?></h2>

                                <?php if ($price) : ?>
                                    <p class="property-list__price">
                                        <?php
                                        // 数値は3桁区切りに
                                        echo esc_html(number_format($price));
                                        ?>
                                        <?php esc_html_e('万円', 'sanai-textdomain'); ?>
                                    </p>
                                <?php endif; ?>

                                <?php if ($location) : ?>
                                    <p class="property-list__location">
                                        <?php echo esc_html($location); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>

            <nav class="pagination" role="navigation">
                <?php
                the_posts_pagination([
                    'mid_size'  => 2,
                    'prev_text' => __('« 前へ', 'sanai-textdomain'),
                    'next_text' => __('次へ »', 'sanai-textdomain'),
                ]);
                ?>
            </nav>

        <?php else : ?>
            <p><?php esc_html_e('現在、物件情報はありません。', 'sanai-textdomain'); ?></p>
        <?php endif; ?>
    </section>

    <!-- CTA -->
    <?php get_template_part('template-parts/section', 'cta'); ?>

</main>

<?php get_footer(); ?>