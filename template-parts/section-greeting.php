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
  <h2 class="section-title">代表挨拶</h2>
  <div class="greeting__inner">
    <!-- 代表写真を中央に大きく -->
    <figure class="greeting__figure">
      <img
        src="<?php echo get_template_directory_uri(); ?>/assets/img/test.jpg"
        alt="代表者写真"
        class="greeting__image"
      >
    </figure>

    <!-- 挨拶メッセージ -->
    <div class="greeting__message">
      <p>
        当社は不動産管理を通じて、お客様に安心と信頼をお届けすることを使命としています。
        これからも社員一同、誠実かつ迅速に対応してまいります。
      </p>
      <!-- 右下に署名 -->
      <p class="greeting__signature">代表&nbsp;○○&nbsp;○○</p>
    </div>
  </div>
</section>
