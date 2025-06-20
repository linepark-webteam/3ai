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
    <?php esc_html_e('代表挨拶', 'sanai-textdomain'); ?>
  </h2>
  <div class="greeting__inner">
    <figure class="greeting__figure">
      <img
        src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/test.jpg'); ?>"
        alt="<?php esc_attr_e('代表者写真', 'sanai-textdomain'); ?>"
        class="greeting__image">
    </figure>

    <div class="greeting__message">
      <p>
        <?php echo esc_html__('大切なお客さまへ', 'sanai-textdomain'); ?>
        <br>
        <?php echo esc_html__('日頃よりご愛顧賜り誠に有難うございます。', 'sanai-textdomain'); ?>
        <br>
        <?php echo esc_html__('私たちは、前身の有限会社三愛不動産で培った地域密着のお客様サービスを継承し', 'sanai-textdomain'); ?>
        <br>
        <?php echo esc_html__('さらなるサービスの向上と新しい価値の提供を目指して、株式会社三愛不動産管理として', 'sanai-textdomain'); ?>
        <br>
        <?php echo esc_html__('新しいスタートを開始いたしました。', 'sanai-textdomain'); ?>
        </p>
        <br>
        <?php echo esc_html__('不動産の管理・賃貸募集・駐車場管理のノウハウを引き継ぎながら', 'sanai-textdomain'); ?>
        <br>
        <?php echo esc_html__('売買仲介やコンサルティング、リフォーム提案等の多岐にわたる不動産ソリューションの', 'sanai-textdomain'); ?>
        <br>
        <?php echo esc_html__('窓口となれるよう、お客様への価値の提供を通じて、社会貢献に努めてまいります。', 'sanai-textdomain'); ?>
      </p>
      <p class="greeting__signature">
        <?php esc_html_e('代表取締役', 'sanai-textdomain'); ?>
        <br>
        <?php esc_html_e('天久 太郎', 'sanai-textdomain'); ?>
      </p>
    </div>
  </div>
</section>