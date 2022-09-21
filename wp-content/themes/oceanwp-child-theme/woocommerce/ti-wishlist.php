<?php
/**
 * The Template for displaying wishlist if a current user is owner.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/ti-wishlist.php.
 *
 * @version             1.24.5
 * @package           TInvWishlist\Template
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
wp_enqueue_script('tinvwl');
?>
<div class="tinv-wishlist woocommerce tinv-wishlist-clear">

	<?php
	$wl_paged = absint(get_query_var('wl_paged'));
	$form_url = tinv_url_wishlist($wishlist['share_key'], $wl_paged, true);
	?>
	<form class="favorite__list" action="<?php echo esc_url($form_url); ?>" method="post" autocomplete="off">
		<?php do_action('tinvwl_before_wishlist_table', $wishlist); ?>
		
			
			<?php do_action('tinvwl_wishlist_contents_before'); ?>

			<?php

			global $product, $post;
			// store global product data.
			$_product_tmp = $product;
			// store global post data.
			$_post_tmp = $post;

			foreach ($products as $wl_product) {

				if (empty($wl_product['data'])) {
					continue;
				}

				// override global product data.
				$product = apply_filters('tinvwl_wishlist_item', $wl_product['data']);
				// override global post data.
				$post = get_post($product->get_id());

				unset($wl_product['data']);
			if ($wl_product['quantity'] > 0 && apply_filters('tinvwl_wishlist_item_visible', true, $wl_product, $product)){
					$product_url = apply_filters('tinvwl_wishlist_item_url', $product->get_permalink(), $wl_product, $product); 
					do_action('tinvwl_wishlist_row_before', $wl_product, $product);
					?>
 <div class="card__product">
				<div class="img__product">
					<?php
						$thumbnail = apply_filters('tinvwl_wishlist_item_thumbnail', $product->get_image(), $wl_product, $product);
							if (!$product->is_visible()) {
								echo $thumbnail; // WPCS: xss ok.
							} else {
								printf('<a href="%s">%s</a>', esc_url($product_url), $thumbnail); // WPCS: xss ok.
							}
							?>
						<td class="product-remove">
							<button class="tinvwl-remove" type="submit" name="tinvwl-remove"
									value="<?php echo esc_attr($wl_product['ID']); ?>"
									title="<?php _e('Remove', 'ti-woocommerce-wishlist') ?>">
						
							</button>
						</td>
					
				</div>
				 <div class="item__number">
					<div class="n__stock">
						  <span>
							<?php
								if (get_post_meta(get_the_ID(), '_stock_status', true) == 'outofstock') {
								echo '<div class="outofstock">Нет в наличии</div>';
								} else {
								echo '<div class="stock">В наличии</div>';
								}
							?>
						</span>
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
				  <h6 class="title__product">
					  <?php
				if (!$product->is_visible()) {
					echo apply_filters('tinvwl_wishlist_item_name', is_callable(array(
					$product,'get_name'
					)) ? $product->get_name() : $product->get_title(), $wl_product, $product) . '&nbsp;'; // WPCS: xss ok.
					} else {
					echo apply_filters('tinvwl_wishlist_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_url), is_callable(array( $product, 'get_name')) ? $product->get_name() : $product->get_title()), $wl_product, $product); // WPCS: xss ok.
				}
			echo apply_filters('tinvwl_wishlist_item_meta_data', tinv_wishlist_get_item_data($product, $wl_product), $wl_product, $product); // WPCS: xss ok.
							?>
				 </h6>
			   <div class="price__product">
				 <div class="price">
				   <span class="price__no-stock">
					   <?php
						echo apply_filters('tinvwl_wishlist_item_price', $product->get_price_html(), $wl_product, $product); // WPCS: xss ok.
							?>
					 </span>
				 </div>
				   
					   <?php
								if (apply_filters('tinvwl_wishlist_item_action_add_to_cart', $wishlist_table_row['add_to_cart'], $wl_product, $product)) {
									?>
									<button class="button alt" name="tinvwl-add-to-cart"
											value="<?php echo esc_attr($wl_product['ID']); ?>"
											title="<?php echo esc_html(apply_filters('tinvwl_wishlist_item_add_to_cart', $wishlist_table_row['text_add_to_cart'], $wl_product, $product)); ?>">
										<span
												class="tinvwl-txt"><?php echo wp_kses_post(apply_filters('tinvwl_wishlist_item_add_to_cart', $wishlist_table_row['text_add_to_cart'], $wl_product, $product)); ?></span>
									</button>
								
						<?php } ?>
				  
			   </div>
			</div>
	
						
					<?php
					do_action('tinvwl_wishlist_row_after', $wl_product, $product);
				} // End if().
			} // End foreach().
			// restore global product data.
			$product = $_product_tmp;
			// restore global post data.
			$post = $_post_tmp;
			?>
			<?php do_action('tinvwl_wishlist_contents_after'); ?>
					
					<?php wp_nonce_field('tinvwl_wishlist_owner', 'wishlist_nonce'); ?>
		
	</form>
	<?php do_action('tinvwl_after_wishlist', $wishlist); ?>
	<div class="tinv-lists-nav tinv-wishlist-clear">
		<?php do_action('tinvwl_pagenation_wishlist', $wishlist); ?>
	</div>
</div>
<h4 class="title__catalog subcat">Товары дня</h4>
<?php
echo do_shortcode("[br_products_of_day add_to_cart=1 products_count=8 count_line=4 thumbnails=1]");
?>
<div class="viewed__products">
<?php echo do_shortcode("[recently_viewed_products columns='4']"); ?>
</div>
