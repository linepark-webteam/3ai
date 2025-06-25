<?php

/**
 * Template Name: プライバシーポリシーページ
 * Description: プライバシーポリシー専用の固定ページテンプレート
 *
 * @package Sanai_WP_Theme
 * @since 1.0.0
 */

get_header();
?>

<main id="mainContent" <?php post_class('page-privacy-policy'); ?>>

    <!-- Sub-hero（共通パーツを呼び出し） -->
    <?php get_template_part('template-parts/section', 'subhero'); ?>

    <!-- Privacy Policy 本文 -->
    <section id="privacyPolicy" class="privacy-policy section container">

        <!-- タイトル（WP エディタのタイトルを出力） -->
        <header class="section-head">
            <h1 class="section-title"><?php the_title(); ?></h1>
        </header>

        <?php
        /*--------------------------------------------------
     * 1. WP エディタで本文を管理する場合
     *-------------------------------------------------*/
        if (have_posts()) :
            while (have_posts()) :
                the_post(); ?>

                <article <?php post_class('privacy-policy__article'); ?>>
                    <?php the_content(); // WP エディタ本文 
                    ?>
                </article>

            <?php endwhile;

        /*--------------------------------------------------
     * 2. コード側で固定文言を用意する場合（空記事のとき）
     *-------------------------------------------------*/
        else : ?>

            <article class="privacy-policy__article">

                <h2><?php esc_html_e('個人情報の取扱いについて', 'sanai-textdomain'); ?></h2>
                <p><?php esc_html_e('ここにプライバシーポリシーの概要を記載してください。', 'sanai-textdomain'); ?></p>

                <h2><?php esc_html_e('1. 取得する個人情報', 'sanai-textdomain'); ?></h2>
                <p><?php esc_html_e('取得項目の例：氏名、住所、電話番号、メールアドレス 等', 'sanai-textdomain'); ?></p>

                <h2><?php esc_html_e('2. 個人情報の利用目的', 'sanai-textdomain'); ?></h2>
                <p><?php esc_html_e('利用目的をここに記載してください。', 'sanai-textdomain'); ?></p>

                <h2><?php esc_html_e('3. 管理方法', 'sanai-textdomain'); ?></h2>
                <p><?php esc_html_e('安全管理措置・委託管理などをここに記載してください。', 'sanai-textdomain'); ?></p>

                <h2><?php esc_html_e('4. 第三者提供について', 'sanai-textdomain'); ?></h2>
                <p><?php esc_html_e('第三者提供の有無や条件をここに記載してください。', 'sanai-textdomain'); ?></p>

                <h2><?php esc_html_e('5. 開示・訂正・削除請求', 'sanai-textdomain'); ?></h2>
                <p><?php esc_html_e('手続き方法をここに記載してください。', 'sanai-textdomain'); ?></p>

                <h2><?php esc_html_e('6. お問い合わせ窓口', 'sanai-textdomain'); ?></h2>
                <p><?php esc_html_e('会社名・部署・電話番号・メールアドレス等を記載してください。', 'sanai-textdomain'); ?></p>

            </article>

        <?php endif; ?>

    </section><!-- /#privacyPolicy -->

    <!-- CTA（共通パーツを呼び出し） -->
    <?php get_template_part('template-parts/section', 'cta'); ?>

</main>

<?php get_footer(); ?>