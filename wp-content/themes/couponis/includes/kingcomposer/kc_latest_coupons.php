<div class="latest-coupons">
	<?php if( $atts['style'] == 'grid' ): ?>
		<div class="row">
	<?php endif; ?>
		<?php

		$coupons = new WP_Coupons_Query(array(
			'posts_per_page' 	=> $atts['number'],
			'post_status'		=> 'publish',
			'orderby'			=> 'date',
			'order'				=> 'DESC',
			'type'				=> $atts['coupon_type']
		));

		if( $coupons->have_posts() ){
			$counter = 0;
			while( $coupons->have_posts() ){
				$coupons->the_post();
				if( $atts['style'] == 'grid' && $counter == $atts['number_in_row'] ){
					echo '</div><div class="row">';
					$counter = 0;
				}
				$counter++;
				?>
				<?php if( $atts['style'] == 'grid' ): ?>
					<div class="col-sm-<?php echo esc_attr( 12 / $atts['number_in_row'] ) ?>">
				<?php endif; ?>
					<?php
					if( $atts['style'] == 'list' ){
						include( get_theme_file_path( 'includes/coupon-box/coupon-list.php' ) );
					}
					else{
						include( get_theme_file_path( 'includes/coupon-box/coupon-grid.php' ) );
					}
					?>
				<?php if( $atts['style'] == 'grid' ): ?>
					</div>
				<?php endif; ?>
				<?php
			}
		}

		wp_reset_postdata();
		?>
	<?php if( $atts['style'] == 'grid' ): ?>
		</div>
	<?php endif; ?>
</div>