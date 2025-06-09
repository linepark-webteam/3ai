<?php
/**
 * フロントページ用テンプレート (template-parts/front-page.php)
 */

get_header();
?>

<main>
  <!-- Hero セクション -->
  <section id="hero" class="hero">
    <div class="hero__overlay"></div>
    <div class="hero__inner container text-center">
      <h1 class="hero__title"><?php bloginfo( 'name' ); ?></h1>
      <p class="hero__subtitle"><?php bloginfo( 'description' ); ?></p>
      <a href="#service" class="btn btn--cta"><?php esc_html_e( 'サービスをみる', 'sanai-textdomain' ); ?></a>
    </div>
  </section>

  <!-- Service セクション -->
  <section id="service" class="service section container">
    <div class="section-head">
      <h2 class="section-title"><?php esc_html_e( 'サービス', 'sanai-textdomain' ); ?></h2>
      <p class="section-subtitle"><?php esc_html_e( 'お客様のニーズに合わせた多彩なサービスを提供します。', 'sanai-textdomain' ); ?></p>
    </div>
    <div class="service__grid">
      <div class="service__item">
        <i class="bi bi-speedometer2 service__icon"></i>
        <h3 class="service__item-title"><?php esc_html_e( 'スピード対応', 'sanai-textdomain' ); ?></h3>
        <p class="service__item-text"><?php esc_html_e( 'お問い合わせから対応まで迅速にご案内。緊急時にも安心です。', 'sanai-textdomain' ); ?></p>
      </div>
      <div class="service__item">
        <i class="bi bi-shield-lock service__icon"></i>
        <h3 class="service__item-title"><?php esc_html_e( '安心・信頼', 'sanai-textdomain' ); ?></h3>
        <p class="service__item-text"><?php esc_html_e( '長年の実績と実務経験で、確かなサポートをお約束します。', 'sanai-textdomain' ); ?></p>
      </div>
      <div class="service__item">
        <i class="bi bi-people service__icon"></i>
        <h3 class="service__item-title"><?php esc_html_e( '専門チーム', 'sanai-textdomain' ); ?></h3>
        <p class="service__item-text"><?php esc_html_e( '経験豊富な専門スタッフが万全の体制で対応します。', 'sanai-textdomain' ); ?></p>
      </div>
    </div>
    <div class="service-banner text-center">
      <a href="<?php echo esc_url( home_url( '/service/' ) ); ?>" class="service-banner__link">
        <p class="service-banner__text"><?php esc_html_e( 'サービス詳細を見る', 'sanai-textdomain' ); ?></p>
      </a>
    </div>
  </section>

  <!-- Property Highlights セクション -->
  <section id="property" class="property section container">
    <div class="section-head">
      <h2 class="section-title"><?php esc_html_e( '最新物件', 'sanai-textdomain' ); ?></h2>
    </div>
    <div class="property__slider">
      <?php
      // カスタム投稿タイプ 'property' の最新 5 件を取得してスライダー表示
      $args = array(
        'post_type'      => 'property',
        'posts_per_page' => 5,
        'orderby'        => 'date',
        'order'          => 'DESC',
      );
      $slider_query = new WP_Query( $args );
      if ( $slider_query->have_posts() ) :
        while ( $slider_query->have_posts() ) : $slider_query->the_post();
          $img_id  = get_post_thumbnail_id();
          $img_url = wp_get_attachment_image_url( $img_id, 'medium' );
          $price   = get_post_meta( get_the_ID(), 'price', true );
      ?>
          <div class="property__card">
            <?php if ( $img_url ) : ?>
              <img
                src="<?php echo esc_url( $img_url ); ?>"
                alt="<?php the_title_attribute(); ?>"
                class="property__image"
              />
            <?php else : ?>
              <img
                src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/property01.webp"
                alt="<?php esc_attr_e( 'ダミー物件画像', 'sanai-textdomain' ); ?>"
                class="property__image"
              />
            <?php endif; ?>
            <div class="property__info">
              <h3 class="property__name"><?php the_title(); ?></h3>
              <p class="property__price"><?php echo esc_html( $price ); ?> <?php esc_html_e( '円～', 'sanai-textdomain' ); ?></p>
              <a
                href="<?php the_permalink(); ?>"
                class="btn btn--small"
              ><?php esc_html_e( '詳細を見る', 'sanai-textdomain' ); ?></a>
            </div>
          </div>
      <?php
        endwhile;
        wp_reset_postdata();
      else :
      ?>
        <p><?php esc_html_e( '現在、公開されている物件はありません。', 'sanai-textdomain' ); ?></p>
      <?php endif; ?>
    </div>
  </section>

