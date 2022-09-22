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

add_action( 'after_setup_theme', 'theme_register_nav_menu' );

function theme_register_nav_menu() {
    register_nav_menu( 'сard', 'Корзина в шапке' );
}
//
//
//add_filter( 'wpmenucart_menu_item_a', 'woocommerce_header_add_to_cart_content' );
//function woocommerce_header_add_to_cart_content ($arg){
//    $menu_item_a_content ='';
//    $menu_item_icon= '<span class="header-icon-card"></span><svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
//<path d="M23.6842 23.6842C24.5217 23.6842 25.325 24.0169 25.9172 24.6091C26.5094 25.2014 26.8421 26.0046 26.8421 26.8421C26.8421 27.6796 26.5094 28.4829 25.9172 29.0751C25.325 29.6673 24.5217 30 23.6842 30C22.8467 30 22.0435 29.6673 21.4512 29.0751C20.859 28.4829 20.5263 27.6796 20.5263 26.8421C20.5263 26.0046 20.859 25.2014 21.4512 24.6091C22.0435 24.0169 22.8467 23.6842 23.6842 23.6842ZM23.6842 25.2632C23.2654 25.2632 22.8638 25.4295 22.5677 25.7256C22.2716 26.0217 22.1053 26.4233 22.1053 26.8421C22.1053 27.2609 22.2716 27.6625 22.5677 27.9586C22.8638 28.2547 23.2654 28.4211 23.6842 28.4211C24.103 28.4211 24.5046 28.2547 24.8007 27.9586C25.0968 27.6625 25.2632 27.2609 25.2632 26.8421C25.2632 26.4233 25.0968 26.0217 24.8007 25.7256C24.5046 25.4295 24.103 25.2632 23.6842 25.2632ZM9.47368 23.6842C10.3112 23.6842 11.1144 24.0169 11.7067 24.6091C12.2989 25.2014 12.6316 26.0046 12.6316 26.8421C12.6316 27.6796 12.2989 28.4829 11.7067 29.0751C11.1144 29.6673 10.3112 30 9.47368 30C8.63616 30 7.83294 29.6673 7.24072 29.0751C6.6485 28.4829 6.31579 27.6796 6.31579 26.8421C6.31579 26.0046 6.6485 25.2014 7.24072 24.6091C7.83294 24.0169 8.63616 23.6842 9.47368 23.6842ZM9.47368 25.2632C9.05492 25.2632 8.65331 25.4295 8.3572 25.7256C8.06109 26.0217 7.89474 26.4233 7.89474 26.8421C7.89474 27.2609 8.06109 27.6625 8.3572 27.9586C8.65331 28.2547 9.05492 28.4211 9.47368 28.4211C9.89245 28.4211 10.2941 28.2547 10.5902 27.9586C10.8863 27.6625 11.0526 27.2609 11.0526 26.8421C11.0526 26.4233 10.8863 26.0217 10.5902 25.7256C10.2941 25.4295 9.89245 25.2632 9.47368 25.2632ZM26.8421 4.73684H5.16789L9.18947 14.2105H22.1053C22.3508 14.2109 22.593 14.1537 22.8124 14.0434C23.0317 13.9332 23.2222 13.773 23.3684 13.5758L28.1053 7.26H28.1068C28.282 7.0253 28.3883 6.74653 28.4141 6.45484C28.4399 6.16315 28.3841 5.87003 28.2529 5.60825C28.1217 5.34647 27.9202 5.12633 27.6711 4.97245C27.422 4.81856 27.1349 4.73699 26.8421 4.73684ZM22.1053 15.7895H9.26211L8.05263 18.2526L7.89474 18.9474C7.89474 19.3661 8.06109 19.7677 8.3572 20.0639C8.65331 20.36 9.05492 20.5263 9.47368 20.5263H26.8421V22.1053H9.47368C8.92384 22.1055 8.38346 21.9622 7.906 21.6895C7.42854 21.4168 7.03056 21.0242 6.75143 20.5505C6.4723 20.0768 6.3217 19.5384 6.31452 18.9886C6.30735 18.4388 6.44385 17.8966 6.71053 17.4158L7.84737 15.0884L2.11263 1.57895H0V0H3.15789L4.49842 3.15789H26.8421C27.4388 3.15795 28.0232 3.32703 28.5277 3.64556C29.0322 3.96408 29.4361 4.41902 29.6927 4.95766C29.9493 5.49631 30.0481 6.09663 29.9776 6.68909C29.907 7.28155 29.6701 7.84191 29.2942 8.30526L24.6932 14.4411C24.4023 14.8576 24.0151 15.1977 23.5645 15.4325C23.1139 15.6672 22.6133 15.7897 22.1053 15.7895Z" fill="#0E64B6"></path>
//</svg></span>';
//    $cart_total = sprintf (_n( '%d', '%d', WC()->cart->cart_contents_count ), WC()->cart->cart_contents_count ); ?><!-- - --><?php //echo WC()->cart->get_cart_total();
//    $menu_item_a_content .=$menu_item_icon;
//    $menu_item_a_content .= '<span class="cartcontents">'.$cart_total.'</span>';
//    return  $menu_item_a_content;
//}

