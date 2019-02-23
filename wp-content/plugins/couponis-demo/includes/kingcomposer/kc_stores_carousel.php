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

<div class="white-block carousel-wrap">
	<?php if( !empty( $title ) ): ?>
		<div class="white-block-content">		
			<div class="widget-title">
				<h4><?php echo esc_html( $title ) ?></h4>
				<a href="<?php echo esc_url( $all_stores ) ?>"><?php esc_html_e( 'All Stores &raquo;', 'couponis' ) ?></a>
			</div>
		</div>
	<?php endif; ?>
	<?php
	echo '<div class="stores-carousel-list" data-visible="'.esc_attr( $visible_items ).'">';
		
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
		<a href="<?php echo esc_url( get_term_link( $store ) ) ?>" title="<?php echo esc_attr( $store->name ) ?>">
			<?php echo couponis_get_coupon_store_logo( $store->term_id ) ?>
		</a>
		<?php
	}
	echo '</div>';
	?>
</div>