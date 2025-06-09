<?php
/**
 * template-parts/content.php
 *
 * 汎用的な投稿ループ用テンプレート
 * （アーカイブ・シングル・メインループなど幅広く使えるひな形）
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// "post"、カスタム投稿タイプ、固定ページ、添付ファイルページなどすべてに対応
$post_type = get_post_type();

// 投稿タイプごとにクラスを追加したい場合は、下記のようにすると良いでしょう。
// 例: <article class="post hentry post-type-post"> あるいは post-type-movie, post-type-page など
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( "post-type-{$post_type}" ); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail( 'medium_large' ); // 必要に応じてサイズを変更 ?>
            </a>
        </div>
    <?php endif; ?>

    <header class="entry-header">
        <?php
        // アーカイブページやループ一覧なら h2、シングルページなら h1 を使いたい場合
        if ( is_singular() ) :
            the_title( '<h1 class="entry-title">', '</h1>' );
        else :
            the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
        endif;
        ?>

        <div class="entry-meta">
            <span class="posted-on">
                <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                    <?php echo esc_html( get_the_date() ); ?>
                </time>
            </span>
            <?php if ( 'post' === $post_type ) : // 投稿タイプが「post」のときだけ表示 ?>
                <span class="posted-by">
                    <?php 
                    /* translators: %s: 投稿者名 */
                    printf( __( 'by %s', 'sanai-textdomain' ), '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>' );
                    ?>
                </span>
                <span class="cat-links">
                    <?php 
                    /* translators: %s: カテゴリリスト */
                    printf( __( 'Posted in %s', 'sanai-textdomain' ), get_the_category_list( ', ' ) );
                    ?>
                </span>
            <?php endif; ?>
        </div><!-- .entry-meta -->
    </header>

    <div class="entry-content">
        <?php
        if ( is_singular() ) :
            // シングルページなら本文を全文表示
            the_content();

            // ページ送りリンク（<!--nextpage--> が本文にあれば使う）
            wp_link_pages( array(
                'before' => '<div class="page-links">' . __( 'Pages:', 'sanai-textdomain' ),
                'after'  => '</div>',
            ) );
        else :
            // 一覧表示やアーカイブでは抜粋を表示（必要なら <a> をつける）
            the_excerpt();
        endif;
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php if ( 'post' === $post_type ) : ?>
            <span class="tags-links">
                <?php
                /* translators: %s: タグリスト */
                printf( __( 'Tagged %s', 'sanai-textdomain' ), get_the_tag_list( '', ', ' ) );
                ?>
            </span>
        <?php endif; ?>

        <?php
        // 編集リンク（管理者などが表示するとき）
        edit_post_link(
            sprintf(
                /* translators: %s: 投稿タイトル */
                __( 'Edit <span class="screen-reader-text">%s</span>', 'sanai-textdomain' ),
                get_the_title()
            ),
            '<span class="edit-link">',
            '</span>'
        );
        ?>
    </footer><!-- .entry-footer -->
</article>
