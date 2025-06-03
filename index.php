<?php
/**
 * フロントページ用のテンプレート（index.php）
 * フロントページ設定が「最新の投稿を表示」になっている場合はこちらが適用されます。
 * 固定ページをフロントに設定する場合は front-page.php を作成するか、
 * ここに is_front_page() 条件分岐で処理を分けてもOKです。
 */

get_header();
?>

<main>
  <!-- Hero セクション -->
  <section id="hero" class="hero">
    <div class="hero__overlay"></div>
    <div class="hero__inner container text-center">
      <!-- 固定テキストの例。固定ページのカスタムフィールドなどから取得してもよい -->
      <h1 class="hero__title"><?php bloginfo( 'name' ); ?></h1>
      <p class="hero__subtitle"><?php bloginfo( 'description' ); ?></p>
      <a href="#service" class="btn btn--cta">サービスをみる</a>
    </div>
  </section>

  <!-- Service セクション -->
  <section id="service" class="service section container">
    <div class="section-head">
      <h2 class="section-title">サービス</h2>
      <p class="section-subtitle">お客様のニーズに合わせた多彩なサービスを提供します。</p>
    </div>
    <div class="service__grid">
      <div class="service__item">
        <i class="bi bi-speedometer2 service__icon"></i>
        <h3 class="service__item-title">スピード対応</h3>
        <p class="service__item-text">お問い合わせから対応まで迅速にご案内。緊急時にも安心です。</p>
      </div>
      <div class="service__item">
        <i class="bi bi-shield-lock service__icon"></i>
        <h3 class="service__item-title">安心・信頼</h3>
        <p class="service__item-text">長年の実績と実務経験で、確かなサポートをお約束します。</p>
      </div>
      <div class="service__item">
        <i class="bi bi-people service__icon"></i>
        <h3 class="service__item-title">専門チーム</h3>
        <p class="service__item-text">経験豊富な専門スタッフが万全の体制で対応します。</p>
      </div>
    </div>
    <!-- サービスバナー -->
    <div class="service-banner text-center">
      <a href="<?php echo esc_url( home_url( '/service/' ) ); ?>" class="service-banner__link">
        <p class="service-banner__text">サービス詳細を見る</p>
      </a>
    </div>
  </section>

  <!-- Property Highlights セクション -->
  <section id="property" class="property section container">
    <div class="section-head">
      <h2 class="section-title">最新物件</h2>
    </div>
    <div class="property__slider">
      <?php
      // 例：カスタム投稿タイプ 'property' の最新 5 件を取得してスライダー表示
      $args = array(
        'post_type'      => 'property',
        'posts_per_page' => 5,
        'orderby'        => 'date',
        'order'          => 'DESC',
      );
      $slider_query = new WP_Query( $args );
      if ( $slider_query->have_posts() ) :
        while ( $slider_query->have_posts() ) : $slider_query->the_post();
          // カスタムフィールドなどで画像と価格を用意している前提
          $img_id   = get_post_thumbnail_id();
          $img_url  = wp_get_attachment_image_url( $img_id, 'medium' );
          $price    = get_post_meta( get_the_ID(), 'price', true );
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
                alt="ダミー物件画像"
                class="property__image"
              />
            <?php endif; ?>
            <div class="property__info">
              <h3 class="property__name"><?php the_title(); ?></h3>
              <p class="property__price"><?php echo esc_html( $price ); ?> 円～</p>
              <a
                href="<?php the_permalink(); ?>"
                class="btn btn--small"
              >詳細を見る</a>
            </div>
          </div>
      <?php
        endwhile;
        wp_reset_postdata();
      else :
        ?>
        <p>現在、公開されている物件はありません。</p>
      <?php endif; ?>
    </div>
  </section>

  <!-- Topics セクション -->
  <section id="topics" class="topics section container">
    <div class="section-head">
      <h2 class="section-title">お知らせ</h2>
    </div>
    <ul class="topics__list">
      <?php
      // 例：通常投稿（post）の最新 3 件を表示
      $news_args = array(
        'post_type'      => 'post',
        'posts_per_page' => 3,
        'orderby'        => 'date',
        'order'          => 'DESC',
      );
      $news_query = new WP_Query( $news_args );
      if ( $news_query->have_posts() ) :
        while ( $news_query->have_posts() ) : $news_query->the_post();
      ?>
          <li class="topics__item">
            <time class="topics__date" datetime="<?php echo get_the_date( 'Y-m-d' ); ?>">
              <?php echo get_the_date( 'Y.m.d' ); ?>
            </time>
            <a href="<?php the_permalink(); ?>" class="topics__link"><?php the_title(); ?></a>
          </li>
      <?php
        endwhile;
        wp_reset_postdata();
      else :
        ?>
        <li class="topics__item">現在、お知らせはありません。</li>
      <?php endif; ?>
    </ul>
    <div class="topics__more text-end">
      <a href="<?php echo esc_url( home_url( '/topics/' ) ); ?>" class="topics__more-link">一覧を見る</a>
    </div>
  </section>

  <!-- Recruit バナー -->
  <section id="recruit" class="recruit-banner">
    <div class="recruit-banner__overlay"></div>
    <div class="recruit-banner__inner container text-center">
      <h2 class="recruit-banner__title">一緒に働きませんか？</h2>
      <p class="recruit-banner__text">未経験者歓迎！経験者優遇！まずはご応募ください。</p>
      <a href="<?php echo esc_url( home_url( '/recruit/' ) ); ?>" class="btn btn--large">採用情報をみる</a>
    </div>
  </section>

  <!-- CTA セクション -->
  <section id="contact" class="cta section">
    <div class="container text-center">
      <h2 class="cta__title">お問い合わせ</h2>
      <p class="cta__tel"><a href="tel:0123-456-789">0123-456-789</a></p>
      <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn--cta">お問い合わせはこちら</a>
    </div>
  </section>
</main>

<?php
get_footer();
