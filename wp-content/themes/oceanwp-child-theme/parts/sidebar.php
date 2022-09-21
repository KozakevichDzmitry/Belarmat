<div class="accordeon__cat type__one one">
	
<?php
$args = array(
          'taxonomy' => 'product_cat',
          'hide_empty' => false,
          'parent'   => 0
      );
  $product_cat = get_terms( $args );

  foreach ($product_cat as $parent_product_cat)
  {

  echo '
      <ul>
        <li class="accordeon__categories">
		<p class="categories__perent" href="'.get_term_link($parent_product_cat->term_id).'">'.$parent_product_cat->name.'</p>
		
		
        <ul class="categories__children">
          ';
  $child_args = array(
              'taxonomy' => 'product_cat',
              'hide_empty' => false,
              'parent'   => $parent_product_cat->term_id
          );
  $child_product_cats = get_terms( $child_args );
  foreach ($child_product_cats as $child_product_cat)
  {
    echo '<li class="categories__child">
	<a href="'.get_term_link($child_product_cat->term_id).'">'.$child_product_cat->name.'</a>
				<ul class="categories__children">';
			  		$children_args = array(
						  'taxonomy' => 'product_cat',
						  'hide_empty' => false,
						  'parent'   => $child_product_cat->term_id
					  );
			  		$children_product_cats = get_terms( $child_args );
			  		foreach ($children_product_cats as $children_product_cat)
			  			{
					echo '<li class="categories__child">
						<a href="'.get_term_link($children_product_cat->term_id).'">'.$children_product_cat->name.'</a>

						</li>';
			 		 }
				echo '</ul>
	</li>';
  }

  echo '</ul>
      </li>
    </ul>';
  }
?>

</div>