<div class="white-block coupon-box coupon-list">

	<?php include( get_theme_file_path( 'includes/coupon-box/coupon-share.php' ) ) ?>

	<div class="white-block-content">
		<div class="flex-wrap">
			<div class="flex-left">
				<?php couponis_get_coupon_image( 'couponis-list' ) ?>
			</div>
			<div class="flex-middle">

				<ul class="list-unstyled list-inline coupon-top-meta">
					<?php
					$is_exclusive = couponis_is_exclusive();
					if( $is_exclusive ):
					?>
					<li>
						<?php echo couponis_get_exclusive_badge() ?>
					</li>
					<?php endif; ?>
					<li>
						<div class="used">
							<span class="icon-lock-open"></span> <?php echo couponis_get_the_usage() ?>
						</div>
					</li>
				</ul>

				<?php include( get_theme_file_path( 'includes/coupon-box/description.php' ) ) ?>

			</div>
			<div class="flex-right">

				<?php include( get_theme_file_path( 'includes/coupon-box/expire.php' ) ) ?>

				<?php echo couponis_coupon_action_button( couponis_get_the_coupon_type() ) ?>

				<?php include( get_theme_file_path( 'includes/coupon-box/bottom-meta.php' ) ) ?>

			</div>
		</div>

	</div>

	<?php include( get_theme_file_path( 'includes/coupon-box/is-expired.php' ) ) ?>

</div>