<!-- Topics セクション -->
<section id="topics" class="topics section container">
  <div class="section-head">
    <h2 class="section-title"><?php esc_html_e( 'お知らせ', 'sanai-textdomain' ); ?></h2>
  </div>

  <ul class="topics__list">
    <?php
    // カスタムクエリの準備（paged を含める）
    $paged = get_query_var( 'paged', 1 );
    $news_args = array(
      'post_type'      => 'post',
      'posts_per_page' => 3,
      'orderby'        => 'date',
      'order'          => 'DESC',
      'paged'          => $paged,
    );
    $news_query = new WP_Query( $news_args );

    if ( $news_query->have_posts() ) :
      // メインクエリを退避し、グローバルを上書き
      $original_query = $wp_query;
      $wp_query       = $news_query;

      // ループ本体（<li>～</li> を出力）
      get_template_part( 'template-parts/content', 'loop' );

      // ループ終了後にリセット
      wp_reset_postdata();
      $wp_query = $original_query;
    else :
      // 投稿がない場合も <li> を出すため、content-loop.php の else 部分が出力される
      get_template_part( 'template-parts/content', 'loop' );
    endif;
    ?>
  </ul>

  <?php if ( $news_query->max_num_pages > 1 ) : ?>
    <nav class="topics__pagination" aria-label="<?php esc_attr_e( 'お知らせのページナビゲーション', 'sanai-textdomain' ); ?>">
      <?php
      // グローバル $wp_query には一時的に $news_query が入っている想定なので、the_posts_pagination() が効く
      // ただし、wp_reset_postdata() 後に $wp_query は戻っているため、再度クエリオブジェクトを渡すか
      // get_the_posts_pagination() 関数を使う方法もあります。ここでは簡潔に get_the_posts_pagination() を利用。

      echo get_the_posts_pagination( array(
        'mid_size'  => 1,
        'prev_text' => __( '« 前へ', 'sanai-textdomain' ),
        'next_text' => __( '次へ »', 'sanai-textdomain' ),
      ) );
      ?>
    </nav>
  <?php endif; ?>

  <div class="topics__more text-end">
    <a href="<?php echo esc_url( home_url( '/topics/' ) ); ?>" class="topics__more-link"><?php esc_html_e( '一覧を見る', 'sanai-textdomain' ); ?></a>
  </div>
</section>


  <!-- Recruit バナー -->
  <section id="recruit" class="recruit-banner">
    <div class="recruit-banner__overlay"></div>
    <div class="recruit-banner__inner container text-center">
      <h2 class="recruit-banner__title"><?php esc_html_e( '一緒に働きませんか？', 'sanai-textdomain' ); ?></h2>
      <p class="recruit-banner__text"><?php esc_html_e( '未経験者歓迎！経験者優遇！まずはご応募ください。', 'sanai-textdomain' ); ?></p>
      <a href="<?php echo esc_url( home_url( '/recruit/' ) ); ?>" class="btn btn--large"><?php esc_html_e( '採用情報をみる', 'sanai-textdomain' ); ?></a>
    </div>
  </section>

  <!-- CTA セクション -->
  <section id="contact" class="cta section">
    <div class="container text-center">
      <h2 class="cta__title"><?php esc_html_e( 'お問い合わせ', 'sanai-textdomain' ); ?></h2>
      <p class="cta__tel"><a href="tel:0123-456-789">0123-456-789</a></p>
      <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn--cta"><?php esc_html_e( 'お問い合わせはこちら', 'sanai-textdomain' ); ?></a>
    </div>
  </section>
</main>

<?php
get_footer();
