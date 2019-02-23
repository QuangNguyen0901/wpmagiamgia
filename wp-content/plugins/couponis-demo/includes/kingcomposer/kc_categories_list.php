<?php
extract( shortcode_atts( array(
	'number' 			=> '',
	'coupon_categories' => '',
	'show_icons' 		=> 'yes',
	'show_count' 		=> 'yes',
	'hide_empty' 		=> 'yes',
), $atts ) );
?>

<div class="white-block">
	<?php
	echo '<ul class="list-unstyled categories-list">';
		
	if( empty( $coupon_categories ) ){
		$coupon_categories = get_terms( 
			'coupon-category', 
			array( 
				'parent' => 0, 
				'number' => $number, 
				'hide_empty' => $hide_empty == 'yes' ? true : false 
			) 
		);
	}
	else{
		$coupon_categories = get_terms( 
			'coupon-category', 
			array( 
				'parent' => 0, 
				'include' => explode( ',', $coupon_categories ),
				'hide_empty' => $hide_empty == 'yes' ? true : false
			) 
		);
	}

	foreach( $coupon_categories as $category ){
		?>
		<li>
			<a href="<?php echo esc_url( get_term_link( $category ) ) ?>">
			<?php
			if( $show_icons == 'yes' ){
				$category_icon = get_term_meta( $category->term_id, 'category_icon', true );
				echo '<span class="icon-wrap"><i class="fa fa-'.esc_attr( $category_icon ).' fa-fw"></i></span>';
			}
			?>
			
				<span><?php echo esc_html( $category->name ); ?></span>
			
			<?php
			if( $show_count == 'yes' ){
				echo '<span class="cat-count">'.$category->count.'</span>';
			}
			?>
			</a>
		</li>
		<?php
	}
	echo '</ul>';
	?>
</div>