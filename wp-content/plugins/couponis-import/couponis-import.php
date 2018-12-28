<?php
/*
Plugin Name: Couponis Import
Description: Make sure that you have installed WP All Import in order to use this functionality
Version: 1.6
Author: SpoonThemes
*/

include "rapid-addon.php";

$couponis_addon = new RapidAddon('Couponis Coupon', 'couponis_addon');

/*
Add fields
*/
$couponis_addon->add_title( __( 'Coupon Details', 'couponis' ) );
$couponis_addon->add_text( __( 'All fields for importing coupon are located in this section and you do not need to set anything in the Custom Fields section regarding coupons. All required fields are marked with *', 'couponis' ) );

$couponis_addon->add_field( 
	'type', 
	__( 'Coupon Type (In database - coupon/deal) *', 'couponis' ), 
	'radio',
	array(
		'1' => __( 'Online Code', 'couponis' ),
		'2' => __( 'In Store Code', 'couponis' ),
		'3' => __( 'Online Sale', 'couponis' ),
	)
);

$couponis_addon->add_field( 
	'exclusive', 
	__( 'Is Exclusive', 'couponis' ), 
	'radio',
	array(
		'0' => __( 'No', 'couponis' ),
		'1' => __( 'Yes', 'couponis' ),
	)
);

$couponis_addon->add_field( 'expire', __( 'Coupon Expire', 'couponis' ), 'text', null );

$couponis_addon->add_title( __( 'Coupon Data *', 'couponis' ) );
$couponis_addon->add_field( 'coupon_printable', __( 'Prinateble Coupon Image', 'couponis' ), 'image' );

$couponis_addon->add_field( 'coupon_code', __( 'Coupon Code', 'couponis' ), 'text' );
$couponis_addon->add_field( 'coupon_url', __( 'Coupon URL', 'couponis' ), 'text' );
$couponis_addon->add_field( 'coupon_affiliate', __( 'Coupon Affiliate URL', 'couponis' ), 'text' );

$couponis_addon->disable_default_images();
$couponis_addon->add_field( 'coupon_image', __( 'Coupon Featured Image ( Patch for WP All Import Free Version )', 'couponis' ), 'image' );
$couponis_addon->add_field( 'coupon_image_alt', __( 'Coupon Featured Image Alt Text ( Patch for WP All Import Free Version )', 'couponis' ), 'text' );


$couponis_addon->add_title( __( 'Store Details', 'couponis' ) );
$couponis_addon->add_text( __( 'This import assumes that each coupon has only one store associated to it', 'couponis' ) );
$couponis_addon->add_field( 'store_url', __( 'Store URL', 'couponis' ), 'text' );
$couponis_addon->add_field( 'store_image', __( 'Store Logo', 'couponis' ), 'image' );
$couponis_addon->add_field( 'store_image_alt', __( 'Store Logo Image Alt Text', 'couponis' ), 'text' );
$couponis_addon->add_field( 'store_description', __( 'Store Description', 'couponis' ), 'text' );


/*
Starting import functions and handling of import data
*/
$couponis_addon->set_import_function('couponis_process_import');

$couponis_addon->admin_notice( __( 'Couponis recommends that you install WP All Import In order to use import functionality', 'couponis' ) );

$couponis_addon->run(
	array(
		"post_types" => array( "coupon" )
	)
); 

$couponis_store_data = array();
add_action( 'wp_all_import_associate_term', 'couponis_process_store', 999, 3 );
add_filter( 'wp_all_import_is_post_to_delete', 'couponis_delete_non_existing', 999, 2 );


