<?php
/**
 * Services – Navigation
 *
 * @package Sanai_WP_Theme
 * @since 1.0.0
 */
?>

<nav class="services__nav section container" aria-label="<?php esc_attr_e( 'サービス内容ナビ', 'sanai-textdomain' ); ?>">
	<ul class="services__nav-list">
		<?php for ( $i = 1; $i <= 6; $i++ ) : ?>
			<li class="services__nav-item">
				<a href="#service<?php echo esc_attr( $i ); ?>" class="services__nav-link">
					<?php printf( esc_html__( 'Service %02d', 'sanai-textdomain' ), $i ); ?>
				</a>
			</li>
		<?php endfor; ?>
	</ul>
</nav>
