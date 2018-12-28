<div class="col-sm-2">
	<div class="white-block store-block white-block-small-margin">
		<div class="white-block-content">
			<div class="store-image">
				<a href="<?php echo esc_url( get_term_link( $store ) ) ?>">
					<?php echo couponis_get_coupon_store_logo( $store->term_id ); ?>
				</a>
			</div>

			<?php echo couponis_save_store_link( $store->term_id ) ?>	
		</div>
	</div>
	<div class="white-block store-block store-title">
		<div class="white-block-content">
			<a href="<?php echo esc_url( get_term_link( $store ) ) ?>">
				<?php echo  $store->name ?>
			</a>
		</div>
	</div>
</div>