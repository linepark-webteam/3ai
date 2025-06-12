<?php
/**
 * Template Name: Company Overview
 * Description: 会社概要ページテンプレート
 * @package Sanai_WP_Theme
 */
get_header();
?>

<!-- Subhero Section -->
<section class="subhero" style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/subhero-company.jpg');">
  <div class="subhero__overlay"></div>
  <div class="subhero__inner container text-center">
    <h1 class="subhero__title"><?php the_title(); ?></h1>
  </div>
</section>

<main id="mainContent">
  <!-- 代表挨拶 -->
  <section class="greeting section container">
    <h2 class="section-title">代表挨拶</h2>
    <div class="greeting__inner">
      <div class="greeting__image">
        <img src="<?php echo get_template_directory_uri(); ?>/img/representative.jpg" alt="代表者写真">
      </div>
      <div class="greeting__message">
        <p>当社は不動産管理を通じて、お客様に安心と信頼をお届けすることを使命としています。これからも社員一同、誠実かつ迅速に対応してまいります。</p>
      </div>
    </div>
  </section>

  <!-- 会社情報テーブル -->
  <section class="company-info section container">
    <h2 class="section-title">会社情報</h2>
    <table class="company-info__table">
      <tbody>
        <tr>
          <th>会社名</th>
          <td>三愛不動産管理</td>
        </tr>
        <tr>
          <th>設立</th>
          <td>YYYY年M月D日</td>
        </tr>
        <tr>
          <th>資本金</th>
          <td>X,XXX万円</td>
        </tr>
        <tr>
          <th>免許番号</th>
          <td>神奈川県知事（7）第21620号</td>
        </tr>
        <tr>
          <th>所在地</th>
          <td>横浜市旭区鶴ヶ峰2丁目2-3</td>
        </tr>
        <tr>
          <th>主要取引銀行</th>
          <td>〇〇銀行、△△銀行</td>
        </tr>
      </tbody>
    </table>
  </section>

  <!-- 社屋紹介 -->
  <section class="office section container">
    <h2 class="section-title">社屋紹介</h2>
    <div class="office__photo">
      <img src="<?php echo get_template_directory_uri(); ?>/img/office.jpg" alt="社屋写真">
      <p>当社社屋はJR松戸駅から徒歩5分。近代的なデザインのオフィスビル内に位置し、周辺には商業施設も充実しています。</p>
    </div>
  </section>

  <!-- 地図埋め込み -->
  <section class="map section container">
    <h2 class="section-title">所在地地図</h2>
    <div class="map__embed">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3240.1234567890123!2d139.9187654321!3d35.7890123456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60189a1234567890%3A0xabcdef1234567890!2z44CSMjYxLTAwMDEg44CS5a6_5bGx5YyP5Y6L5YyX5biC6Iqx5Yy66KW_5a6J5biC6YCa6Kmb55yM6aKY77yR5LiB55uu77yR77yR!5e0!3m2!1sja!2sjp!4v1591234567890" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
  </section>
</main>

<?php get_footer(); ?>
