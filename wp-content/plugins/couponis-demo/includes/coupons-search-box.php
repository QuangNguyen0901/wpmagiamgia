<?php
$coupon_types = couponis_get_option( 'coupon_types' );
$ajax_taxonomy = couponis_get_option( 'ajax_taxonomy' );
?>
<form method="GET" action="<?php echo esc_url( couponis_get_permalink_by_tpl( 'page-tpl_search' ) ); ?>" class="widget-search-coupons">	
	<?php if( empty( $coupon_types ) || sizeof( $coupon_types ) > 1 ): ?>
		<label><?php esc_html_e( 'Search For', 'couponis' ) ?></label>
		<div class="form-group types-wrap clearfix">
			<?php $types = !empty( $_GET['type'] ) ? explode( ",", $_GET['type'] ) : array() ?>
			<?php if( empty( $coupon_types ) || in_array( '1', $coupon_types ) ): ?>
				<a href="javascript:;" class="search-type <?php echo in_array( '1', $types ) ? esc_attr( 'type-added' ) : '' ?>" data-value="1">
					<i class="icon-link"></i>
					<?php esc_html_e( 'ONLINE CODES', 'couponis' ) ?>
				</a>
			<?php endif; ?>
			<?php if( empty( $coupon_types ) || in_array( '2', $coupon_types ) ): ?>
				<a href="javascript:;" class="search-type <?php echo in_array( '2', $types ) ? esc_attr( 'type-added' ) : '' ?>" data-value="2">
					<i class="icon-tag"></i>
					<?php esc_html_e( 'STORE CODES', 'couponis' ) ?>
				</a>
			<?php endif; ?>
			<?php if( empty( $coupon_types ) || in_array( '3', $coupon_types ) ): ?>			
				<a href="javascript:;" class="search-type <?php echo in_array( '3', $types ) ? esc_attr( 'type-added' ) : '' ?>" data-value="3">
					<i class="icon-clock"></i>
					<?php esc_html_e( 'ONLINE SALES', 'couponis' ) ?>
				</a>
			<?php endif; ?>
			<input type="hidden" value="<?php echo esc_attr( implode( ",", $types ) ) ?>" name="type" />
		</div>
	<?php endif; ?>

	<div class="form-group">
		<label for="keyword"><?php esc_html_e( 'Keyword', 'couponis' ) ?></label>
		<input type="text" id="keyword" name="keyword" class="form-control" value="<?php echo !empty( $_GET['keyword'] ) ? esc_attr( $_GET['keyword'] ) : '' ?>" />
	</div>

	<div class="row">
		<div class="col-sm-6">
			<div class="form-group">
				<label for="category"><?php esc_html_e( 'Category', 'couponis' ) ?></label>
				<div class="styled-select select2-styled">
					<select name="category" id="category" class="<?php echo $ajax_taxonomy == 'yes' ? esc_attr( 'launch-select2' ) : '' ?>" data-taxonomy="coupon-category">
						<option value=""><?php esc_html_e( '- Select -', 'couponis' ) ?></option>
						<?php
						if( $ajax_taxonomy == 'yes' ){
							if( !empty( $category ) ){
								$term = get_term_by( 'id', $category, 'coupon-category' );
								?>
								<option value="<?php echo esc_attr( $term->term_id ) ?>" selected="selected"><?php echo esc_html( $term->name ) ?></option>
								<?php
							}
						}
						else{
							$categories = couponis_get_hierarchical_terms( 'coupon-category' );
							$selected = !empty( $_GET['category'] ) ? $_GET['category'] : '';
							couponis_list_terms_select( $categories, $selected );
						}
						?>
					</select>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				<label for="store"><?php esc_html_e( 'Store', 'couponis' ) ?></label>
				<div class="styled-select select2-styled">
					<select name="store" id="store" class="<?php echo $ajax_taxonomy == 'yes' ? esc_attr( 'launch-select2' ) : '' ?>" data-taxonomy="coupon-store">
						<option value=""><?php esc_html_e( '- Select -', 'couponis' ) ?></option>
						<?php
						if( $ajax_taxonomy == 'yes' ){
							if( !empty( $store ) ){
								$term = get_term_by( 'id', $store, 'coupon-store' );
								?>
								<option value="<?php echo esc_attr( $term->term_id ) ?>" selected="selected"><?php echo esc_html( $term->name ) ?></option>
								<?php
							}
						}
						else{
							$stores = couponis_get_hierarchical_terms( 'coupon-store' );
							$selected = !empty( $_GET['store'] ) ? $_GET['store'] : '';
							couponis_list_terms_select( $stores, $selected );
						}
						?>
					</select>
				</div>
			</div>
		</div>
	</div>

	<a href="javascript:;" class="btn submit-form"><?php esc_html_e( 'SEARCH', 'couponis' ) ?></a>
</form>