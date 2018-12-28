<ul class="list-unstyled list-inline coupon-top-meta">
	<?php
	$is_exclusive = couponis_is_exclusive();
	if( $is_exclusive ):
	?>
	<li>
		<?php echo couponis_get_exclusive_badge() ?>
	</li>
	<?php endif; ?>
	<li title="<?php esc_attr_e( 'Used', 'couponis' ) ?>">
		<span class="icon-lock-open"></span> <?php echo couponis_get_the_usage() ?>
	</li>
</ul>