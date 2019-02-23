<?php
extract( shortcode_atts( array(
	'number' 			=> '',
	'title' 			=> '',
	'stores_carousel' 	=> '',
	'visible_items' 	=> '5',
	'hide_empty' 		=> 'yes',
), $atts ) );

$all_stores = couponis_get_permalink_by_tpl( 'page-tpl_stores', 'couponis' );
if( empty( $all_stores ) ){
	couponis_get_permalink_by_tpl( 'page-tpl_stores_alt', 'couponis' );
}
?>

<?php if( !empty( $title ) ): ?>
	<div class="white-block carousel-wrap carousel-wrap-alt">
		<div class="white-block-content">		
			<div class="widget-title">
				<h4><?php echo esc_html( $title ) ?></h4>
				<a href="<?php echo esc_url( $all_stores ) ?>"><?php esc_html_e( 'All Stores &raquo;', 'couponis' ) ?></a>
			</div>
		</div>
	</div>
<?php endif; ?>
<?php
echo '<div class="stores-carousel-list alt-list" data-visible="'.esc_attr( $visible_items ).'">';
	
if( empty( $stores_carousel ) ){
	$stores_carousel = get_terms( 
		'coupon-store', 
		array( 
			'parent' => 0, 
			'number' => $number,
			'hide_empty' => $hide_empty == 'yes' ? true : false
		) 
	);
}
else{
	$stores_carousel = get_terms( 
		'coupon-store', 
		array( 
			'parent' => 0, 
			'include' => explode( ',', $stores_carousel ),
			'hide_empty' => $hide_empty == 'yes' ? true : false
		) 
	);
}

foreach( $stores_carousel as $store ){
	?>
	<div class="store-item">
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
					<?php echo esc_html( $store->name ) ?>
				</a>
			</div>
		</div>
	</div>
	<?php
}
echo '</div>';
?>