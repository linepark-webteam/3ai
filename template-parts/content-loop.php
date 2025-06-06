<?php
/**
 * template-parts/content-loop.php
 * 
 * 通常投稿（post）のループを共通化する部分テンプレート
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class( 'topics__item' ); ?>>
            <time class="topics__date" datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>">
                <?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?>
            </time>
            <a href="<?php the_permalink(); ?>" class="topics__link">
                <?php the_title(); ?>
            </a>
        </article>
        <?php
    endwhile;

    // ページナビゲーションを追加
    the_posts_pagination( array(
        'mid_size'  => 2, // 現在ページの前後に表示するページ番号の数
        'prev_text' => __( '« 前へ', 'sanai-textdomain' ),
        'next_text' => __( '次へ »', 'sanai-textdomain' ),
    ) );

else :
    ?>
    <p class="no-posts"><?php esc_html_e( '投稿がありません。', 'sanai-textdomain' ); ?></p>
    <?php
endif;
