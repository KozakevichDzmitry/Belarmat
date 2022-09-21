<?php

/**
 * The template for displaying the product carousels
 *
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

?>

<?php if ( ! empty( $products ) ) : ?>
<div class="pwb-product-carousel" data-slick="<?php echo $slick_settings; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>">
	<?php foreach ( $products as $product ) : ?>
		<div class="pwb-slick-slide">
			<a href="<?php echo esc_url( $product['permalink'] ); ?>">
			<?php echo wp_kses_post( $product['thumbnail'] ); ?>
				 <div class="item__number">
					<div class="n__stock">
					  <?php
						$prdt = new WC_Product($product['id']);
						if (get_post_meta($prdt->get_id(), '_stock_status', true) == 'outofstock') {
							echo '<div class="outofstock">Нет в наличии</div>';
							} else {
							echo '<div class="stock">В наличии</div>';
							}
						?>
        			</div>
					<p class="vendor__code">
					<?php if ( wc_product_sku_enabled() && ( $prdt->get_sku() || $prdt->is_type( 'variable' ) ) ) : ?>
					  <span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'woocommerce' ); ?>
						  <span class="sku">
								<?php echo ( $sku = $prdt->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?>
						  </span>				
					  </span>
					<?php endif; ?>
					</p>
				  </div>
			<h3 class="brand__title"><?php echo esc_html( $product['title'] ); ?></h3>
			<?php echo do_shortcode( '[add_to_cart id="' . esc_attr( $product['id'] ) . '" style=""]' ); ?>
			</a>
		</div>
	<?php endforeach; ?>
	<div class="pwb-carousel-loader"><?php esc_html_e( 'Loading', 'perfect-woocommerce-brands' ); ?>...</div>
</div>
<?php else : ?>
	<div><?php esc_html_e( 'Nothing found' ); ?></div>
<?php endif; ?>
