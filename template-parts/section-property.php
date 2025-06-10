<?php
/**
 * template-parts/section-property.php
 * Property Highlights セクション用テンプレートパーツ
 * 
 * @package Sanai_WP_Theme
 * @since 1.0.0
 */
?>
<section id="property" class="property section container">
  <div class="section-head">
    <h2 class="section-title"><?php esc_html_e('最新物件', 'sanai-textdomain'); ?></h2>
  </div>
  <div class="property__slider">
    <?php
    $args = [
      'post_type'      => 'property',
      'posts_per_page' => 5,
      'orderby'        => 'date',
      'order'          => 'DESC',
    ];
    $slider_query = new WP_Query($args);
    if ($slider_query->have_posts()) :
      while ($slider_query->have_posts()) : $slider_query->the_post();
        // 画像・価格は前と同じ取得方法
        $img_id  = get_post_thumbnail_id();
        $img_url = wp_get_attachment_image_url($img_id, 'medium');
        $price   = get_post_meta(get_the_ID(), 'price', true);
    ?>
      <div class="property__card">
        <!-- 画像表示 -->
        <?php if ($img_url) : ?>
          <img src="<?php echo esc_url($img_url); ?>"
               alt="<?php the_title_attribute(); ?>"
               class="property__image" />
        <?php else : ?>
          <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/property01.webp"
               alt="<?php esc_attr_e('ダミー物件画像', 'sanai-textdomain'); ?>"
               class="property__image" />
        <?php endif; ?>
        <div class="property__info">
          <h3 class="property__name"><?php the_title(); ?></h3>
          <p class="property__price">
            <?php echo esc_html($price); ?><?php esc_html_e('円～', 'sanai-textdomain'); ?>
          </p>
          <a href="<?php the_permalink(); ?>" class="btn btn--small">
            <?php esc_html_e('詳細を見る', 'sanai-textdomain'); ?>
          </a>
        </div>
      </div>
    <?php
      endwhile;
      wp_reset_postdata();
    else :
      echo '<p>' . esc_html__('現在、公開されている物件はありません。', 'sanai-textdomain') . '</p>';
    endif;
    ?>
  </div>
</section>
