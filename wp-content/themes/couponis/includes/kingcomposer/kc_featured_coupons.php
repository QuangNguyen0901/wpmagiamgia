<?php
$atts = array_filter( $atts );
extract( shortcode_atts( array(
	'coupon_source' 		=> 'selected',
	'coupon_ids' 			=> '',
	'coupon_categories' 	=> '',
	'coupon_stores' 		=> '',
	'coupon_orderby' 		=> 'date',
	'coupon_order' 			=> 'ASC',
	'coupon_number' 		=> '5',
	'coupon_type'			=> ''
), $atts ) );

$args = array(
	'post_status'		=> 'publish',
);

if( $coupon_source == 'selected' ){
	$args['posts_per_page']	= -1;
	$args['orderby'] 		= 'post__in';
	$args['post__in']		= explode( ',', $coupon_ids );
}
else{
	$args['posts_per_page']	= $coupon_number;
	$args['orderby'] 		= $coupon_orderby;
	$args['order'] 			= $coupon_order;
	$args['tax_query']		= array();
	if( !empty( $coupon_categories ) ){
		$args['tax_query'][] = array(
			'taxonomy' 	=> 'coupon-category',
			'terms'	=> explode( ',', $coupon_categories )
		);
	}
	if( !empty( $coupon_stores ) ){
		$args['tax_query'][] = array(
			'taxonomy' 	=> 'coupon-store',
			'terms'	=> explode( ',', $coupon_stores )
		);
	}
	if( !empty( $coupon_type ) ){
		$args['type'] = $coupon_type;
	}
}

$coupons = new WP_Coupons_Query( $args );
?>

<div class="featured-coupons white-block">
	<?php
	if( $coupons->have_posts() ){
		while( $coupons->have_posts() ){
			$coupons->the_post();
			$categories = get_the_terms( get_the_ID(), 'coupon-category' );
			$store = get_the_terms( get_the_ID(), 'coupon-store' );
			$type = couponis_get_the_coupon_type();
			?>
			<div class="featured-item">
				<a <?php echo couponis_get_coupon_link() ?>>
					<?php the_post_thumbnail( 'couponis-featured-slider' ) ?>
				</a>
				<div class="featured-caption flex-wrap flex-always">
					<div class="flex-left">

						<?php echo couponis_coupon_type_badge( $type ) ?>

						<h3>
							<a <?php echo couponis_get_coupon_link() ?> class="continue-read">
								<?php the_title() ?>
							</a>
						</h3>
						<ul class="list-inline featured-bottom-meta">
							<?php if( !empty( $store ) ): ?>
								<li>
									<i class="icon-location-pin"></i>
									<a href="<?php echo esc_url( get_term_link( $store[0], 'coupon-store' ) ) ?>"><?php echo  $store[0]->name ?></a>
								</li>
							<?php endif; ?>
							<?php if( !empty( $categories ) ): ?>
								<li>
									<i class="icon-target"></i>
									<?php echo couponis_print_coupon_parents( $categories ); ?>
								</li>
							<?php endif; ?>
							<li>
								<?php include( get_theme_file_path( 'includes/coupon-box/expire.php' ) ) ?>
							</li>
						</ul>
					</div>
					<div class="flex-right">
						<?php echo couponis_coupon_action_button( $type ) ?>
					</div>
				</div>
			</div>
			<?php
		}
	}
	wp_reset_postdata();
	?>
</div>