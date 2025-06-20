<?php
/**
 * TOPページ Service セクション
 *
 * @package Sanai_WP_Theme
 * @since 1.0.0
 */

/* 事業内容リスト */
$services = [
	[
		'jp'   => '賃貸管理・仲介',
		'icon' => 'bi-building-check',
		'slug' => 'management',
	],
	[
		'jp'   => '駐車場運営',
		'icon' => 'bi-p-square',
		'slug' => 'parking',
	],
	[
		'jp'   => '売買仲介',
		'icon' => 'bi-key',
		'slug' => 'brokerage',
	],
	[
		'jp'   => '査定・買取',
		'icon' => 'bi-clipboard-data',
		'slug' => 'appraisal',
	],
	[
		'jp'   => '資産コンサル',
		'icon' => 'bi-graph-up-arrow',
		'slug' => 'consulting',
	],
	[
		'jp'   => 'リフォーム提案',
		'icon' => 'bi-hammer',
		'slug' => 'renovation',
	],
];
?>

<section id="service" class="service section container">
	<div class="section-head">
		<h2 class="section-title"><?php esc_html_e( 'サービス', 'sanai-textdomain' ); ?></h2>
		<p class="section-subtitle">
			<?php esc_html_e( 'ワンストップで資産価値を最大化する 6 つのサービス', 'sanai-textdomain' ); ?>
		</p>
	</div>

	<ul class="service__grid">
		<?php foreach ( $services as $service ) : ?>
			<li class="service__item">
				<i class="service__icon bi <?php echo esc_attr( $service['icon'] ); ?>"></i>
				<h3 class="service__item-title"><?php echo esc_html( $service['jp'] ); ?></h3>
			</li>
		<?php endforeach; ?>
	</ul>

	<div class="service-banner text-center">
		<a href="<?php echo esc_url( home_url( '/service/' ) ); ?>" class="service-banner__link">
			<?php esc_html_e( 'サービス詳細を見る', 'sanai-textdomain' ); ?>
		</a>
	</div>
</section>
