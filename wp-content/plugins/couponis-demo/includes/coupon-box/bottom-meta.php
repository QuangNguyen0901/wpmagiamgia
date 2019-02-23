<?php
$use_coupon_single = couponis_get_option( 'use_coupon_single' );
?>
<ul class="list-unstyled list-inline coupon-bottom-meta">
	<?php if( $use_coupon_single == 'yes' ): ?>
		<li>
			<a href="<?php the_permalink() ?>#comments"><span class="icon-bubbles"></span> <?php echo get_comments_number() ?></a>
		</li>
	<?php endif; ?>
	<?php echo couponis_save_coupon_link( get_the_ID() ) ?>
	<?php if( couponis_get_option( 'enable_share' ) == 'yes' && $use_coupon_single == 'yes' ): ?>
		<li>
			<a href="javascript:;" class="toggle-coupon-share" data-target="share-<?php echo esc_attr( get_the_ID() ) ?>"><span class="icon-share"></span></a>
		</li>
	<?php endif; ?>
</ul>