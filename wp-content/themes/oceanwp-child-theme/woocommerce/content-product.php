<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( '', $product ); ?>>
	 <div class="card__product">
		 <a href="<?php echo get_permalink($product->post->id) ?>">
       <div class="img__product">
        <?php if ( has_post_thumbnail() ) : ?>
		   <img src="<?php the_post_thumbnail_url(); ?>" alt="">
		<?php endif; ?>
         <?php echo do_shortcode("[ti_wishlists_addtowishlist loop=yes]") ?>
      </div>
       <div class="item__number">
        <div class="n__stock">
          <?php
			if (get_post_meta(get_the_ID(), '_stock_status', true) == 'outofstock') {
				echo '<div class="outofstock">Нет в наличии</div>';
				} else {
				echo '<div class="stock">В наличии</div>';
				}
			?>
        </div>
      <p class="vendor__code">
		<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
		  <span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'woocommerce' ); ?>
			  <span class="sku">
					<?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?>
			  </span>				
		  </span>
		<?php endif; ?>
		   </p>
      </div>
      <h5 class="title__product"><?php the_title()?></h5>
   <div class="price__product">
     <div class="price">
       <span class="price__stock">
		   <?php 
				$thePrice = $product->get_regular_price();
				echo $thePrice; 
			?> р.
		 </span>
       <span class="price__no-stock">
		   <?php 
				$theSalePrice = $product->get_sale_price(); 
				echo $theSalePrice; 
			?>р.
		 </span>
     </div>
		   <div class="wc-product-card-actions">
				<?php woocommerce_template_loop_add_to_cart(); ?>
		   </div>
   </div>
	</a>
</div>
</li>
