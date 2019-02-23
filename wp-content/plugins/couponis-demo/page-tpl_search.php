<?php
/*
	Template Name: Search Page
*/
?>

<?php 
get_header();
$cur_page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; //get curent page

$category = !empty( $_GET['category'] ) ? $_GET['category'] : '';
$store = !empty( $_GET['store'] ) ? $_GET['store'] : '';
$keyword = !empty( $_GET['keyword'] ) ? $_GET['keyword'] : '';
$type = !empty( $_GET['type'] ) ? urldecode( $_GET['type'] ) : array();

$cur_page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; //get curent page

$selected_orderby = couponis_get_search_orderby_cookie();

$search_args = array(
	'post_status'	=> 'publish',
	'orderby'		=> 'expire',
	'order'			=> 'ASC',
	'paged'			=> $cur_page,
	'tax_query'		=> array()
);

if( !empty( $selected_orderby ) ){
	$search_args['orderby'] = $selected_orderby;
	if( $selected_orderby == 'expire' || $selected_orderby == 'name' ){
		$search_args['order'] = 'ASC';
	}
	else{
		$search_args['order'] = 'DESC';	
	}
}

if( !empty( $category ) ){
	$search_args['tax_query'][] = array(
		'taxonomy' => 'coupon-category',
		'terms'    => $category,
	);
}

if( !empty( $store ) ){
	$search_args['tax_query'][] = array(
		'taxonomy' => 'coupon-store',
		'terms'    => $store,
	);
}

if( !empty( $keyword ) ){
	$search_args['s'] = $keyword;
}

if( !empty( $type ) ){
	$search_args['type'] = $type;
}

$coupons = new WP_Coupons_Query( $search_args );

$page_links_total =  $coupons->max_num_pages;
$pagination = paginate_links( 
	array(
		'prev_next' => true,
		'end_size' => 2,
		'mid_size' => 2,
		'total' => $page_links_total,
		'current' => $cur_page,	
		'prev_next' => false,
	)
);	

$coupon_listing_style = couponis_get_listing_style();

?>
<main>
	<div class="container">
		<div class="main-listing">
			<div class="row">
				<div class="col-sm-4">
					<div class="widget white-block">
						<div class="white-block-content">
							<div class="widget-title">
								<h4><?php esc_html_e( 'Search Coupons', 'couponis' ) ?></h4>
							</div>
							<?php include( get_theme_file_path( 'includes/coupons-search-box.php' ) ); ?>
						</div>
					</div>
					
					<?php get_sidebar( 'search' ) ?>

				</div>
				<div class="col-sm-8">
					<div class="white-block search-header">
						<div class="white-block-content">
							<div class="flex-wrap flex-always">
								<div class="flex-left header-alike">
									<?php couponis_get_listing_style_icons(); ?>
									<?php echo esc_html__( 'Found', 'couponis' ).' '.$coupons->found_posts.' '.( $coupons->found_posts == 1 ? esc_html__( 'coupon', 'couponis' ) : esc_html__( 'coupons', 'couponis' ) ); ?>
								</div>  
								<div class="flex-right">
									<?php echo couponis_search_orderby(); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<?php
						if( $coupons->have_posts() ){
							$counter = 0;
							while( $coupons->have_posts() ){
								$coupons->the_post();
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
										<h4 class="no-margin"><?php esc_html_e( 'No coupons found matching your search criteria', 'couponis' ) ?></h4>
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
			</div>
		</div>
	</div>
</main>

<?php 
wp_reset_postdata();
get_footer(); 
?>