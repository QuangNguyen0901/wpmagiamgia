<?php
if( couponis_is_expired( $expire ) ){
	?>
	<div class="expired-overlay">
		<?php 
		$expired_stamp = couponis_get_option( 'expired_stamp' );
		if( !empty( $expired_stamp['url'] ) ): ?>
			<img src="<?php echo esc_url( $expired_stamp['url'] ) ?>" alt="" width="<?php echo esc_attr( $expired_stamp['width'] ) ?>" height="<?php echo esc_attr( $expired_stamp['height'] ) ?>"/>
		<?php endif; ?>
	</div>
	<?php
}
?>