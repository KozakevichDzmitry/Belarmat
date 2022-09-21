<?php

global $product;
if ( $product->is_on_sale() ) {
    $args = array(
    'posts_per_page'    => 12,
    'post_status'       => 'publish',
    'post_type'         => 'product',
    'meta_query'        => WC()->query->get_meta_query(),
    'post__in'          => array_merge( array( 0 ), wc_get_product_ids_on_sale() )
);

//get products on sale using wp_query class
$products = new WP_Query( $args ); ?>

<?php if($products->have_posts()) : ?>
    <?php while($products->have_posts()) : $products->the_post(); ?>
        <?php the_title() ?>
        <?php echo $product->get_price(); ?>
        <?php echo $product->get_sale_price(); ?>
    <?php endwhile; ?>
<?php else : ?>
    <p> Sorry!No products on sale</p>
<?php endif; ?>
<?php
} ?>