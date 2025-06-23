<?php
/**
 * Archive template for Property (物件一覧ページ)
 * template-parts/archive-property.php
 *
 * @package Sanai_WP_Theme
 * @since   1.0.0
 */
get_header();
?>

<main id="mainContent" class="archive-property">

  <!-- Sub-hero -->
  <?php get_template_part( 'template-parts/section', 'subhero' ); ?>

  <section id="propertyList" class="property-list section container">

    <?php if ( have_posts() ) : ?>
      <ul class="property-list__items">
        <?php while ( have_posts() ) : the_post(); ?>

          <?php
          /*──────── カスタムフィールド取得 ────────*/
          $price   = get_post_meta( get_the_ID(), 'price',   true ); // 価格
          $address = get_post_meta( get_the_ID(), 'address', true ); // 住所
          $access  = get_post_meta( get_the_ID(), 'access',  true ); // アクセス

          /*──────── プレースホルダー ────────*/
          $placeholder         = __( '—', 'sanai-textdomain' );      // ダッシュ 1 本
          $address_display     = $address !== '' ? esc_html( $address )                     : $placeholder;
          $access_display      = $access  !== '' ? esc_html( $access  )                     : $placeholder;
          $price_display       = $price   !== '' ? esc_html( number_format( $price ) ) . __( '万円', 'sanai-textdomain' )
                                                 : $placeholder;

          /*──────── サムネイル処理 ────────*/
          if ( has_post_thumbnail() ) {
            $thumb = get_the_post_thumbnail(
              get_the_ID(),
              'medium',
              [
                'class' => 'property-list__thumbnail',
                'alt'   => the_title_attribute( [ 'echo' => false ] ),
              ]
            );
          } else {
            $thumb = '<img src="' . esc_url( get_template_directory_uri() . '/assets/img/no-image.png' ) . '"'
                   . ' alt="' . esc_attr__( 'No Image', 'sanai-textdomain' ) . '"'
                   . ' class="property-list__thumbnail" />';
          }
          ?>

          <li class="property-list__item">
            <a href="<?php the_permalink(); ?>" class="property-list__link">

              <!-- 1. 画像 -->
              <figure class="property-list__image">
                <?php echo $thumb; ?>
              </figure>

              <div class="property-list__info">
                <!-- 2. タイトル -->
                <h2 class="property-list__title"><?php the_title(); ?></h2>

                <!-- 3. 住所（空でも表示） -->
                <p class="property-list__address">
                  <i class="bi bi-geo-alt-fill me-1"></i>
                  <?php echo $address_display; ?>
                </p>

                <!-- 4. アクセス（空でも表示） -->
                <p class="property-list__access">
                  <i class="bi bi-train-front-fill me-1"></i>
                  <?php echo $access_display; ?>
                </p>

                <!-- 5. 価格（空でも表示） -->
                <p class="property-list__price">
                  <i class="bi bi-currency-yen me-1"></i>
                  <?php echo $price_display; ?>
                </p>
              </div>
            </a>
          </li>

        <?php endwhile; ?>
      </ul>

      <!-- ページネーション -->
      <?php
      echo get_the_posts_pagination( [
        'mid_size'           => 2,
        'prev_text'          => __( '« 前へ', 'sanai-textdomain' ),
        'next_text'          => __( '次へ »',  'sanai-textdomain' ),
        'screen_reader_text' => __( '物件一覧ページナビゲーション', 'sanai-textdomain' ),
      ] );
      ?>

    <?php else : ?>
      <p><?php esc_html_e( '現在、物件情報はありません。', 'sanai-textdomain' ); ?></p>
    <?php endif; ?>
  </section>

  <!-- CTA -->
  <?php get_template_part( 'template-parts/section', 'cta' ); ?>

</main>

<?php get_footer(); ?>
