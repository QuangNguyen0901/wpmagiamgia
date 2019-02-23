<?php 
get_header();

global $wp_query;

$store = get_term_by( 'slug', get_query_var( 'term' ), 'coupon-store' );
$store_image = get_term_meta( $store->term_id, 'store_image', true );
$store_url = get_term_meta( $store->term_id, 'store_url', true );
if( !empty( $store_url ) ){
	$store_url = add_query_arg( array( 'sout' => $store->term_id ), home_url('/') );
}


$cur_page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; //get curent page
$page_links_total =  $wp_query->max_num_pages;
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
		<div class="taxonomy-header white-block">
			<div class="white-block-content">
				<div class="store-tax-header-wrap">
					<div class="flex-wrap flex-always">
						<div class="flex-left">
							<?php
							if( !empty( $store_url ) ){
								echo '<a href="'.esc_url( $store_url ).'" rel="nofollow" target="_blank">';
							}
							?>
							<div class="store-logo">
								<?php echo wp_get_attachment_image( $store_image, 'full' ); ?>
							</div>
							<?php
							if( !empty( $store_url ) ){
								echo '</a>';
							}
							?>
						</div>
						<div class="flex-middle">
							<div class="store-info">
								<h1><?php echo esc_html( $store->name ) ?> (<?php echo esc_html( $store->count ) ?>) </h1>
								<?php
								if( !empty( $store->description ) ){
									echo '<p>'.$store->description.'</p>';
								}
								?>
							</div>
							<?php include( get_theme_file_path( 'includes/share.php' ) ) ?>
						</div>
					</div>
					<?php
					if( !empty( $store_url ) ){
						echo '<a href="'.esc_url( $store_url ).'" rel="nofollow" class="visit-store" target="_blank">'.esc_html__( 'Visit Store', 'couponis' ).'</a>';
					}
					?>
					<div class="single-tax-action">
						<?php echo couponis_save_store_link( $store->term_id ) ?>
						<?php couponis_get_listing_style_icons(); ?>
					</div>
				</div>

				<?php
				$store_location = get_term_meta(  $store->term_id, 'store_location', true );
				if( !empty( $store_location ) ){
					$store_location = explode( '|', $store_location );
					?>
					<div class="contact-map hidden">
						<?php
						echo json_encode( $store_location );
						?>
					</div>					
					<?php
				}
				?>

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
										<h4 class="no-margin"><?php esc_html_e( 'No coupons in this store', 'couponis' ) ?></h4>
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
					<?php get_sidebar( 'store' ) ?>
				</div>
			</div>
		</div>
	</div>
</main>

<?php 
wp_reset_postdata();
get_footer(); 
?>