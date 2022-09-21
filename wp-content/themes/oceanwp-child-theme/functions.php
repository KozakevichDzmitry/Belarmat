<?php

function oceanwp_child_enqueue_parent_style()
{
	$theme   = wp_get_theme('OceanWP');
	$version = $theme->get('Version');

	// Load the stylesheet.
	wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('oceanwp-style'), $version);
	wp_enqueue_style('slick-style', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
	wp_enqueue_script('slick-script', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array(), '1.0', true);
	wp_enqueue_script('mapscript',  'https://api-maps.yandex.ru/2.1/?apikey=3b5476da-3b5f-42df-8ad6-6c315dc87279&lang=ru_RU');
	wp_enqueue_script( 'main-index-js', get_stylesheet_directory_uri() . '/index.js', array('jquery', 'slick-script','mapscript'), '1.0.0', false );
	
	wp_localize_script('main-index-js', 'ajaxpagination', array(
      'ajaxurl' => admin_url('admin-ajax.php'),
    ));
}

add_action('wp_enqueue_scripts', 'oceanwp_child_enqueue_parent_style');

add_action('after_setup_theme', 'woocommerce_support');
function woocommerce_support()
{
	add_theme_support('woocommerce');
	add_theme_support('wc-product-gallery-zoom');
	add_theme_support('wc-product-gallery-lightbox');
	add_theme_support('wc-product-gallery-slider');
}

function render_tabs() {
	ob_start();

	 get_template_part('parts/tab-home'); 
			

	return ob_get_clean();
}

add_shortcode('render_tabs_scn', 'render_tabs');

function render_slider() {
	ob_start();
?>
<div class="items__container">
         <?php for ($i = 0; $i < 6; $i++) : ?>
							<?php get_template_part('parts/product-card'); ?>
		<?php endfor; ?>
</div>
	
						
					
<?php
	return ob_get_clean();
}

add_shortcode('render_sliders', 'render_slider');

function render_map() {
	ob_start();

	 get_template_part('parts/map'); 
			

	return ob_get_clean();
}

add_shortcode('map', 'render_map');

add_action( 'template_redirect', 'truemisha_recently_viewed_product_cookie', 20 );
 
function truemisha_recently_viewed_product_cookie() {
 
	
	if ( ! is_product() ) {
		return;
	}
 
	if ( empty( $_COOKIE[ 'woocommerce_recently_viewed_2' ] ) ) {
		$viewed_products = array();
	} else {
		$viewed_products = (array) explode( '|', $_COOKIE[ 'woocommerce_recently_viewed_2' ] );
	}
 
	if ( ! in_array( get_the_ID(), $viewed_products ) ) {
		$viewed_products[] = get_the_ID();
	}
 
	if ( sizeof( $viewed_products ) > 15 ) {
		array_shift( $viewed_products ); 
	}
 
	wc_setcookie( 'woocommerce_recently_viewed_2', join( '|', $viewed_products ) );
 
}

add_shortcode( 'recently_viewed_products', 'truemisha_recently_viewed_products' );
 
function truemisha_recently_viewed_products() {
 
	if( empty( $_COOKIE[ 'woocommerce_recently_viewed_2' ] ) ) {
		$viewed_products = array();
	} else {
		$viewed_products = (array) explode( '|', $_COOKIE[ 'woocommerce_recently_viewed_2' ] );
	}
 
	if ( empty( $viewed_products ) ) {
		return;
	}
 
	// надо ведь сначала отображать последние просмотренные
	$viewed_products = array_reverse( array_map( 'absint', $viewed_products ) );
 
	$title = '<h3>Ранее вы смотрели</h3>';
 
	$product_ids = join( ",", $viewed_products );
 
	return $title . do_shortcode( "[products ids='$product_ids']" );
 
}


function display_products_discount() {
 	ob_start();

	 get_template_part('parts/sale-block'); 
			

	return ob_get_clean();
}

add_shortcode( 'sale_products', 'display_products_discount' );

function sale_products_tab() {
 	ob_start();

	 get_template_part('parts/tab-sale'); 
			

	return ob_get_clean();
}

add_shortcode( 'sale_tab', 'sale_products_tab' );

function sidebar_accordeon() {
 	ob_start();

	 get_template_part('parts/sidebar'); 
			

	return ob_get_clean();
}

add_shortcode( 'shop_sidebar', 'sidebar_accordeon' );



use Carbon_Fields\Container;
use Carbon_Fields\Field;


function crb_attach_theme_options()
{
    
	Container::make( 'post_meta', 'Настройки доставки' )
		->where( 'post_type', '=', 'product' )
		->add_fields( array(
			Field::make( 'text', 'truemisha_h1', 'Срок доставки:' ),
			Field::make( 'text', 'truemisha_h2', 'Пункты выдачи:' ),	
	) );
}

add_action('carbon_fields_register_fields', 'crb_attach_theme_options');


