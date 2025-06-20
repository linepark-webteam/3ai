<?php

/**
 * Archive template for notice カスタム投稿タイプ
 * template-parts/archive-notice.php
 *
 * @package Sanai_WP_Theme
 * @since 1.0.0
 */
get_header();
?>

<main id="mainContent" class="archive-notice">

  <!-- Subhero -->
  <?php get_template_part('template-parts/section', 'subhero'); ?>

  <section id="noticeList" class="notice-list section container">
    <?php if (have_posts()) : ?>
      <ul class="notice__list">
        <?php
        // メインループ
        while (have_posts()) :
          the_post();
          // template-parts/content-notice.php を呼び出し
          get_template_part('template-parts/content', 'notice');
        endwhile;
        ?>
      </ul>

      <!-- ページネーション -->
  <?php
    // WP組み込みの<nav>をそのまま出力
    echo get_the_posts_pagination( [
      'mid_size'           => 1,
      'prev_text'          => __('« 前へ',    'sanai-textdomain'),
      'next_text'          => __('次へ »',   'sanai-textdomain'),
      'screen_reader_text' => __('お知らせのページナビゲーション', 'sanai-textdomain'),
    ] );
  ?>

    <?php else : ?>
      <p><?php esc_html_e('お知らせはまだありません。', 'sanai-textdomain'); ?></p>
    <?php endif; ?>
  </section>

</main>

<?php
get_footer();
