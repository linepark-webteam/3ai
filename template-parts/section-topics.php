<?php
/**
 * template-parts/section-topics.php
 * Topics（お知らせ）セクション用テンプレートパーツ
 * 
 * @package Sanai_WP_Theme
 * @since 1.0.0
 */
?>
<section id="topics" class="topics section container">
  <div class="section-head">
    <h2 class="section-title"><?php esc_html_e('お知らせ', 'sanai-textdomain'); ?></h2>
  </div>
  <ul class="topics__list">
    <?php
    $paged = get_query_var('paged', 1);
    $args  = [
      'post_type'      => 'notice',
      'posts_per_page' => 5,
      'orderby'        => 'date',
      'order'          => 'DESC',
      'paged'          => $paged,
    ];
    $q = new WP_Query($args);
    if ($q->have_posts()) :
      while ($q->have_posts()) : $q->the_post();
        get_template_part('template-parts/content', 'notice');
      endwhile;
      wp_reset_postdata();
    else :
      echo '<li class="topics__item">' . esc_html__('お知らせはまだありません。', 'sanai-textdomain') . '</li>';
    endif;
    ?>
  </ul>

  <?php if ($q->max_num_pages > 1) : ?>
    <nav class="topics__pagination" aria-label="<?php esc_attr_e('お知らせ ページナビゲーション', 'sanai-textdomain'); ?>">
      <?php
      echo get_the_posts_pagination([
        'mid_size'  => 1,
        'prev_text' => __('« 前へ', 'sanai-textdomain'),
        'next_text' => __('次へ »', 'sanai-textdomain'),
        'screen_reader_text' => __('お知らせのページナビゲーション', 'sanai-textdomain'),
      ]);
      ?>
    </nav>
  <?php endif; ?>

  <div class="topics__more text-end">
    <a href="<?php echo esc_url(home_url('/topics/')); ?>"
       class="topics__more-link">
      <?php esc_html_e('一覧を見る', 'sanai-textdomain'); ?>
    </a>
  </div>
</section>
