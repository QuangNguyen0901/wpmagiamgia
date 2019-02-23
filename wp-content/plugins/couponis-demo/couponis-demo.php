<?php
/*
Plugin Name: Coupoins Demo Importer
Plugin URI: http://themeforest.net/user/spoonthemes
Description: Coupoins demo content importer
Version: 1.5
Author: SpoonThemes
Author URI: http://themeforest.net/user/spoonthemes
License: GNU General Public License version 3.0
*/

/*
Include file from plugin if it is not available in theme
*/
if( !function_exists('couponis_get_theme_filepath') ){
function couponis_get_theme_filepath($path, $file){
	if( !file_exists( $path ) ){
		$plugin_path = plugin_dir_path( __FILE__ ).$file;
		if( file_exists( $plugin_path ) ){
			$path = $plugin_path;
		}
	}

	return $path;
}
}
add_filter( 'theme_file_path', 'couponis_get_theme_filepath', 10, 2 );

/*
Include functions from functions.php in order to maintain  users child theme functions Functions related to core WP are left in themes functions.php
*/
if( !function_exists('couponis_system_functions') ){
function couponis_system_functions(){
	include( plugin_dir_path( __FILE__ ).'functions.php' );
}
}
add_action('after_setup_theme', 'couponis_system_functions');


/*
Register post types
*/
if( !function_exists('couponis_register_types') ){
function couponis_register_types(){
	$taxonomies = array();

	/* PROJECT CUSTOM POST TYPE */
	$use_coupon_single = ( function_exists( 'couponis_get_option' ) && couponis_get_option( 'use_coupon_single' ) == 'yes' ) ? true : false;
	$coupon_args = array(
		'labels' => array(
			'name' => __( 'Coupons', 'couponis' ),
			'singular_name' => __( 'Coupon', 'couponis' )
		),
		'public' => true,
		'show_in_rest' => true,
		'menu_icon' => 'dashicons-tag',
		'publicly_queryable' => $use_coupon_single,
		'has_archive' => true,
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
			'comments'
		)
	);

	if( class_exists('ReduxFramework') && function_exists('couponis_get_option') ){
		$trans_coupon = couponis_get_option( 'trans_coupon' );
		if( !empty( $trans_coupon ) ){
			$coupon_args['rewrite'] = array( 'slug' => $trans_coupon );
		}
	}
	register_post_type( 'coupon', $coupon_args );

	/* PROJECT TAXONIMIES */
	$taxonomies[] = array(
		'slug' 			=> 'coupon-category',
		'plural' 		=> __( 'Categories', 'couponis' ),
		'singular' 		=> __( 'Category', 'couponis' ),
		'hierarchical' 	=> true,
		'post_type' 	=> 'coupon',
		'rewrite' 		=> class_exists('ReduxFramework') && function_exists('couponis_get_option') ? couponis_get_option( 'trans_coupon-category' ) : ''
	);
	$taxonomies[] = array(
		'slug' 			=> 'coupon-store',
		'plural' 		=> __( 'Stores', 'couponis' ),
		'singular' 		=> __( 'Store', 'couponis' ),
		'hierarchical' 	=> true,
		'post_type' 	=> 'coupon',
		'rewrite' 		=> class_exists('ReduxFramework') && function_exists('couponis_get_option') ? couponis_get_option( 'trans_coupon-store' ) : ''
	);

	for( $i=0; $i<sizeof( $taxonomies ); $i++ ){
		$val = $taxonomies[$i];
		$tax_args = array(
			'show_in_rest'	=> true,
			'label' => $val['plural'],
			'hierarchical' => $val['hierarchical'],
			'labels' => array(
				'name' 							=> $val['plural'],
				'singular_name' 				=> $val['singular'],
				'menu_name' 					=> $val['singular'],
				'all_items'						=> esc_html__( 'All ', 'couponis' ).$val['plural'],
				'edit_item'						=> esc_html__( 'Edit ', 'couponis' ).$val['singular'],
				'view_item'						=> esc_html__( 'View ', 'couponis' ).$val['singular'],
				'update_item'					=> esc_html__( 'Update ', 'couponis' ).$val['singular'],
				'add_new_item'					=> esc_html__( 'Add New ', 'couponis' ).$val['singular'],
				'new_item_name'					=> esc_html__( 'New ', 'couponis').$val['singular'].__( ' Name', 'couponis' ),
				'parent_item'					=> esc_html__( 'Parent ', 'couponis' ).$val['singular'],
				'parent_item_colon'				=> esc_html__( 'Parent ', 'couponis').$val['singular'].__( ':', 'couponis' ),
				'search_items'					=> esc_html__( 'Search ', 'couponis' ).$val['plural'],
				'popular_items'					=> esc_html__( 'Popular ', 'couponis' ).$val['plural'],
				'separate_items_with_commas'	=> esc_html__( 'Separate ', 'couponis').strtolower( $val['plural'] ).__( ' with commas', 'couponis' ),
				'add_or_remove_items'			=> esc_html__( 'Add or remove ', 'couponis' ).strtolower( $val['plural'] ),
				'choose_from_most_used'			=> esc_html__( 'Choose from the most used ', 'couponis' ).strtolower( $val['plural'] ),
				'not_found'						=> esc_html__( 'No ', 'recouponisiews' ).strtolower( $val['plural'] ).__( ' found', 'couponis' ),
			),

		);
	
		if( !empty( $val['rewrite'] ) ){
			$tax_args['rewrite'] = array( 'slug' => $val['rewrite'] );
		}

		register_taxonomy( $val['slug'], $val['post_type'], $tax_args );
	}
}
add_action( 'init', 'couponis_register_types' );
}

/*
Create necessarty additional tables
*/
if( !function_exists( 'couponis_create_tables' ) ){
function couponis_create_tables(){
	global $wpdb;

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE {$wpdb->prefix}couponis_coupon_data (
	  coupon_id mediumint(9) NOT NULL AUTO_INCREMENT,
	  post_id mediumint(9),
	  expire varchar(255),
	  ctype varchar(1),
	  exclusive varchar(1),
	  used mediumint NOT NULL default 0,
	  positive mediumint NOT NULL default 0,
	  negative mediumint NOT NULL default 0,
	  success mediumint NOT NULL default 0,
	  UNIQUE KEY coupon_id (coupon_id)
	) $charset_collate;";
	dbDelta( $sql );

	$sidebars_widgets = get_option( 'couponis_sidebar_widgets' );
	if( !empty( $sidebars_widgets ) ){
		update_option( 'sidebars_widgets', $sidebars_widgets );	
	}
	
}
register_activation_hook( __FILE__, 'couponis_create_tables' );
}

function couponis_save_widgets(){
	$sidebars_widgets = get_option( 'sidebars_widgets' );
	update_option( 'couponis_sidebar_widgets', $sidebars_widgets );
}
register_deactivation_hook( __FILE__, 'couponis_save_widgets');


if( !function_exists('couponis_send_mail') ){
function couponis_send_mail( $email_to, $subject, $message, $headers = array() ){
	$sender_name = couponis_get_option( 'sender_name' );
	$sender_email = couponis_get_option( 'sender_email' );
    $headers[] = "Content-Type: text/html; charset=UTF-8"; 
    $headers[] = "From: ".esc_attr( $sender_name )." <".esc_attr( $sender_email ).">";	
	return wp_mail( $email_to, $subject, $message, $headers );
}
}

remove_filter('wp_get_attachment_image_src', 'kc_get_attachment_image_src', 999, 4);

?>