function stock_taxonomy(){
    register_post_type(
    'stock',
    array(
      'label'               => ('stock'),
      'labels'              => array(
        'name'                => _x('Акции', 'Post Type General Name'),
        'singular_name'       => _x('Акции', 'Post Type Singular Name'),
        'menu_name'           => ('Акции'),
      ),
      'supports'            => array('title', 'author', 'thumbnail', 'editor'),
      'hierarchical'        => false,
      'public'              => true,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'show_in_nav_menus'   => true,
      'can_export'          => true,
      'has_archive'         => true,
      'exclude_from_search' => false,
      'publicly_queryable'  => true,
      'capability_type'     => 'post',
    )
  );
}

add_action('init', 'stock_taxonomy', 0);

function stocks_carbon() {
  $elemets_labels = array(
        'plural_name' => 'Акции', //entries
        'singular_name' => 'Акцию', //entry
    );
Container::make( 'post_meta', 'Акции' )
  ->where( 'post_type', '=', 'stock' )
  ->add_fields( array(
    Field::make( 'complex', 'crb_stock', 'Акции')
      ->setup_labels( $elemets_labels )
      ->add_fields( array(
        Field::make( 'text', 'title', 'Заголовок' ),
		Field::make( 'text', 'time', 'До какого числа акция' ),
        Field::make( 'image', 'crb_image', __( 'Image' ) )
   				 ->set_value_type( 'url' ),
      ))  
));
}

add_action( 'carbon_fields_register_fields', 'stocks_carbon');

function clear_all_cart() {
	if ( wc_get_page_id( 'cart' ) == get_the_ID() || wc_get_page_id( 'checkout' ) == get_the_ID() ) {
        return;
    }
    WC()->cart->empty_cart( true );
	$page = $_SERVER['PHP_SELF'];
	$sec = "1";
	header("Refresh: $sec; url=$page");
	echo 'ky';
	die();
}

add_action( 'wp_ajax_clear_all_cart', 'clear_all_cart' );
add_action( 'wp_ajax_nopriv_clear_all_cart', 'clear_all_cart' );

add_filter( 'woocommerce_default_catalog_orderby_options', 'truemisha_remove_orderby_options' );
add_filter( 'woocommerce_catalog_orderby', 'truemisha_remove_orderby_options' );
 
function truemisha_remove_orderby_options( $sortby ) {
 
	
	unset( $sortby[ 'rating' ] ); // по рейтингу
	unset( $sortby[ 'date' ] ); // Сортировка по более позднему
	
 
	return $sortby;

}

add_action( 'woocommerce_before_shop_loop', 'add_google_script', 12 );
function add_google_script(){
		if ( ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) {
			return;
		}
		$show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', 'menu_order' ) );
		$catalog_orderby_options = apply_filters(
			'woocommerce_catalog_orderby',
			array(
				'menu_order' => __( 'Default sorting', 'woocommerce' ),
				'popularity' => __( 'Sort by popularity', 'woocommerce' ),
				'rating'     => __( 'Sort by average rating', 'woocommerce' ),
				'date'       => __( 'Sort by latest', 'woocommerce' ),
				'price'      => __( 'Sort by price: low to high', 'woocommerce' ),
				'price-desc' => __( 'Sort by price: high to low', 'woocommerce' ),
			)
		);

		$default_orderby = wc_get_loop_prop( 'is_search' ) ? 'relevance' : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', '' ) );
		// phpcs:disable WordPress.Security.NonceVerification.Recommended
		$orderby = isset( $_GET['orderby'] ) ? wc_clean( wp_unslash( $_GET['orderby'] ) ) : $default_orderby;
		// phpcs:enable WordPress.Security.NonceVerification.Recommended

		if ( wc_get_loop_prop( 'is_search' ) ) {
			$catalog_orderby_options = array_merge( array( 'relevance' => __( 'Relevance', 'woocommerce' ) ), $catalog_orderby_options );

			unset( $catalog_orderby_options['menu_order'] );
		}

		if ( ! $show_default_orderby ) {
			unset( $catalog_orderby_options['menu_order'] );
		}

		if ( ! wc_review_ratings_enabled() ) {
			unset( $catalog_orderby_options['rating'] );
		}

		if ( ! array_key_exists( $orderby, $catalog_orderby_options ) ) {
			$orderby = current( array_keys( $catalog_orderby_options ) );
		}
	?>
		<div class="filter-mobile">
			<button class="btn__sorting">Сортировать<img src="/wp-content/uploads/2022/09/Vector-2.svg" /></button>
			<div class="sorting__menu">
				<div class="menu__titleAndRemove">
					<span>Сортировать</span> <img class="btn__remove" src="/wp-content/uploads/2022/07/Cross.svg"/>
				</div>
				<form class="woocommerce-ordering mobile" method="get">
						<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
						<?php
							$class = '';
							if (!empty($_GET['orderby'])) {
								$class = esc_attr( $id ) == $_GET['orderby'] ? 'active':'';
							}
						?>
						<a href="?orderby=<?php echo esc_attr( $id );?>" class="<?php echo $class; ?>">
							<?php echo esc_html( $name )?>
						</a>
						<?php endforeach; ?>
					<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
				</form>
			</div>
		</div>
	<?php                         
	
}