function couponis_process_import_coupon( $post_id, $data ){
	global $couponis_addon, $couponis_store_data;
	$couponis_store_data = array();

	couponis_save_coupon_meta( $data['type'], 'ctype', $post_id );
	if( !empty( $data['coupon_image']['attachment_id'] ) && !$data['coupon_image']['featured_as_store'] ){
		set_post_thumbnail( $post_id,  $data['coupon_image']['attachment_id'] );
		if( !empty( $data['coupon_image_alt'] ) ){
			update_post_meta( $data['coupon_image']['attachment_id'], '_wp_attachment_image_alt', $data['coupon_image_alt'] );
		}
	}

	if( empty( $data['expire'] ) ){
		$data['expire'] = 99999999999;
	}
	else{
		if( !is_numeric( $data['expire'] ) ){
			$data['expire'] = strtotime( $data['expire'] );
		}
		$time = date('H:i:s', $data['expire']);
		/* if time is not present set it to 23:59:59 so the coupon can be available at the expire day */
		if( $time == '00:00:00' ){
			$data['expire'] += 86399;
		}		
	}
	couponis_save_coupon_meta( $data['expire'], 'expire', $post_id );

	if( !empty( $data['exclusive'] ) ){
		couponis_save_coupon_meta( $data['exclusive'], 'exclusive', $post_id );
	}

	/* SAVE COUPON SPECIFIC DATA */
	switch( $data['type'] ){
		case '1' : update_post_meta( $post_id, 'coupon_code', $data['coupon_code'] ); break;
		case '2' : update_post_meta( $post_id, 'coupon_printable', $data['coupon_printable']['attachment_id'] ); break;
		case '3' : update_post_meta( $post_id, 'coupon_code', $data['coupon_code'] ); break;
	}	

	if( !empty( $data['coupon_affiliate'] ) ){
		update_post_meta( $post_id, 'coupon_affiliate', $data['coupon_affiliate'] );
	}

	if( !empty( $data['coupon_url'] ) ){
		update_post_meta( $post_id, 'coupon_url', $data['coupon_url'] );
	}	

	
	if( $data['coupon_image']['featured_as_store'] ){
		$data['store_image'] = $data['coupon_image'];
	}
	$couponis_store_data = $data;
}


function couponis_process_import($post_id, $data, $import_options) {
	global $couponis_addon;

	if ( $couponis_addon->can_update_meta( 'type', $import_options ) ) {
		if( !empty( $data['type'] ) ){
			couponis_process_import_coupon( $post_id, $data );
		}
		else{
			$couponis_addon->log( __( 'Couponis - missing coupon type, skipping this coupon', 'couponis' ) );
		}
	}
}


function couponis_process_store( $post_id, $term_id, $taxonomy ){
	global $couponis_addon, $couponis_store_data;

	if( $taxonomy == 'coupon-store' ){
		if( !empty( $term_id ) ){
			if( !empty( $couponis_store_data['store_description'] ) ){
				wp_update_term( $term_id, 'coupon-store', array(
					'description' => $couponis_store_data['store_description']
				));
			}		
			if( !empty( $couponis_store_data['store_url'] ) ){
				update_term_meta( $term_id, 'store_url', $couponis_store_data['store_url'] );
			}

			if( empty( $couponis_store_data['store_image']['attachment_id'] ) && !empty( $couponis_store_data['store_image']['image_url_or_path'] ) ){
				$couponis_store_data['store_image']['attachment_id'] = PMXI_API::upload_image($post_id, $couponis_store_data['store_image']['image_url_or_path'], $couponis_store_data['store_image']['download'], $couponis_addon, true, 'store-image-'.$term_id);
			}

			if( !empty( $couponis_store_data['store_image']['attachment_id'] ) ){
				update_term_meta( $term_id, 'store_image', $couponis_store_data['store_image']['attachment_id'] );
				if( !empty( $couponis_store_data['store_image_alt'] ) ){
					update_post_meta( $couponis_store_data['store_image']['attachment_id'], '_wp_attachment_image_alt', $couponis_store_data['store_image_alt'] );
				}

				if( $couponis_store_data['store_image']['featured_as_store'] ){
					set_post_thumbnail( $post_id, $couponis_store_data['store_image']['attachment_id'] );
				}

			}
			else{
				delete_term_meta( $term_id, 'store_image' );
			}

			$couponis_addon->log( __( 'Couponis - saved store meta', 'couponis' ) );
		}
		else{
			$couponis_addon->log( __( 'Couponis - coupon does not have stores, skipping', 'couponis' ) );
		}
	}
}

function couponis_delete_non_existing( $to_delete, $post_id ){
	if( $to_delete === true ){
		couponis_delete_extra_data( $post_id );
	}
}
?>