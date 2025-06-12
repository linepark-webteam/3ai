<?php
/**
 * template-parts/section-greeting.php
 * 会社概要 代表挨拶 用テンプレートパーツ
 *
 * @package Sanai_WP_Theme
 * @since 1.0.0
 */
?>

<section class="greeting section container">
  <h2 class="section-title">
    <?php esc_html_e( '代表挨拶', 'sanai-textdomain' ); ?>
  </h2>
  <div class="greeting__inner">
    <figure class="greeting__figure">
      <img
        src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/test.jpg' ); ?>"
        alt="<?php esc_attr_e( '代表者写真', 'sanai-textdomain' ); ?>"
        class="greeting__image"
      >
    </figure>

    <div class="greeting__message">
      <p>
        <?php
          /* 翻訳可能な長文は __() で返り値取得し、esc_html_e() で表示してもOK */
          echo esc_html__(
            '当社は不動産管理を通じて、お客様に安心と信頼をお届けすることを使命としています。これからも社員一同、誠実かつ迅速に対応してまいります。',
            'sanai-textdomain'
          );
        ?>
      </p>
      <p class="greeting__signature">
        <?php esc_html_e( '代表 ○○ ○○', 'sanai-textdomain' ); ?>
      </p>
    </div>
  </div>
</section>
