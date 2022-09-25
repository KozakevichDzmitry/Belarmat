<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$product = wc_get_product(get_the_ID());

get_header( 'shop' ); ?>
<main class="wrapper__product">
<section class="product__card">
		<h3 class="product__title"><?php the_title()?> </h3>
		<div class="breadcrumb">
			<?php
				if(function_exists('bcn_display'))
				{
				bcn_display();
				}
			?>
		</div>
		<div class="product__container">
			<div class="product__info">
				<div class="product__gallery">
					<?php 
					if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
						return;
					}

					global $product;

					$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
					$post_thumbnail_id = $product->get_image_id();
					$wrapper_classes   = apply_filters('woocommerce_single_product_image_gallery_classes',
							array(
								'woocommerce-product-gallery',
								'woocommerce-product-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
								'woocommerce-product-gallery--columns-' . absint( $columns ),
								'images',
							)
						);
						?>
					<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
						<figure class="woocommerce-product-gallery__wrapper">
							<?php
								if ( $post_thumbnail_id ) {
									$html = wc_get_gallery_image_html( $post_thumbnail_id, true );
								} else {
									$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
									$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
									$html .= '</div>';
								}

								echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
								do_action( 'woocommerce_product_thumbnails' );
									?>
								</figure>
					</div>
					<div class="info_description">
						<div class="info_characteristics">
							<div class="characteristics_title"> 
								<h4 class="title">
								О Товаре 
								</h4>
								<div class="favorite">
					 <?php echo do_shortcode("[ti_wishlists_addtowishlist loop=yes]") ?>
								</div>
							</div>
							<?php  
								global $product;
								wc_display_product_attributes( $product );
							?></div>
					</div>
				</div>
				<div class="characteristics__tab"> 
					<div class="button__tabs">
						<button data-tab="1" class="button__tab active">Описание</button>
						<button data-tab="2" class="button__tab">Характеристики</button>
					</div>
					<div class="content__tabs">
						<div data-tab-content="1" class="content__tab active">
							<?php 
								echo the_content();
							?>
						</div>
						<div data-tab-content="2" class="content__tab">
							<?php 
								global $product;
								wc_display_product_attributes( $product );
							?>
						</div>
					</div>
				</div>
			</div>	
			<div class= "price__container">
		<div class="product__price">
			<div class="price__sale">
				<div class="price__all">
					<p class="price__regular">
					<?php 
						$thePrice = $product->get_regular_price();
						echo $thePrice; 
					?> Руб
					</p>
					<p class="price__sale">
					<?php 
						$theSalePrice = $product->get_sale_price(); 
						echo $theSalePrice; 
					?> Руб
					</p>
				</div>
				<div class="sale__in-stock">
					<div class="theSize__sale">
					<?php 
			$percentage = ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100; 
					echo $percentage;
					?>%
					</div>
					<div class="in-stock__product">
						<?php
					if (get_post_meta(get_the_ID(), '_stock_status', true) == 'outofstock') {
						echo '<div class="outofstock">Нет в наличии</div>';
						} else {
						echo '<div class="stock">В наличии</div>';
						}
						?>
					</div>
				</div>
			</div>
			<div class="info__btn">
					<div class="wc-product-card-actions">
						<?php woocommerce_template_loop_add_to_cart(); ?>
					</div>
			</div>
			<div  class="info__delivery">
				<span>Срок доставки:</span>
				
			<?php  
				$delivery = carbon_get_post_meta( get_the_ID(), 'truemisha_h1' );
				echo $delivery;
				?>
			</div>
			<div  class="info__point-of-issue">
				<a href="#">Пункт выдачи:</a>
				
			<?php  
				$point_of_issue = carbon_get_post_meta( get_the_ID(), 'truemisha_h2' );
				echo $point_of_issue;
				?>
			</div>
		</div>
	</div>			
	</div>
	<div class="similar__products">
		<?php $upsell_ids = get_post_meta( get_the_ID(), '_upsell_ids' );

        if( !empty ($upsell_ids) ){

            $upsell_ids = $upsell_ids[0];

            if(count($upsell_ids)>0){

                $args = array(
                    'post_type' => 'product',
                    'ignore_sticky_posts' => 1,
                    'no_found_rows' => 1,
                    'posts_per_page' => apply_filters( 'woocommerce_upsells_total', $posts_per_page ),
                    'orderby' => 'rand',
                    'post__in' => $upsell_ids
                );

                $products = new WP_Query( $args );

                $woocommerce_loop['columns'] = apply_filters( 'woocommerce_upsells_columns', $columns );

                if ( $products->have_posts() ) : ?>

                    <div class="up-sells">

                    <h2><?php _e( 'Похожие товары', 'woocommerce' ) ?></h2>

                    <?php woocommerce_product_loop_start(); ?>

                    <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                    <?php wc_get_template_part( 'content', 'product' ); ?>

                    <?php endwhile; // end of the loop. ?>

                    <?php woocommerce_product_loop_end(); ?>

                    </div>

                <?php endif;

            }
            wp_reset_query();
        }
        $brand = get_the_terms($product->get_id(),'pwb-brand')[0]->name;
        ?>
			
	</div>
	<div class="branded__goods">
		<h2>Товары бренда <?php echo ($brand);?></h2>
	<?php echo do_shortcode("[pwb-product-carousel brand='$brand' products='7' products_to_show='4' products_to_scroll='3' autoplay='true' arrows='true' ]"); ?>
	</div>
	<div class="buyWith__thisProduct">
		<?php
		$crosssell_ids = get_post_meta( get_the_ID(), '_crosssell_ids' );
		if( !empty ($crosssell_ids) ){

		$crosssell_ids = $crosssell_ids[0];

			if(count($crosssell_ids)>0){
				$args = array(
					'post_type' => 'product',
					'ignore_sticky_posts' => 1,
					'no_found_rows' => 1,
					'posts_per_page' => apply_filters( 'woocommerce_cross_sells_total', $posts_per_page ),
					'orderby' => 'rand',
					'post__in' => $crosssell_ids
				);
				$products = new WP_Query( $args );
				$woocommerce_loop['columns'] = apply_filters( 'woocommerce_cross_sells_columns', $columns );

				if ( $products->have_posts() ) : ?>
					<div class="cross-sells">
					<h2>С этим товаром покупают</h2>
					<?php woocommerce_product_loop_start(); ?>
						<?php while ( $products->have_posts() ) : $products->the_post(); ?>		
						<?php wc_get_template_part( 'content', 'product' ); ?>
						<?php endwhile; ?>
					<?php woocommerce_product_loop_end(); ?>
					</div>
				<?php endif;
			}

			wp_reset_query();

			}

				?>
		
	</div>
</section>
	
	
	
</main>
<?php get_footer( 'shop' );

