<?php
/*
Plugin Name: Coupoins Demo Importer
Plugin URI: http://themeforest.net/user/spoonthemes
Description: Coupoins demo content importer
Version: 1.3
Author: SpoonThemes
Author URI: http://themeforest.net/user/spoonthemes
License: GNU General Public License version 3.0
*/

include( plugin_dir_path( __FILE__ ).'mailchimp.php' );
if( is_admin() ){
	include( plugin_dir_path( __FILE__ ).'radium-one-click-demo-install/init.php' );
}

/*
Register post types
*/
if( !function_exists('couponis_register_types') ){
function couponis_register_types(){
	$taxonomies = array();

	/* PROJECT CUSTOM POST TYPE */
	$use_coupon_single = couponis_get_option( 'use_coupon_single' ) == 'yes' ? true : false;
	$coupon_args = array(
		'labels' => array(
			'name' => __( 'Coupons', 'couponis-cpt' ),
			'singular_name' => __( 'Coupon', 'couponis-cpt' )
		),
		'public' => true,
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
		'plural' 		=> __( 'Categories', 'couponis-cpt' ),
		'singular' 		=> __( 'Category', 'couponis-cpt' ),
		'hierarchical' 	=> true,
		'post_type' 	=> 'coupon',
		'rewrite' 		=> class_exists('ReduxFramework') && function_exists('couponis_get_option') ? couponis_get_option( 'trans_coupon-category' ) : ''
	);
	$taxonomies[] = array(
		'slug' 			=> 'coupon-store',
		'plural' 		=> __( 'Stores', 'couponis-cpt' ),
		'singular' 		=> __( 'Store', 'couponis-cpt' ),
		'hierarchical' 	=> true,
		'post_type' 	=> 'coupon',
		'rewrite' 		=> class_exists('ReduxFramework') && function_exists('couponis_get_option') ? couponis_get_option( 'trans_coupon-store' ) : ''
	);

	for( $i=0; $i<sizeof( $taxonomies ); $i++ ){
		$val = $taxonomies[$i];
		$tax_args = array(
			'label' => $val['plural'],
			'hierarchical' => $val['hierarchical'],
			'labels' => array(
				'name' 							=> $val['plural'],
				'singular_name' 				=> $val['singular'],
				'menu_name' 					=> $val['singular'],
				'all_items'						=> esc_html__( 'All ', 'couponis-cpt' ).$val['plural'],
				'edit_item'						=> esc_html__( 'Edit ', 'couponis-cpt' ).$val['singular'],
				'view_item'						=> esc_html__( 'View ', 'couponis-cpt' ).$val['singular'],
				'update_item'					=> esc_html__( 'Update ', 'couponis-cpt' ).$val['singular'],
				'add_new_item'					=> esc_html__( 'Add New ', 'couponis-cpt' ).$val['singular'],
				'new_item_name'					=> esc_html__( 'New ', 'couponis-cpt').$val['singular'].__( ' Name', 'couponis-cpt' ),
				'parent_item'					=> esc_html__( 'Parent ', 'couponis-cpt' ).$val['singular'],
				'parent_item_colon'				=> esc_html__( 'Parent ', 'couponis-cpt').$val['singular'].__( ':', 'couponis-cpt' ),
				'search_items'					=> esc_html__( 'Search ', 'couponis-cpt' ).$val['plural'],
				'popular_items'					=> esc_html__( 'Popular ', 'couponis-cpt' ).$val['plural'],
				'separate_items_with_commas'	=> esc_html__( 'Separate ', 'couponis-cpt').strtolower( $val['plural'] ).__( ' with commas', 'couponis-cpt' ),
				'add_or_remove_items'			=> esc_html__( 'Add or remove ', 'couponis-cpt' ).strtolower( $val['plural'] ),
				'choose_from_most_used'			=> esc_html__( 'Choose from the most used ', 'couponis-cpt' ).strtolower( $val['plural'] ),
				'not_found'						=> esc_html__( 'No ', 'recouponis-cptiews' ).strtolower( $val['plural'] ).__( ' found', 'couponis-cpt' ),
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
}
register_activation_hook( __FILE__, 'couponis_create_tables' );
}

?>