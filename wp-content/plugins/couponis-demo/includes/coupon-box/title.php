<h4>
	<?php $title = get_the_title(); ?>
	<a <?php echo couponis_get_coupon_link() ?> title="<?php echo esc_attr( $title ) ?>">
		<?php  echo esc_html( $title ); ?>
	</a>
</h4>