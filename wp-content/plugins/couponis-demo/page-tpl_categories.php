<?php
/*
	Template Name: All Categories
*/
?>

<?php 
get_header();

$list_empt_cats_stores = couponis_get_option( 'list_empt_cats_stores' );

$categories = get_terms( 
	'coupon-category', 
	array( 
		'parent' => 0,
		'hide_empty' => $list_empt_cats_stores == 'yes' ? true : false
	) 
);

usort( $categories, "couponis_organized_sort_name_asc" );

get_template_part( 'includes/title' );
?>
<main>
	<div class="container">
		<div class="row">
			<?php
			if( !empty( $categories ) ){
				$counter = 0;
				foreach( $categories as $category ){
					$category_hide = get_term_meta( $category->term_id, 'category_hide', true );
					if( $category_hide !== '1' ){
						if( $counter == 4 ){
							echo '</div><div class="row">';
							$counter = 0;
						}
						$counter++;
						?>
						<div class="col-sm-3">
							<a href="<?php echo esc_url( get_term_link( $category ) ) ?>" class="category-block">
								<div class="white-block text-center">
									<div class="white-block-content">
										<div class="category-icon-wrap">
											<?php
											$category_icon = get_term_meta( $category->term_id, 'category_icon', true );
											if( !empty( $category_icon ) ): ?>
												<i class="fa fa-<?php echo esc_attr( $category_icon ) ?>"></i>
											<?php endif; ?>
										</div>

										<span><?php echo esc_html( $category->name ) ?></span>
									</div>
								</div>
							</a>
						</div>
						<?php
					}
				}
			}
			?>
		</div>
	</div>
</main>

<?php get_footer();  ?>