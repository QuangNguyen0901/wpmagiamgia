<?php
extract( shortcode_atts( array(
	'number' 				=> '',
	'title' 				=> '',
	'categories_carousel' 	=> '',
	'visible_items' 		=> '5',
	'hide_empty' 			=> 'yes',
), $atts ) );
?>

<div class="white-block carousel-wrap">
	<?php if( !empty( $title ) ): ?>
		<div class="white-block-content">		
			<div class="widget-title">
			<h4><?php echo  $title ?></h4>
			<a href="<?php echo esc_url(couponis_get_permalink_by_tpl( 'page-tpl_categories', 'couponis' )) ?>"><?php esc_html_e( 'All Categories &raquo;', 'couponis' ) ?></a>
			</div>
		</div>
	<?php endif; ?>
	<?php
	echo '<div class="categories-carousel-list" data-visible="'.esc_attr( $visible_items ).'">';
		
	if( empty( $categories_carousel ) ){
		$categories_carousel = get_terms( 'coupon-category', array( 'parent' => 0, 'number' => $number ) );
	}
	else{
		$categories_carousel = get_terms( 'coupon-category', array( 'parent' => 0, 'include' => explode( ',', $categories_carousel ) ) );
	}

	foreach( $categories_carousel as $category ){
		?>
		<a href="<?php echo esc_url( get_term_link( $category ) ) ?>" title="<?php echo esc_attr( $category->name ) ?>">
			<?php
			$category_icon = get_term_meta( $category->term_id, 'category_icon', true );
			echo '<i class="fa fa-'.esc_attr( $category_icon ).'"></i>';
			?>
			<div>
				<?php echo  $category->name; ?>
			</div>
		</a>
		<?php
	}
	echo '</div>';
	?>
</div>