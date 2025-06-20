<?php
/**
 * Single Template for Property
 * @package Sanai_WP_Theme
 */
get_header();
?>

<main id="mainContent" class="single-property section container">

  <article <?php post_class( 'property-detail' ); ?>>

    <!-- ===== 画像エリア ===== -->
    <div class="property-images">
      <?php if ( has_post_thumbnail() ) : ?>
        <?php the_post_thumbnail( 'large', [ 'class' => 'property-main-img' ] ); ?>
      <?php else : ?>
        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/coming-soon.png' ); ?>"
             alt="<?php esc_attr_e( 'Coming Soon', 'sanai-textdomain' ); ?>"
             class="property-main-img" />
      <?php endif; ?>

      <?php
        $map = get_post_meta( get_the_ID(), 'map_image', true );
        if ( $map ) :
          printf(
            '<div class="property-map-thumb"><img src="%s" alt="%s"></div>',
            esc_url( $map ),
            esc_attr__( '地図', 'sanai-textdomain' )
          );
        endif;
      ?>
    </div>

    <!-- ===== タイトル & サマリー ===== -->
    <header class="property-head">
      <h1 class="property-title"><?php the_title(); ?></h1>
      <ul class="property-summary">
        <?php
          $summary_items = [
              'address'     => __( '所在地', 'sanai-textdomain' ),
              'nearest_stn' => __( '最寄駅', 'sanai-textdomain' ),
              'floor_plan'  => __( '間取り', 'sanai-textdomain' ),
              'area'        => __( '専有面積', 'sanai-textdomain' ),
              'price'       => __( '価格', 'sanai-textdomain' ),
          ];
          foreach ( $summary_items as $key => $label ) {
              $val = get_post_meta( get_the_ID(), $key, true );
              if ( $val ) :
                  printf(
                    '<li class="summary-item"><span class="summary-label">%1$s</span>：<span class="summary-value">%2$s</span></li>',
                    esc_html( $label ),
                    esc_html( $val )
                  );
              endif;
          }
        ?>
      </ul>

      <!-- お問い合わせボタン -->
      <a href="<?php echo esc_url( home_url( '/contact/?property_id=' . get_the_ID() ) ); ?>"
         class="btn btn-primary property-contact">
        <?php esc_html_e( 'Contact us', 'sanai-textdomain' ); ?>
      </a>
    </header>

    <!-- ===== おすすめポイント（本文） ===== -->
    <section class="property-points">
      <h2 class="section-title"><?php esc_html_e( 'おすすめポイント', 'sanai-textdomain' ); ?></h2>
      <?php the_content(); ?>
    </section>

    <!-- ===== 物件概要 ===== -->
    <section class="property-spec">
      <h2 class="section-title"><?php esc_html_e( '物件概要', 'sanai-textdomain' ); ?></h2>
      <table class="property-spec__table">
        <tbody>
          <?php
            $spec_items = [
              'built_year'  => __( '築年', 'sanai-textdomain' ),
              // 必要に応じて増やしてください
            ];
            foreach ( $spec_items as $key => $label ) {
              $val = get_post_meta( get_the_ID(), $key, true );
              if ( $val ) :
                printf(
                  '<tr><th>%1$s</th><td>%2$s</td></tr>',
                  esc_html( $label ),
                  esc_html( $val )
                );
              endif;
            }
          ?>
        </tbody>
      </table>
    </section>

  </article>
</main>

<?php get_footer(); ?>
