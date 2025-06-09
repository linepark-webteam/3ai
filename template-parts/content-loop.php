<?php
/**
 * template-parts/content-loop.php
 * 
 * 通常投稿（post）のループを <li> 形式で出力する共通テンプレート
 * ※ページネーションは呼び出し側で出力する想定
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        ?>
        <li class="topics__item">
            <time class="topics__date" datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>">
                <?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?>
            </time>
            <a href="<?php the_permalink(); ?>" class="topics__link"><?php the_title(); ?></a>
        </li>
        <?php
    endwhile;
else :
    ?>
    <li class="topics__item"><?php esc_html_e( '投稿が見つかりません。', 'sanai-textdomain' ); ?></li>
    <?php
endif;
