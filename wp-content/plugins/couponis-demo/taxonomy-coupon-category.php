<?php 
get_header();

global $wp_query;

$category = get_term_by( 'slug', get_query_var( 'term' ), 'coupon-category' );
$category_icon = get_term_meta( $category->term_id, 'category_icon', true );


$cur_page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; //get curent page
$page_links_total =  $wp_query->max_num_pages;
$pagination = paginate_links( 
	array(
		'prev_next' => true,
		'end_size' => 2,
		'mid_size' => 2,
		'total' => $page_links_total,
		'current' => $cur_page,	
		'prev_next' => false
	)
);	

$coupon_listing_style = couponis_get_listing_style();

?>
<main>
	<div class="container">
		<div class="taxonomy-header white-block <?php echo !empty($category_icon) ? esc_attr('has-icon') : '' ?>">
			<div class="white-block-content">
				<?php
				if( !empty( $category_icon ) ):
				?>
					<div class="category-icon-wrap">
						<i class="category-icon fa fa-<?php echo esc_attr( $category_icon ) ?>"></i>
					</div>
				<?php endif; ?>			
				<div class="category-info store-info">
					<h1>
						<?php echo esc_html( $category->name ) ?> (<?php echo esc_html( $category->count ) ?>)
					</h1>
					<?php
					if( !empty( $category->description ) ){
						echo '<p>'.$category->description.'</p>';
					}
					?>
				</div>
				<div class="single-tax-action">
					<?php couponis_get_listing_style_icons(); ?>
				</div>
			</div>
		</div>

		<div class="main-listing">
			<div class="row">
				<div class="col-sm-8">
					<div class="row">
						<?php
						if( have_posts() ){
							$counter = 0;
							while( have_posts() ){
								the_post();
								if( $coupon_listing_style == 'grid' && $counter == 2 ){
									echo '</div><div class="row">';
									$counter = 0;
								}
								$counter++;
								?>
								<div class="col-sm-<?php echo  $coupon_listing_style == 'list' ? esc_attr( '12' ) : esc_attr( '6' ); ?>">
									<?php
									if( $coupon_listing_style == 'list' ){
										include( get_theme_file_path( 'includes/coupon-box/coupon-list.php' ) );
									}
									else{
										include( get_theme_file_path( 'includes/coupon-box/coupon-grid.php' ) );
									}
									?>
								</div>
								<?php
							}
							
						}
						else{
							?>
							<div class="col-sm-12">
								<div class="white-block">
									<div class="white-block-content">
										<h4 class="no-margin"><?php esc_html_e( 'No coupons in this category', 'couponis' ) ?></h4>
									</div>
								</div>
							</div>
							<?php
						}
						?>
					</div>
					<?php
					if( !empty( $pagination ) ){
						echo '<div class="pagination header-alike">'.$pagination.'</div>';
					}	
					?>				
				</div>
				<div class="col-sm-4">
					<?php
					$subcategories = get_terms( 'coupon-category', array( 'parent' => $category->term_id ) );
					if( !empty( $subcategories ) ){
						?>
						<div class="widget white-block subcategories">
							<div class="white-block-content">
								<div class="widget-title">
									<h4><?php esc_html_e( 'Subacategories', 'couponis' ) ?>
								</div>
							
								<ul class="list-unstyled">
									<?php
									foreach( $subcategories as $subcategory ){
										?>
										<li>
											<a href="<?php echo esc_url( get_term_link( $subcategory ) ) ?>">
												<?php echo esc_html( $subcategory->name ) ?>
											</a>
											<span class="small-action">
												<?php echo esc_html( $subcategory->count ) ?>
											</span>
										</li>
										<?php
									}
									?>
								</ul>
							</div>
						</div>
						<?php
					}

					get_sidebar( 'category' );
					?>
				</div>
			</div>
		</div>
	</div>
</main>

<?php 
wp_reset_postdata();
get_footer(); 
?>