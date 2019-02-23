<?php

get_header();
the_post();

$single_coupon_sidebar_pos = couponis_get_option( 'single_coupon_sidebar_pos' );

$categories = get_the_terms( get_the_ID(), 'coupon-category' );

$type = couponis_get_the_coupon_type();
$is_exclusive = couponis_is_exclusive();

$expire = couponis_get_the_expire_time();

$positive = couponis_get_the_positives();
$negative = couponis_get_the_negatives();
$success = couponis_get_the_success();

$color = '#D91E18';
if( $success > 66 ){
	$color = '#26A65B';
}
else if( $success > 34 ){
	$color = '#F9BF3B';
}

$content = get_the_content();
?>

<main>
	<div class="container">
		<div class="row">

			<?php if( $single_coupon_sidebar_pos == 'left' ) { include( get_theme_file_path( 'includes/single-coupon-sidebar.php' ) ); } ?>

			<div class="col-sm-8">
				<div class="white-block">

					<?php if( has_post_thumbnail() ): ?>
						<div class="white-block-media">
							<?php the_post_thumbnail( 'post-thumbnail' ); ?>
						</div>
					<?php endif; ?>

					<div class="white-block-single-content">

						<div class="single-badges">
							<?php 
							if( $is_exclusive ){
								echo couponis_get_exclusive_badge();
							}							
							echo couponis_coupon_type_badge( $type );
							?>
						</div>

						<h1 class="blog-item-title h2-size"><?php the_title(); ?></h1>


						<ul class="list-unstyled featured-bottom-meta flex-wrap <?php echo empty( $content ) ? esc_attr('no-margin') : '' ?> flex-always">
							<?php if( !empty( $categories ) ): ?>
								<li>
									<i class="icon-target"></i>
									<?php echo couponis_print_coupon_parents( $categories ); ?>
								</li>
							<?php endif; ?>
						</ul>					

						<div class="post-content clearfix">
							<?php echo apply_filters('the_content', $content); ?>	
						</div>
					</div>

				</div>

				<?php comments_template( '', true ) ?>

			</div>

			<?php if( $single_coupon_sidebar_pos == 'right' ) { include( get_theme_file_path( 'includes/single-coupon-sidebar.php' ) ); } ?>

		</div>
	</div>
</main>

<?php get_footer(); ?>