<div class="col-sm-4">
	<div class="white-block coupon-info">
		<ul class="list-unstyled no-margin">
			<li>
				<?php echo couponis_coupon_action_button( $type ) ?>
			</li>
			<?php if( $positive > 0 || $negative > 0 ): ?>
				<li class="success-rate text-center flex-wrap flex-always">
					<div class="left-rate">
						<span class="icon-like"></span>
						<div class="small-action"><?php echo  $positive.' '.( $positive == 1 ? esc_html__( 'VOTE', 'couponis' ) : esc_html__( 'VOTES', 'couponis' ) ) ?> </div>
					</div>
					<div class="center-rate">
						<canvas id="progress" width="80" height="80" data-value="<?php echo esc_attr( $success ) ?>" data-color="<?php echo esc_attr( $color ) ?>"></canvas>
						<div class="back-grey"></div>
						<div class="header-alike"><?php echo  $success ?>%<p><?php esc_html_e( 'SUCCESS', 'couponis' ) ?></p></div>
					</div>
					<div class="right-rate">
						<span class="icon-dislike"></span>
						<div class="small-action"><?php echo  $negative.' '.( $negative == 1 ? esc_html__( 'VOTE', 'couponis' ) : esc_html__( 'VOTES', 'couponis' ) ) ?> </div>
					</div>
				</li>
			<?php endif; ?>
			<?php if( !empty( $expire ) && $expire !== '99999999999' && !couponis_is_expired( $expire ) ): ?>
				<li class="single-expire flex-wrap flex-always">
					<div class="leading-icon">
						<span class="icon-clock"></span>
					</div>
					<div class="flex-right">
						<p class="small-action"><?php esc_html_e( 'Expires in', 'couponis' ) ?></p>
                        <span class="countdown header-alike" data-single="<?php esc_attr_e( 'Day', 'couponis' ) ?>" data-multiple="<?php esc_attr_e( 'Days', 'couponis' ) ?>" data-expire="<?php echo esc_attr( $expire ) ?>" data-current-time="<?php echo esc_attr( current_time( 'timestamp' ) ); ?>"></span>
                   	</div>
				</li>
			<?php endif; ?>
			<li class="coupon-store text-center">
				<?php echo couponis_get_coupon_hrefed_store_logo( 'full' ) ?>
			</li>
		</ul>

		<?php include( get_theme_file_path( 'includes/coupon-box/is-expired.php' ) ) ?>

	</div>

	<?php if( couponis_get_option( 'enable_share' ) == 'yes' ): ?>
		<div class="widget white-block single-share">
			<div class="white-block-content">
				<div class="widget-title">
					<h4><?php esc_html_e( 'Share This Coupon', 'couponis' ) ?></h4>
				</div>
				<?php include( get_theme_file_path( 'includes/share.php' ) ); ?>
			</div>
		</div>
	<?php endif; ?>

	<?php
	$single_coupon_similar = couponis_get_option( 'single_coupon_similar' );
	$single_coupon_similar_number = couponis_get_option( 'single_coupon_similar_number' );
	$coupon_listing_image = couponis_get_option( 'coupon_listing_image' );
	$image_size = 'couponis-grid';
	if( $coupon_listing_image !== 'featured' || (  $coupon_listing_image == 'featured' && !has_post_thumbnail() ) ) {
		$image_size = 'couponis-logo';
	}
	if( $single_coupon_similar == 'yes' ){
		$terms = get_the_terms( get_the_ID(), 'coupon-category' );
		$parent_terms = array();
		if( !empty( $terms ) ){
			foreach( $terms as $term ){
				if( $term->parent == '0' ){
					$parent_terms[] = $term->term_id;
				}
			}
		}

		$similar = new WP_Coupons_Query(array(
			'posts_per_page' => $single_coupon_similar_number,
			'post__not_in'	 => array( get_the_ID() ),
			'tax_query'		 => array(
				array(
					'taxonomy' 	=> 'coupon-category',
					'terms'		=> $parent_terms
				)
			)
		));

		if( $similar->have_posts() ){
			$counter = 1;
			?>
			<div class="widget white-block clearfix widget_widget_latest_coupons similar-coupons">
				<div class="white-block-content">
					<div class="widget-title">
						<h4><?php esc_html_e( 'More Coupons Like This', 'couponis' ) ?></h4>
					</div>
					<ul class="list-unstyled list-inline">
						<?php
						while( $similar->have_posts() ){
							$similar->the_post();
							?>
							<li>
								<div class="similar-badge"><?php echo $counter; ?></div>
								<div class="flex-wrap">
									<?php couponis_get_coupon_image( $image_size ); ?>
									<a <?php echo couponis_get_coupon_link() ?> class="continue-read"><?php the_title() ?></a>
								</div>
							</li>
							<?php
							$counter++;
						}
						?>
					</ul>
				</div>
			</div>
			<?php
		}

		wp_reset_postdata();
	}
	?>

	<?php get_sidebar( 'coupon' ) ?>

</div>