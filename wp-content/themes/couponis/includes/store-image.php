<?php

/* Custom Meta For Taxonomies */
/* Adding New */
if( !function_exists('couponis_store_icon_add') ){
function couponis_store_icon_add() {
	?>
	<div class="form-field">
		<label for="store_image"><?php esc_html_e( 'Image:', 'couponis' ) ?></label>
		<input type="hidden" name="store_image" value="">
		<div class="image-holder">
		</div>
		<a href="javascript:;" class="add_store_image button"><?php esc_html_e( 'Select Image', 'couponis' ); ?></a>
		<p class="description"><?php esc_html_e( 'Select image for the store','couponis' ); ?></p>
	</div>
	<div class="form-field">
		<label for="store_image"><?php esc_html_e( 'Store URL:', 'couponis' ); ?></label>
		<input type="text" name="store_url" value="">
		<p class="description"><?php esc_html_e( 'Input URL of the store','couponis' ); ?></p>
	</div>
	<div class="form-field">
		<label><?php esc_html_e( 'Store Locations:', 'couponis' ); ?></label>
		<?php couponis_store_marker_wrap(); ?>
		<p class="description"><?php esc_html_e( 'Input location of the store in form LATITUDE,LONGITUDE','couponis' ); ?></p>
		<a href="#" class="add-store-marker button"><?php esc_html_e( 'Add New Marker', 'couponis' ); ?></a>
	</div>
	<?php
}
add_action( 'coupon-store_add_form_fields', 'couponis_store_icon_add', 10, 2 );
}

if( !function_exists( 'couponis_store_marker_wrap' ) ){
function couponis_store_marker_wrap( $value = '' )  {
	?>	
	<div class="store-marker-wrap">
		<input type="text" name="store_location[]" value="<?php echo esc_attr( $value ) ?>">
		<a href="#" class="remove-store-marker button">X</a>
	</div>	
	<?php	
}
}

/* Editing */
if( !function_exists('couponis_store_icon_edit') ){
function couponis_store_icon_edit( $term ) {
	$store_image = get_term_meta( $term->term_id, 'store_image', true );
	$store_url = get_term_meta( $term->term_id, 'store_url', true );
	$store_location = get_term_meta( $term->term_id, 'store_location', true );
	?>
	<table class="form-table">
		<tbody>
			<tr class="form-field">
				<th scope="row"><label for="store_image"><?php esc_html_e( 'Image', 'couponis' ); ?></label></th>
				<td>
					<input type="hidden" name="store_image" value="<?php echo esc_attr( $store_image ) ?>">
					<div class="image-holder">
						<?php
						if( !empty( $store_image ) ){
							echo wp_get_attachment_image( $store_image, 'thumbnail' );
							echo '<a href="javascript:;" class="button remove_store_image">X</a>';
						}
						?>
					</div>
					<a href="javascript:;" class="add_store_image button"><?php esc_html_e( 'Select Image', 'couponis' ); ?></a>
					<p class="description"><?php esc_html_e( 'Select image for the store', 'couponis' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row"><label for="store_image"><?php esc_html_e( 'Store URL', 'couponis' ); ?></label></th>
				<td>
					<input type="text" name="store_url" value="<?php echo esc_attr( $store_url ) ?>">
					<p class="description"><?php esc_html_e( 'Input URL of the store', 'couponis' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row"><label><?php esc_html_e( 'Store Locations', 'couponis' ); ?></label></th>
				<td>
					<?php 
					if( !empty( $store_location ) ){
						$store_location = explode('|', $store_location);
						foreach( $store_location as $store_marker ){
							couponis_store_marker_wrap( $store_marker );
						}
					}
					else{
						couponis_store_marker_wrap();
					}
					?>
					<p class="description"><?php esc_html_e( 'Input location of the store in form LATITUDE,LONGITUDE','couponis' ); ?></p>
					<a href="#" class="add-store-marker button"><?php esc_html_e( 'Add New Marker', 'couponis' ); ?></a>
				</td>
			</tr>
		</tbody>
	</table>
	<?php
}
add_action( 'coupon-store_edit_form_fields', 'couponis_store_icon_edit', 10, 2 );
}

/* Save It */
if( !function_exists('couponis_store_icon_save') ){
function couponis_store_icon_save( $term_id ) {
	if ( isset( $_POST['store_image'] ) ) {
		update_term_meta( $term_id, 'store_image', $_POST['store_image'] );
	}
	else if( $_POST['action'] !== 'inline-save-tax' ){
		delete_term_meta( $term_id, 'store_image' );
	}
	if ( isset( $_POST['store_url'] ) ) {
		update_term_meta( $term_id, 'store_url', $_POST['store_url'] );
	}
	else if( $_POST['action'] !== 'inline-save-tax' ){
		delete_term_meta( $term_id, 'store_url' );
	}
	if ( isset( $_POST['store_location'] ) ) {
		$store_location = implode( '|', $_POST['store_location'] );
		update_term_meta( $term_id, 'store_location', $store_location );
	}
	else if( $_POST['action'] !== 'inline-save-tax' ){
		delete_term_meta( $term_id, 'store_location' );
	}
}  
add_action( 'edited_coupon-store', 'couponis_store_icon_save', 10, 2 );  
add_action( 'create_coupon-store', 'couponis_store_icon_save', 10, 2 );
}


/* Delete It */
if( !function_exists('couponis_store_icon_delete') ){
function couponis_store_icon_delete( $t, $object_id, $meta_key, $meta_value ) {
	if( $meta_key == 'store_image' ){
		$delete_store_images = couponis_get_option( 'delete_store_images' );
		if( $delete_store_images == 'yes' ){
			wp_delete_attachment( $meta_value, true );
		}
	}
	return $t;
}  
add_action( 'delete_term_meta', 'couponis_store_icon_delete', 10, 4 );  
}

/* Add icon column */
if( !function_exists('couponis_store_column') ){
function couponis_store_column( $columns ) {
    $new_columns = array(
        'cb' 			=> '<input type="checkbox" />',
        'name' 			=> esc_html__('Name', 'couponis'),
		'description' 	=> esc_html__('Description', 'couponis'),
        'slug' 			=> esc_html__( 'Slug', 'couponis' ),
        'posts' 		=> esc_html__( 'Posts', 'couponis' ),
		'store_image' 	=> esc_html__( 'Image', 'couponis' )
        );
    return $new_columns;
}
add_filter("manage_edit-coupon-store_columns", 'couponis_store_column'); 
}

if( !function_exists('couponis_populate_store_column') ){
function couponis_populate_store_column( $out, $column_name, $term_id ){
    switch ( $column_name ) {  	
 		case 'store_image':
			$store_image = get_term_meta( $term_id, 'store_image', true );
            $out .= wp_get_attachment_image( $store_image, 'thumbnail' );
            break;
        default:
            break;
    }

    return $out; 
}
add_filter("manage_coupon-store_custom_column", 'couponis_populate_store_column', 10, 3);
}
?>