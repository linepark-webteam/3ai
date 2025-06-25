<?php

/**
 * template-parts/section-property.php
 * Property Highlights セクション
 *
 * @package Sanai_WP_Theme
 * @since   1.0.0
 */
?>
<section id="property" class="property section container">
	<div class="section-head">
		<h2 class="section-title"><?php esc_html_e('最新物件', 'sanai-textdomain'); ?></h2>
	</div>

	<?php
	$args = [
		'post_type'      => 'property',
		'posts_per_page' => 5,
		'orderby'        => 'date',
		'order'          => 'DESC',
	];
	$q = new WP_Query($args);

	if ($q->have_posts()) : ?>
		<div class="property__slider">
			<?php
			while ($q->have_posts()) : $q->the_post();

				/* ---------- 1. 画像 ---------- */
				$thumb_args = ['class' => 'property__image', 'alt' => the_title_attribute(['echo' => false])];
				if (has_post_thumbnail()) {
					$img_html = get_the_post_thumbnail(get_the_ID(), 'medium', $thumb_args);
				} else {
					$ids = (array) get_post_meta(get_the_ID(), 'property_images', true);
					$img_html = !empty($ids)
						? wp_get_attachment_image($ids[0], 'medium', false, $thumb_args)
						: sprintf(
							'<img src="%s" alt="%s" class="property__image" />',
							esc_url(get_template_directory_uri() . '/assets/img/coming-soon.png'),
							esc_attr__('Coming Soon', 'sanai-textdomain')
						);
				}

				/* ---------- 2. メタ情報 ---------- */
				$price   = get_post_meta(get_the_ID(), 'price',   true);
				$address = get_post_meta(get_the_ID(), 'address', true);
				$access  = get_post_meta(get_the_ID(), 'access',  true);

				$ph = __('—', 'sanai-textdomain');
				$price_d   = $price   !== '' ? esc_html($price)   : $ph;
				$address_d = $address !== '' ? esc_html($address) : $ph;
				$access_d  = $access  !== '' ? esc_html($access)  : $ph;
			?>
				<div class="property__card">
					<a href="<?php the_permalink(); ?>" class="property__link">
						<?php echo $img_html; ?>
						<div class="property__info">
							<h3 class="property__name"><?php the_title(); ?></h3>
							<p class="property__address"><i class="bi bi-geo-alt-fill me-1"></i><?php echo $address_d; ?></p>
							<p class="property__access"><i class="bi bi-train-front-fill me-1"></i><?php echo $access_d; ?></p>
							<p class="property__price">
								<i class="bi bi-currency-yen me-1"></i><?php echo $price_d; ?>
								<?php if ($price !== '') esc_html_e('円～', 'sanai-textdomain'); ?>
							</p>
						</div>
					</a>
				</div>
			<?php
			endwhile;
			wp_reset_postdata(); ?>
		</div><!-- /.property__slider -->

	<?php else : ?>
		<p class="property__empty">
			<?php esc_html_e('現在、公開されている物件はありません。', 'sanai-textdomain'); ?>
		</p>
	<?php endif; ?>

	</div><!-- /.property__slider -->

	<!-- ===== 一覧リンク ===== -->
	<div class="property__more">
		<a href="<?php echo esc_url(get_post_type_archive_link('property')); ?>"
			class="property__more-link">
			<span class="property__more-label">
				<?php esc_html_e('物件一覧を見る', 'sanai-textdomain'); ?>
			</span>
			<i class="bi bi-caret-right-fill property__more-icon" aria-hidden="true"></i>
		</a>
	</div>

</section>