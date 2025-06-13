<?php
/**
 * template-parts/section-map.php
 * 会社概要 所在地地図 用テンプレートパーツ
 *
 * @package Sanai_WP_Theme
 * @since 1.0.0
 */
?>

<section class="map section container">
  <h2 class="section-title">
    <?php esc_html_e( '所在地地図', 'sanai-textdomain' ); ?>
  </h2>
  <div class="map__embed">
    <iframe
      src="<?php echo esc_url( 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6498.335674664501!2d139.5454925!3d35.475391!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x601859c6feac5afb%3A0x2f2e2314bf1a2f50!2z44CSMjQxLTAwMjIg56We5aWI5bed55yM5qiq5rWc5biC5pet5Yy66ba044Kx5bOw77yS5LiB55uu77yS4oiS77yT!5e0!3m2!1sja!2sjp!4v1749773753804!5m2!1sja!2sjp' ); ?>"
      width="100%"
      height="450"
      style="border:0;"
      allowfullscreen=""
      loading="lazy"
      referrerpolicy="no-referrer-when-downgrade"
    ></iframe>
  </div>
</section>
