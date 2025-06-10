<?php
/**
 * Service セクション用テンプレートパーツ
 * template-parts/section-service.php
 * 
 * @package Sanai_WP_Theme
 * @since 1.0.0
 */
?>
<section id="service" class="service section container">
  <div class="section-head">
    <h2 class="section-title">
      <?php esc_html_e( 'サービス', 'sanai-textdomain' ); ?>
    </h2>
    <p class="section-subtitle">
      <?php esc_html_e( 'お客様のニーズに合わせた多彩なサービスを提供します。', 'sanai-textdomain' ); ?>
    </p>
  </div>

  <div class="service__grid">
    <div class="service__item">
      <i class="bi bi-speedometer2 service__icon"></i>
      <h3 class="service__item-title">
        <?php esc_html_e( 'スピード対応', 'sanai-textdomain' ); ?>
      </h3>
      <p class="service__item-text">
        <?php esc_html_e( 'お問い合わせから対応まで迅速にご案内。緊急時にも安心です。', 'sanai-textdomain' ); ?>
      </p>
    </div>

    <div class="service__item">
      <i class="bi bi-shield-lock service__icon"></i>
      <h3 class="service__item-title">
        <?php esc_html_e( '安心・信頼', 'sanai-textdomain' ); ?>
      </h3>
      <p class="service__item-text">
        <?php esc_html_e( '長年の実績と実務経験で、確かなサポートをお約束します。', 'sanai-textdomain' ); ?>
      </p>
    </div>

    <div class="service__item">
      <i class="bi bi-people service__icon"></i>
      <h3 class="service__item-title">
        <?php esc_html_e( '専門チーム', 'sanai-textdomain' ); ?>
      </h3>
      <p class="service__item-text">
        <?php esc_html_e( '経験豊富な専門スタッフが万全の体制で対応します。', 'sanai-textdomain' ); ?>
      </p>
    </div>
  </div>

  <div class="service-banner text-center">
    <a href="<?php echo esc_url( home_url( '/service/' ) ); ?>" class="service-banner__link">
      <p class="service-banner__text">
        <?php esc_html_e( 'サービス詳細を見る', 'sanai-textdomain' ); ?>
      </p>
    </a>
  </div>
</section>
