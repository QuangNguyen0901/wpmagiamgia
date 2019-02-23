<div class="white-block coupon-box coupon-grid">

	<?php include( get_theme_file_path( 'includes/coupon-box/coupon-share.php' ) ) ?>

	<?php
	$is_exclusive = couponis_is_exclusive();
	if( $is_exclusive ){
		echo couponis_get_exclusive_badge();
	}
	?>

	<?php include( get_theme_file_path( 'includes/coupon-box/expire.php' ) ) ?>
	
	<?php couponis_get_coupon_image( 'couponis-grid' ) ?>

	<div class="white-block-content">


		<ul class="list-unstyled list-inline coupon-top-meta">
			<li title="<?php esc_attr_e( 'Used', 'couponis' ) ?>">
				<span class="icon-lock-open"></span> <?php echo couponis_get_the_usage(); ?>
			</li>
			<li>
				<?php include( get_theme_file_path( 'includes/coupon-box/bottom-meta.php' ) ) ?>				
			</li>
		</ul>

		<?php include( get_theme_file_path( 'includes/coupon-box/title.php' ) ) ?>

		<?php echo couponis_coupon_action_button( couponis_get_the_coupon_type() ) ?>

	</div>

	<?php include( get_theme_file_path( 'includes/coupon-box/is-expired.php' ) ) ?>

</div>