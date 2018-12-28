<?php

	/**********************************************************************
	***********************************************************************
	COUPONIS FUNCTIONS
	**********************************************************************/


/*
If needed to be redirected
*/
if( !function_exists('couponis_redirect_external_link') ){
function couponis_redirect_external_link() {
	if( !empty( $_GET['cout'] ) ){
		$external = get_post_meta( $_GET['cout'], 'coupon_affiliate', true );
	}
	else if( !empty( $_GET['sout'] ) ){
		$external = get_term_meta( $_GET['sout'], 'store_url', true );	
	}
	else if( !empty( $_GET['dout'] ) ){
		$external = get_post_meta( $_GET['dout'], 'coupon_url', true );
	}

	if( !empty( $external ) ){
		exit( wp_redirect( $external ) );
	}
}
add_action( 'template_redirect', 'couponis_redirect_external_link' );
}

if( is_dir( get_stylesheet_directory() . '/languages' ) ) {
	load_theme_textdomain('couponis', get_stylesheet_directory() . '/languages');
}
else{
	load_theme_textdomain('couponis', get_template_directory() . '/languages');
}

if( !function_exists('couponis_check_api') ){
function couponis_check_api() {
	$google_api_key = couponis_get_option( 'google_api_key' );
	$couponis_api_notice_disable = get_option( 'couponis_api_notice_disable' );	

	if( empty( $google_api_key ) && empty( $couponis_api_notice_disable ) ){
	    ?>
	    <div class="notice notice-success is-dismissible error google-api-dismiss">
	        <p>
	        	<?php esc_html_e( 'Create Google map API key like it is explained', 'couponis' ); ?>
	        	<a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank"><?php esc_html_e( 'here', 'couponis' ) ?></a>
	        	<?php esc_html_e( 'and place it in Couponis WP -> Contact Page -> Google API Key', 'couponis' ); ?>
	        </p>
	    </div>
	    <?php
	}

	if( function_exists('couponis_process_import_coupon') ):
		$smeta_data = get_plugins( '/couponis-import' );
	    if( $smeta_data['couponis-import.php']['Version'] != '1.6' ):
		    ?>
		    <div class="notice notice-success is-dismissible error">
		        <p><?php esc_html_e( 'Reinstall Couponis Import plugin ( Delete it and theme will offer you to install it again )', 'couponis' ); ?></p>
		    </div>
		    <?php
	    endif;
	endif;	

	if( function_exists('couponis_register_types') ):
		$smeta_data = get_plugins( '/couponis-demo' );
	    if( $smeta_data['couponis-demo.php']['Version'] != '1.3' ):
		    ?>
		    <div class="notice notice-success is-dismissible error">
		        <p><?php esc_html_e( 'Reinstall Couponis Demo plugin ( Delete it and theme will offer you to install it again )', 'couponis' ); ?></p>
		    </div>
		    <?php
	    endif;
	endif;	

	if( function_exists('cmb_init') ):
		$smeta_data = get_plugins( '/smeta' );
	    if( $smeta_data['smeta.php']['Version'] != '1.1' ):
		    ?>
		    <div class="notice notice-success is-dismissible error">
		        <p><?php esc_html_e( 'Reinstall Smeta plugin ( Delete it and theme will offer you to install it again )', 'couponis' ); ?></p>
		    </div>
		    <?php
	    endif;
	endif;

	$upgraded_time = get_option( 'couponis_updgraded_times' );
	if( empty( $upgraded_time ) && function_exists('couponis_create_tables') ){
		global $wpdb;
		$coupons_count = $wpdb->get_col( "SELECT COUNT(coupon_id) AS coupons_count FROM {$wpdb->prefix}couponis_coupon_data" );
		if( $coupons_count[0] > 0 ){
		    ?>
		    <div class="notice notice-success is-dismissible error time-upgrade-dismiss">
		    	<div style="margin-bottom: 20px;">
			        <h4 style="margin-bottom: 10px;">READ CAREFULLY ( UPGRADE OF EXPIRE TIMES )</h4>
			        <b>All coupons which currently have time set to 00:00:00 will be updated to time 23:59:59 so they are available on the selected date as well</b>
		    	</div>
		    	<p>If all of your coupons are added via WP All Import from feed where both date and time of expiration are present you can dismiss this message by clicking X in the upper right corner</p>
		        <p>If at least one coupon is manually added or imported via WP All Import from feed where only date of expiration is present or mix of both or <b>you are not sure</b> click <a href="javascript:;" class="couponis-start-time-upgrade" data-total="<?php echo esc_attr( $coupons_count[0] ) ?>" data-action="couponis_time_upgrade_start">here</a> to upgrade times</p>
		        <div class="upgrade-results"></div>
		    </div>
		    <?php
		}
		else{
			couponis_time_upgrade_completed();
		}
	}

	$upgraded_images = get_option( 'couponis_updgraded_images' );
	if( empty( $upgraded_images ) && function_exists('couponis_create_tables') ){
		global $wpdb;
		$images_count = $wpdb->get_col( "SELECT COUNT(ID) AS images_count FROM {$wpdb->prefix}posts WHERE post_name LIKE 'coupon-image-%' OR post_name LIKE 'store-image-%'" );
		if( $images_count[0] > 0 ){
		    ?>
		    <div class="notice notice-success is-dismissible error image-upgrade-dismiss">
		    	<div style="margin-bottom: 20px;">
			        <h4 style="margin-bottom: 10px;">READ CAREFULLY ( UPGRADE OF IMAGES ) - UPDATE COUPONIS IMPORT PLUGIN (v1.5) BEFORE PROCEEDING</h4>
			        <b>Couponis WP -> Coupons has new option with default settings to No - Delete Coupon Images and Delete Store Images on deletion of coupon/store</b><br/>
			        <b>Import will now generate less images and will check better for existing images.</b>
		    	</div>
		    	<p>If all of your coupons are added manually dismiss this message by clicking X in the upper right corner</p>
		    	<p>If all or some of your coupons are added via WP All Import:
		    		<br> - If you want to remove generated images click <a href="javascript:;" class="couponis-start-image-upgrade" data-total="<?php echo esc_attr( $images_count[0] ) ?>" data-action="couponis_image_upgrade_start">here</a> and after that run import again
		    		<br> - If you do not want to delete generated images ( SEO reasons ) just close this message by clicking X in the upper right corner
		    	</p>
		        <div class="upgrade-image-results"></div>
		    </div>
		    <?php
		}
		else{
			couponis_image_upgrade_completed();
		}
	}

	/*
	Delete records from couponis data table which do not have match with wp_posts - update fro WP ALL Import
	*/
	$upgraded_wpai_del = get_option( 'couponis_upgraded_wpai_del' );
	if( empty( $upgraded_wpai_del ) && function_exists('couponis_create_tables') ){
		global $wpdb;
		$no_match = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}couponis_coupon_data LEFT JOIN {$wpdb->posts} ON ID = post_id WHERE post_type IS NULL" );
		if( $no_match > 0 ){
		    ?>
		    <div class="notice notice-success is-dismissible error wpai-upgrade-dismiss">
		    	<p>If you are not using WP All Import plugin or if you did not cheked option 'Delete posts that are no longer present in your file' in import settings you can dismiss this message</p>
		    	<p>If you have checked previously mentioned option or you are not sure click <a href="javascript:;" class="couponis-start-wpai-upgrade" data-total="<?php echo esc_attr( $no_match ) ?>" data-action="couponis_wpai_del_start">here</a> to remove extra records in couponis table since WP All Import does not trigger required WordPress action. This is needed only this time</p>
		        <div class="upgrade-wpai-results"></div>
		    </div>
		    <?php
		}
		else{
			couponis_wpai_del_completed();
		}
	}	

}
add_action( 'admin_notices', 'couponis_check_api' );
}
/***********************************************
************************************************
************************************************/

function couponis_time_upgrade_start(){
	$offset = $_POST['offset'];
	global $wpdb;
	$result = 0;
	$wpdb->hide_errors();
	$coupons = $wpdb->get_results( $wpdb->prepare( "SELECT coupon_id, expire FROM {$wpdb->prefix}couponis_coupon_data ORDER BY coupon_id ASC LIMIT 200 OFFSET %d", $offset ) );
	$update_ids = array();
	if( !empty( $coupons ) ){
		foreach( $coupons as $coupon ){
			if( $coupon->expire !== '99999999999' ){
				$time = date_i18n( 'H:i:s', $coupon->expire );
				if( $time == '00:00:00' ){
					$update_ids[] = $coupon->coupon_id;
				}
			}
		}
	}
	if( !empty( $update_ids ) ){
		$result = $wpdb->query( "UPDATE {$wpdb->prefix}couponis_coupon_data SET expire = expire + 86399 WHERE coupon_id IN ( ".join(',', $update_ids)." )" );
	}

	echo json_encode(array(
		'error'		=> $result !== false ? false : true,
		'upgraded'	=> $result !== false ? sizeof( $coupons ) : 0,
		'message' 	=> $result !== false ? '<p>Upgraded rows from '.$offset.' to '.( $offset + sizeof( $coupons ) ).' - changed '.sizeof( $update_ids ).'</p>' : '<p>'.$wpdb->last_error.'</p>'
	));

	die();
}
add_action( 'wp_ajax_couponis_time_upgrade_start', 'couponis_time_upgrade_start' );

function couponis_time_upgrade_completed(){
	update_option( 'couponis_updgraded_times', 'yes' );
	update_option( 'users_can_register', 1 );
}
add_action( 'wp_ajax_couponis_time_upgrade_completed', 'couponis_time_upgrade_completed' );

/* IMAGE UPGRADE */
function couponis_image_upgrade_start(){
	global $wpdb;
	$result = 0;
	$wpdb->hide_errors();
	$images = $wpdb->get_col( "SELECT ID FROM {$wpdb->prefix}posts WHERE post_name LIKE 'coupon-image-%' OR post_name LIKE 'store-image-%' LIMIT 200" );
	if( !empty( $images ) ){
		foreach( $images as $image_id ){
			wp_delete_attachment( $image_id, true );
		}
	}

	echo json_encode(array(
		'error'		=> false,
		'upgraded'	=> sizeof( $images ),
		'message' 	=> '<p>Deleted - '.sizeof( $images ).'</p>'
	));

	die();
}
add_action( 'wp_ajax_couponis_image_upgrade_start', 'couponis_image_upgrade_start' );

function couponis_image_upgrade_completed(){
	update_option( 'couponis_updgraded_images', 'yes' );
}
add_action( 'wp_ajax_couponis_image_upgrade_completed', 'couponis_image_upgrade_completed' );

/* WP ALL IMPORT UPGRADE */
function couponis_wpai_del_start(){
	global $wpdb;
	$result = 0;
	$wpdb->hide_errors();
	$records = $wpdb->get_col( "SELECT post_id FROM {$wpdb->prefix}couponis_coupon_data LEFT JOIN {$wpdb->posts} ON ID = post_id WHERE post_type IS NULL LIMIT 200" );
	if( !empty( $records ) ){
		$wpdb->query( "DELETE {$wpdb->prefix}couponis_coupon_data FROM {$wpdb->prefix}couponis_coupon_data LEFT JOIN {$wpdb->posts} ON ID = post_id WHERE post_type IS NULL AND post_id IN (".implode( ',', $records ).")" );
	}
	echo json_encode(array(
		'error'		=> false,
		'upgraded'	=> sizeof( $records ),
		'message' 	=> '<p>Deleted - '.sizeof( $records ).'</p>'
	));

	die();
}
add_action( 'wp_ajax_couponis_wpai_del_start', 'couponis_wpai_del_start' );

function couponis_wpai_del_completed(){
	update_option( 'couponis_upgraded_wpai_del', 'yes' );
}
add_action( 'wp_ajax_couponis_wpai_del_completed', 'couponis_wpai_del_completed' );


/***********************************************
************************************************
************************************************/

/* get url by page template */
if( !function_exists('couponis_get_permalink_by_tpl') ){
function couponis_get_permalink_by_tpl( $template_name ){
	$page = get_pages(array(
		'meta_key' => '_wp_page_template',
		'meta_value' => $template_name . '.php'
	));
	if(!empty($page)){
		return get_permalink( $page[0]->ID );
	}
	else{
		return "javascript:;";
	}
}
}

if( !function_exists('couponis_dismiss_api_notice') ){
function couponis_dismiss_api_notice() {
	update_option( 'couponis_api_notice_disable', '1' );
}
add_action( 'wp_ajax_google_api_dismiss', 'couponis_dismiss_api_notice' );
}


if( !function_exists('couponis_requred_plugins') ){
function couponis_requred_plugins(){
	$plugins = array(
		array(
				'name'                 => esc_html__( 'Redux Framework', 'couponis' ),
				'slug'                 => 'redux-framework',
				'required'             => true,
				'version'              => '',
				'force_activation'     => false,
				'force_deactivation'   => false,
				'external_url'         => '',
		),
		array(
				'name'                 => esc_html__( 'King Composer', 'couponis' ),
				'slug'                 => 'kingcomposer',
				'required'             => true,
				'version'              => '',
				'force_activation'     => false,
				'force_deactivation'   => false,
				'external_url'         => '',
		),
		array(
				'name'                 => esc_html__( 'SMeta', 'couponis' ),
				'slug'                 => 'smeta',
				'source'               => get_template_directory() . '/lib/plugins/smeta.zip',
				'required'             => true,
				'version'              => '',
				'force_activation'     => false,
				'force_deactivation'   => false,
				'external_url'         => '',
		),		
		array(
				'name'                 => esc_html__( 'Couponis Demo', 'couponis' ),
				'slug'                 => 'couponis-demo',
				'source'               => get_template_directory() . '/lib/plugins/couponis-demo.zip',
				'required'             => true,
				'version'              => '',
				'force_activation'     => false,
				'force_deactivation'   => false,
				'external_url'         => '',
		),
		array(
				'name'                 => esc_html__( 'Couponis Import', 'couponis' ),
				'slug'                 => 'couponis-import',
				'source'               => get_template_directory() . '/lib/plugins/couponis-import.zip',
				'required'             => false,
				'version'              => '',
				'force_activation'     => false,
				'force_deactivation'   => false,
				'external_url'         => '',
		),
		array(
				'name'                 => esc_html__( 'Social Connect ST', 'couponis' ),
				'slug'                 => 'social-connect-st',
				'source'               => get_template_directory() . '/lib/plugins/social-connect-st.zip',
				'required'             => true,
				'version'              => '',
				'force_activation'     => false,
				'force_deactivation'   => false,
				'external_url'         => '',
		),
	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
			'domain'           => 'couponis',
			'default_path'     => '',
			'menu'             => 'install-required-plugins',
			'has_notices'      => true,
			'is_automatic'     => false,
			'message'          => ''
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'couponis_requred_plugins' );
}

if (!isset($content_width)){
	$content_width = 1920;
}
	
/* include custom made widgets */
if( !function_exists('couponis_widgets_init') ){
function couponis_widgets_init(){

	register_sidebar(array(
		'name' 			=> esc_html__('Blog Sidebar', 'couponis') ,
		'id' 			=> 'blog',
		'before_widget' => '<div class="widget white-block clearfix %2$s" ><div class="white-block-content">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<div class="widget-title"><h4>',
		'after_title' 	=> '</h4></div>',
		'description' 	=> esc_html__('Appears on the eight side of all pages.', 'couponis')
	));	

	register_sidebar(array(
		'name' 			=> esc_html__('Page Right Sidebar', 'couponis') ,
		'id' 			=> 'right',
		'before_widget' => '<div class="widget white-block clearfix %2$s" ><div class="white-block-content">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<div class="widget-title"><h4>',
		'after_title' 	=> '</h4></div>',
		'description' 	=> esc_html__('Appears on the right side of the page.', 'couponis')
	));	

	register_sidebar(array(
		'name' 			=> esc_html__('Page Left Sidebar', 'couponis') ,
		'id' 			=> 'left',
		'before_widget' => '<div class="widget white-block clearfix %2$s" ><div class="white-block-content">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<div class="widget-title"><h4>',
		'after_title' 	=> '</h4></div>',
		'description' 	=> esc_html__('Appears on the left side of the page.', 'couponis')
	));	

	register_sidebar(array(
		'name' 			=> esc_html__('Search Sidebar', 'couponis') ,
		'id' 			=> 'search',
		'before_widget' => '<div class="widget white-block clearfix %2$s" ><div class="white-block-content">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<div class="widget-title"><h4>',
		'after_title' 	=> '</h4></div>',
		'description' 	=> esc_html__('Appears on the left side of the search page.', 'couponis')
	));	

	register_sidebar(array(
		'name' 			=> esc_html__('Category Sidebar', 'couponis') ,
		'id' 			=> 'category',
		'before_widget' => '<div class="widget white-block clearfix %2$s" ><div class="white-block-content">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<div class="widget-title"><h4>',
		'after_title' 	=> '</h4></div>',
		'description' 	=> esc_html__('Appears on the right side of the category taxonomy page.', 'couponis')
	));	

	register_sidebar(array(
		'name' 			=> esc_html__('Store Sidebar', 'couponis') ,
		'id' 			=> 'store',
		'before_widget' => '<div class="widget white-block clearfix %2$s" ><div class="white-block-content">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<div class="widget-title"><h4>',
		'after_title' 	=> '</h4></div>',
		'description' 	=> esc_html__('Appears on the right side of the store taxonomy page.', 'couponis')
	));	

	register_sidebar(array(
		'name' 			=> esc_html__('Account Sidebar', 'couponis') ,
		'id' 			=> 'account',
		'before_widget' => '<div class="widget white-block clearfix %2$s" ><div class="white-block-content">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<div class="widget-title"><h4>',
		'after_title' 	=> '</h4></div>',
		'description' 	=> esc_html__('Appears on the right side of the account page.', 'couponis')
	));	

	register_sidebar(array(
		'name' 			=> esc_html__('Submit Sidebar', 'couponis') ,
		'id' 			=> 'submit',
		'before_widget' => '<div class="widget white-block clearfix %2$s" ><div class="white-block-content">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<div class="widget-title"><h4>',
		'after_title' 	=> '</h4></div>',
		'description' 	=> esc_html__('Appears on the right side of the submit page.', 'couponis')
	));	

	register_sidebar(array(
		'name' 			=> esc_html__('Single Coupon Sidebar', 'couponis') ,
		'id' 			=> 'coupon',
		'before_widget' => '<div class="widget white-block clearfix %2$s" ><div class="white-block-content">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<div class="widget-title"><h4>',
		'after_title' 	=> '</h4></div>',
		'description' 	=> esc_html__('Appears on the right side of the single coupon page.', 'couponis')
	));	
}

add_action('widgets_init', 'couponis_widgets_init');
}

/* total_defaults */
if( !function_exists('couponis_defaults') ){
function couponis_defaults( $id ){	
	$defaults = array(
		'site_logo' => array( 'url' => '' ),
		'enable_sticky' => 'no',
		'direction' => 'ltr',
		'custom_css' => '',
		'google_ads' => '',
		'google_ads_header' => 'no',
		'coupon_listing_style' => 'list',
		'coupon_listing_image' => 'store',
		'coupons_per_page' => '10',
		'expired_stamp' => array( 'url' => '' ),
		'list_empt_cats_stores' => 'yes',
		'single_coupon_sidebar_pos' => 'right',
		'single_coupon_similar' => 'yes',
		'single_coupon_similar_number' => '5',
		'delete_coupon_images' => 'no',
		'delete_store_images' => 'no',
		'can_submit' => 'yes',
		'trans_coupon' => 'coupon',
		'trans_coupon-category' => 'coupon-category',
		'trans_coupon-store' => 'coupon-store',
		'mail_chimp_api' => '',
		'mail_chimp_list_id' => '',
		'main_color' => '#1ab1b7',
		'main_color_font' => '#fff',
		'sale_badge_bg' => '#48c78c',
		'sale_badge_font' => '#fff',
		'exclusive_badge_bg' => '#1ab1b7',
		'exclusive_badge_font' => '#fff',
		'online_badge_bg' => '#c2c748',
		'use_coupon_single' => 'yes',
		'online_badge_font' => '#fff',
		'in_store_badge_bg' => '#5f93ce',
		'in_store_badge_bg' => '#fff',
		'action_btn_bg' => '#FFA619',
		'action_btn_font' => '#fff',
		'header_bg_color' => '#202020',
		'header_font_color' => '#bbb',
		'header_font_color_active' => '#eee',
		'navigation_font' => 'Montserrat',
		'navigation_font_weight' => '600',
		'navigation_font_size' => '14px',
		'text_font' => 'Open Sans',
		'text_font_weight' => '400',
		'text_font_size' => '14px',
		'text_font_line_height' => '1.7',
		'title_font' => 'Montserrat',
		'title_font_weight' => '600',
		'h1_font_size' => '2.6179em',
		'h1_font_line_height' => '1.4',
		'h2_font_size' => '2.0581em',
		'h2_font_line_height' => '1.4',
		'h3_font_size' => '1.618em',
		'h3_font_line_height' => '1.4',
		'h4_font_size' => '1.272em',
		'h4_font_line_height' => '1.4',
		'h5_font_size' => '1em',
		'h5_font_line_height' => '1.4',
		'h6_font_size' => '0.7862em',
		'h6_font_line_height' => '1.4',
		'title_color' => '#202020',
		'link_color' => '#272727',
		'text_color' => '#484848',		
		'copyrights_bg_color' => '#202020',
		'copyrights_font_color' => '#bbb',
		'copyrights_font_color_active' => '#1ab1b7',
		'contact_form_email' => '',
		'markers' => '',
		'marker_icon' => array( 'url' => '' ),
		'markers_max_zoom' => '',
		'google_api_key' => '',
		'subscribe' => 'no',
		'ft_facebook' => '',
		'ft_twitter' => '',
		'ft_google' => '',
		'ft_youtube' => '',
		'ft_linkedin' => '',
		'ft_tumblr' => '',
		'ft_pinterest' => '',
		'ft_instagram' => '',
		'copyrights' => '',
	);
	
	if( isset( $defaults[$id] ) ){
		return $defaults[$id];
	}
	else{
		
		return '';
	}
}
}

/* get option from theme options */
if( !function_exists('couponis_get_option') ){
function couponis_get_option($id){
	global $couponis_options;
	if( isset( $couponis_options[$id] ) ){
		$value = $couponis_options[$id];
		if( isset( $value ) ){
			return $value;
		}
		else{
			return '';
		}
	}
	else{
		return couponis_defaults( $id );
	}
}
}

/* setup neccessary theme support, add image sizes */
if( !function_exists('couponis_setup') ){
function couponis_setup(){
	add_theme_support('automatic-feed-links');
	add_theme_support( "title-tag" );
	add_theme_support('html5', array(
		'comment-form',
		'comment-list'
	));
	register_nav_menu('main-navigation', esc_html__('Main Navigation', 'couponis'));
	register_nav_menu('footer-navigation', esc_html__('Footer Navigation', 'couponis'));
	
	add_theme_support('post-thumbnails',array( 'post', 'page', 'coupon' ));
	
	set_post_thumbnail_size( 750 );
	add_image_size( 'couponis-featured-slider', 848, 360, true );
	add_image_size( 'couponis-list', 140, 140, true );
	add_image_size( 'couponis-grid', 360, 180, true );
	add_image_size( 'couponis-widget', 60, 60, true );
	add_image_size( 'couponis-logo', 150 );

	add_editor_style();
}
add_action('after_setup_theme', 'couponis_setup');
}

if( !function_exists('couponis_enqueue_font') ){
function couponis_enqueue_font() {
	$load_fonts = array(
		array(
			'font' 	   => couponis_get_option( 'text_font' ),
			'weight'   => couponis_get_option( 'text_font_weight' ).',700',
		),
		array(
			'font' 	   => couponis_get_option( 'title_font' ),
			'weight'   => couponis_get_option( 'title_font_weight' ),
		),
		array(
			'font' 	   => couponis_get_option( 'navigation_font' ),
			'weight'   => couponis_get_option( 'navigation_font_weight' ),
		),		
	);

	$list = array();
	$loaded_fonts = array();
	foreach( $load_fonts as $key => $data ){
		if( !empty( $data['font'] ) && !isset( $loaded_fonts[$data['font']] ) ){
			$loaded_fonts[$data['font']] = $data['weight'];
		}
		else{
			$loaded_fonts[$data['font']] .= ','.$data['weight'];
		}
	}

	foreach( $loaded_fonts as $font => $weight ){
		$list[] = $font.':'.$weight;
	}

	$list = implode( '|', $list ).'&subset=all';

	$font_family = str_replace( '+', ' ', $list );
    $font_url = '';
    if ( 'off' !== _x( 'on', 'Google font: on or off', 'couponis' ) ) {
        $font_url = add_query_arg( 'family', urlencode( $font_family ), "//fonts.googleapis.com/css" );
    }

    wp_enqueue_style( 'couponis-fonts', $font_url, array(), '1.0.0' );
}
}

/* setup neccessary styles and scripts */
if( !function_exists('couponis_scripts_styles') ){
function couponis_scripts_styles(){
	$protocol = is_ssl() ? 'https' : 'http';

	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css' );
	wp_enqueue_style( 'simple-line-icons', get_template_directory_uri() . '/css/simple-line-icons.css' );
	wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/css/magnific-popup.css' );

	wp_enqueue_style( 'select2', get_template_directory_uri() . '/css/select2.min.css' );	
	wp_enqueue_script('select2', get_template_directory_uri() . '/js/select2.min.js', array('jquery'), false, true);
	

	/*load selecte fonts*/
	couponis_enqueue_font();
	
	/* load style.css */
	
	if (is_singular() && comments_open() && get_option('thread_comments')){
		wp_enqueue_script('comment-reply');
	}

	/* bootstrap */
	wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), false, true);

	/* custom */
	wp_enqueue_script('magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array('jquery'), false, true);

	if( ( is_page() && get_page_template_slug() == 'page-tpl_contact.php' ) || is_tax( 'coupon-store' ) ){
		$api = '';
		$google_api_key = couponis_get_option( 'google_api_key' );
		if( !empty( $google_api_key ) ){
			$api = '&key='.$google_api_key;
		}
		wp_enqueue_script( 'couponis-googlemap', $protocol.'://maps.googleapis.com/maps/api/js?sensor=false'.$api, false, false, true );
	}

	if( is_page() && get_page_template_slug() == 'page-tpl_home.php' ){
		wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/css/owl.carousel.css' );
		wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array('jquery'), false, true);
	}

	if( is_page() && get_page_template_slug() == 'page-tpl_submit.php' ){
		if( function_exists('cmb_init') ){
			wp_enqueue_style( 'cmb-jquery-ui', trailingslashit( CMB_URL ) . 'css/vendor/jquery-ui/jquery-ui.css');
			wp_enqueue_style( 'cmb-timepicker-ui', trailingslashit( CMB_URL ) . '/css/jquery-ui-timepicker-addon.css');
			wp_enqueue_style( 'cmb-datetimepicker', get_template_directory_uri() . '/css/datetimepicker.min.css' );
			wp_enqueue_script( 'cmb-timepicker', trailingslashit( CMB_URL ) . 'js/jquery-ui-timepicker-addon.js', array( 'jquery', 'jquery-ui-slider', 'jquery-ui-core', 'jquery-ui-datepicker' ) );
		}
	}

	if( is_singular( 'coupon' ) ){
		wp_enqueue_script( 'countdown',  get_template_directory_uri() . '/js/countdown.js', array('jquery'), false, true );
	}

	if( is_tax('coupon-category') || is_tax('coupon-store') || (is_page() && get_page_template_slug() == 'page-tpl_search.php') ){
		wp_enqueue_script('cookie', get_template_directory_uri() . '/js/js.cookie.js', array( 'jquery' ), false, true);
	}

	wp_enqueue_script('couponis-custom', get_template_directory_uri() . '/js/custom.js', array('jquery'), false, true);
	wp_localize_script( 'couponis-custom', 'couponis_overall_data', couponis_get_js_options());
}
add_action('wp_enqueue_scripts', 'couponis_scripts_styles', 11 );
}

/*
Get options for the marker
*/
if( !function_exists('couponis_get_js_options') ){
function couponis_get_js_options(){
	$marker_icon = couponis_get_option( 'marker_icon' );
	$data =  array(
		'url' 				=> get_template_directory_uri(),
		'markers_max_zoom' 	=> couponis_get_option( 'markers_max_zoom' ),
		'marker_icon' 		=> '',
		'ajaxurl' 			=> admin_url('admin-ajax.php'),
		'enable_sticky' 	=> couponis_get_option( 'enable_sticky' ),
		'locale_done' 		=> esc_html__( 'Done', 'couponis' ),
		'locale_now' 		=> esc_html__( 'Now', 'couponis' ) 
	) ;

	if( !empty( $marker_icon['url'] ) )	{
		$data['marker_icon'] = $marker_icon['url'];
	}

	return $data;
}
}


/* add main css dynamically so it can support changing collors */
if( !function_exists('couponis_add_main_style') ){
function couponis_add_main_style(){
	wp_enqueue_style('couponis-style', get_stylesheet_uri());
	ob_start();
	include( get_template_directory().'/css/main-color.css.php' );
	$custom_css = ob_get_contents();
	ob_end_clean();
	wp_add_inline_style( 'couponis-style', $custom_css );	
}
add_action('wp_enqueue_scripts', 'couponis_add_main_style', 13);
}

if( !function_exists('couponis_admin_scripts_styles') ){
function couponis_admin_scripts_styles( $hook ){
	$screen = get_current_screen();
	$post_type = $screen->id;
	wp_enqueue_script('admin-js', get_template_directory_uri().'/js/admin.js', array('jquery'), false, true);
	if( isset( $_GET['taxonomy'] ) && $_GET['taxonomy'] == 'coupon-store' ){
		wp_enqueue_media();
		wp_enqueue_script('admin-taxonomy', get_template_directory_uri().'/js/admin-taxonomy.js', array('jquery'), false, true);
	}
	wp_enqueue_style('couponis-admin-style', get_template_directory_uri() . '/css/admin.css' );
	wp_enqueue_style('couponis-awesome', get_template_directory_uri() . '/css/font-awesome.min.css' );
}
add_action('admin_enqueue_scripts', 'couponis_admin_scripts_styles');
}

/* add admin-ajax */

if( !class_exists('couponis_walker') ){
class couponis_walker extends Walker_Nav_Menu {
  
	/**
	* @see Walker::start_lvl()
	* @since 3.0.0
	*
	* @param string $output Passed by reference. Used to append additional content.
	* @param int $depth Depth of page. Used for padding.
	*/
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul role=\"menu\" class=\" dropdown-menu\">\n";
	}

	/**
	* @see Walker::start_el()
	* @since 3.0.0
	*
	* @param string $output Passed by reference. Used to append additional content.
	* @param object $item Menu item data object.
	* @param int $depth Depth of menu item. Used for padding.
	* @param int $current_page Menu item ID.
	* @param object $args
	*/
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		/**
		* Dividers, Headers or Disabled
		* =============================
		* Determine whether the item is a Divider, Header, Disabled or regular
		* menu item. To prevent errors we use the strcasecmp() function to so a
		* comparison that is not case sensitive. The strcasecmp() function returns
		* a 0 if the strings are equal.
		*/
		if ( strcasecmp( $item->attr_title, 'divider' ) == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="divider">';
		} 
		else if ( strcasecmp( $item->title, 'divider') == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="divider">';
		} 
		else if ( strcasecmp( $item->attr_title, 'dropdown-header') == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="dropdown-header">' . esc_attr( $item->title );
		} 
		else if ( strcasecmp($item->attr_title, 'disabled' ) == 0 ) {
			$output .= $indent . '<li role="presentation" class="disabled"><a href="#">' . esc_attr( $item->title ) . '</a>';
		} 
		else {
			$class_names = $value = '';
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
			
			if ( $args->has_children ){
				$class_names .= ' dropdown';
			}
			
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $value . $class_names .'>';

			$atts = array();
			$atts['title'] = ! empty( $item->title )	? $item->title	: '';
			$atts['target'] = ! empty( $item->target )	? $item->target	: '';
			$atts['rel'] = ! empty( $item->xfn )	? $item->xfn	: '';

			// If item has_children add atts to a.
			$atts['href'] = ! empty( $item->url ) ? $item->url : '';
			if ( $args->has_children ) {
				$atts['data-toggle']	= 'dropdown';
				$atts['class']	= 'dropdown-toggle';
				$atts['data-hover']	= 'dropdown';
				$atts['aria-haspopup']	= 'true';
			} 

			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$item_output = $args->before;

			/*
			* Glyphicons
			* ===========
			* Since the the menu item is NOT a Divider or Header we check the see
			* if there is a value in the attr_title property. If the attr_title
			* property is NOT null we apply it as the class name for the glyphicon.
			*/
			
			$item_output .= '<a'. $attributes .'>';

			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			if( $args->has_children ){
				$item_output .= ' <i class="fa fa-angle-down"></i>';
			}
			$item_output .= '</a>';
			$item_output .= $args->after;
			
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}

	/**
	* Traverse elements to create list from elements.
	*
	* Display one element if the element doesn't have any children otherwise,
	* display the element and its children. Will only traverse up to the max
	* depth and no ignore elements under that depth.
	*
	* This method shouldn't be called directly, use the walk() method instead.
	*
	* @see Walker::start_el()
	* @since 2.5.0
	*
	* @param object $element Data object
	* @param array $children_elements List of elements to continue traversing.
	* @param int $max_depth Max depth to traverse.
	* @param int $depth Depth of current element.
	* @param array $args
	* @param string $output Passed by reference. Used to append additional content.
	* @return null Null on failure with no changes to parameters.
	*/
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
		if ( ! $element )
			return;

		$id_field = $this->db_fields['id'];

		// Display this element.
		if ( is_object( $args[0] ) ){
		   $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
		}

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	/**
	* Menu Fallback
	* =============
	* If this function is assigned to the wp_nav_menu's fallback_cb variable
	* and a manu has not been assigned to the theme location in the WordPress
	* menu manager the function with display nothing to a non-logged in user,
	* and will add a link to the WordPress menu manager if logged in as an admin.
	*
	* @param array $args passed from the wp_nav_menu function.
	*
	*/
	public static function fallback( $args ) {
		if ( current_user_can( 'manage_options' ) ) {

			extract( $args );

			$fb_output = null;

			if ( $container ) {
				$fb_output = '<' . $container;

				if ( $container_id ){
					$fb_output .= ' id="' . $container_id . '"';
				}

				if ( $container_class ){
					$fb_output .= ' class="' . $container_class . '"';
				}

				$fb_output .= '>';
			}

			$fb_output .= '<ul';

			if ( $menu_id ){
				$fb_output .= ' id="' . $menu_id . '"';
			}

			if ( $menu_class ){
				$fb_output .= ' class="' . $menu_class . '"';
			}

			$fb_output .= '>';
			$fb_output .= '<li><a href="' . admin_url( 'nav-menus.php' ) . '">Add a menu</a></li>';
			$fb_output .= '</ul>';

			if ( $container ){
				$fb_output .= '</' . $container . '>';
			}

			echo  $fb_output;
		}
	}
}
}

/*generate random password*/
if( !function_exists('couponis_random_string') ){
function couponis_random_string( $length = 10 ) {
	$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$random = '';
	for ($i = 0; $i < $length; $i++) {
		$random .= $characters[rand(0, strlen($characters) - 1)];
	}
	return $random;
}
}


/* create tags list */
if( !function_exists('couponis_the_tags') ){
function couponis_the_tags(){
	$tags = get_the_tags();
	$list = array();
	if( !empty( $tags ) ){
		foreach( $tags as $tag ){
			$list[] = '<a href="'.esc_url( get_tag_link( $tag->term_id ) ).'">'.$tag->name.'</a>';
		}
	}
	
	return join( ", ", $list );
}
}

if( !function_exists('couponis_cloud_sizes') ){
function couponis_cloud_sizes($args) {
	$args['smallest'] = 10;
	$args['largest'] = 10;
	$args['unit'] = 'px';
	$tags_number = couponis_get_option( 'tags_number' );
	if( !empty( $tags_number ) ){
		$args['number'] = $tags_number;
	}
	return $args; 
}
add_filter('widget_tag_cloud_args','couponis_cloud_sizes');
}

if( !function_exists('couponis_custom_excerpt_more') ){
function couponis_custom_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'couponis_custom_excerpt_more' );
}

if( !function_exists('couponis_the_category') ){
function couponis_the_category( $number = -1 ){
	$list = '';
	$categories = get_the_category();
	if( !empty( $categories ) ){
		$number = $number == -1 ? sizeof( $categories ) : $number;
		for( $i=0; $i<$number; $i++ ){
			$category = $categories[$i];
			$list .= '<a href="'.esc_url( get_category_link( $category->term_id ) ).'">'.$category->name.'</a> ';
		}
	}
	
	return $list;
}
}

/* =======================================================SUBSCRIPTION FUNCTIONS */
if( !function_exists('couponis_send_subscription') ){
function couponis_send_subscription( $email = '' ){
	$email = !empty( $email ) ? $email : $_POST["email"];
	$response = array();	
	if( filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
		if( class_exists('MailChimp') ){
			$chimp_api = couponis_get_option("mail_chimp_api");
			$chimp_list_id = couponis_get_option("mail_chimp_list_id");
			if( !empty( $chimp_api ) && !empty( $chimp_list_id ) ){
				$mc = new MailChimp( $chimp_api );
				$result = $mc->call('lists/subscribe', array(
					'id'                => $chimp_list_id,
					'email'             => array( 'email' => $email )
				));
				
				if( $result === false) {
					$response['message'] = '<div class="alert alert-danger">'.esc_html__( 'There was an error contacting the API, please try again.', 'couponis' ).'</div>';
				}
				else if( isset($result['status']) && $result['status'] == 'error' ){
					$response['message'] = '<div class="alert alert-danger">'.json_encode($result).'</div>';
				}
				else{
					$response['message'] = '<div class="alert alert-success">'.esc_html__( 'You have successfully subscribed.', 'couponis' ).'</div>';
				}
				
			}
			else{
				$response['message'] = '<div class="alert alert-danger">'.esc_html__( 'API data are not yet set.', 'couponis' ).'</div>';
			}
		}
		else{
			$response['message'] = esc_html__( 'Couponis CPT is not set.', 'couponis' );
		}
	}
	else{
		$response['message'] = '<div class="alert alert-danger">'.esc_html__( 'Email is empty or invalid.', 'couponis').'</div>';
	}
	
	echo json_encode( $response );
	die();
}
add_action('wp_ajax_subscribe', 'couponis_send_subscription');
add_action('wp_ajax_nopriv_subscribe', 'couponis_send_subscription');
}

/*======================CONTACT FUNCTIONS==============*/
if( !function_exists('couponis_send_contact') ){
function couponis_send_contact(){
	$name = esc_sql( $_POST['name'] );	
	$email = esc_sql( $_POST['email'] );
	$subject = esc_sql( $_POST['subject'] );
	$message = esc_sql( $_POST['message'] );
	$agree = esc_sql( $_POST['agree'] );

	$agreement_text = couponis_get_option( 'agreement_text' );

	if( empty( $_POST['captcha'] ) || empty( $name ) || empty( $subject ) || empty( $email ) || empty( $message ) || ( !empty( $agreement_text ) && empty( $agree ) ) ){
		$response['message'] = '<div class="alert alert-danger">'.esc_html__( 'All fields are required.', 'couponis' ).'</div>';
	}
	else if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
		$response['message'] = '<div class="alert alert-danger">'.esc_html__( 'E-mail address is not valid.', 'couponis' ).'</div>';
	}
	else{
		$email_to = couponis_get_option( 'contact_form_email' );
		$message = "
			".esc_html__( 'Name: ', 'couponis' )." {$name} \n			
			".esc_html__( 'Email: ', 'couponis' )." {$email} \n
			".esc_html__( 'Message: ', 'couponis' )."\n {$message} \n
		";
		$headers[] = 'From: '.$name.' <'.$email.'>';
		$headers[] = 'Reply-To: '.$email;
		
		$info = @wp_mail( $email_to, $subject, $message, $headers );
		if( $info ){
			$response['message'] = '<div class="alert alert-success">'.esc_html__( 'Your message was successfully submitted.', 'couponis' ).'</div>';
		}
		else{
			$response['message'] = '<div class="alert alert-danger">'.esc_html__( 'Unexpected error while attempting to send e-mail.', 'couponis' ).'</div>';
		}
		
	}
	
	echo json_encode( $response );
	die();	
}
add_action('wp_ajax_contact', 'couponis_send_contact');
add_action('wp_ajax_nopriv_contact', 'couponis_send_contact');
}

if( !function_exists('couponis_hex2rgb') ){
function couponis_hex2rgb( $hex ){
	$hex = str_replace("#", "", $hex);

	$r = hexdec(substr($hex,0,2));
	$g = hexdec(substr($hex,2,2));
	$b = hexdec(substr($hex,4,2));
	return $r.", ".$g.", ".$b; 
}
}

if( !function_exists('couponis_comments') ){
function couponis_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	$add_below = ''; 
	$author_url = get_comment_author_url();
	?>
	<!-- comment -->
	<div class="comment-row <?php echo  $comment->comment_parent != '0' ? esc_attr('comment-margin-left') : ''; ?> clearfix" id="comment-<?php echo esc_attr( get_comment_ID() ); ?>">
		<div class="comment-header">
			<?php echo get_avatar( $comment, 60 ); ?>
			<div class="comment-info">
				<?php if( !empty( $author_url ) ): ?>
					<a href="<?php echo esc_url( $author_url ) ?>" rel="nofollow" target="_blank">
				<?php endif; ?>
				<h5><?php comment_author(); ?></h5>
				<?php if( !empty( $author_url ) ): ?>
					</a>
				<?php endif; ?>
				<p class="comment-details"><i class="icon-clock"></i> <?php comment_time( 'F j, Y '.esc_html__('@','couponis').' H:i' ); ?> </p>
			</div>
		</div>
		<div class="comment-reply">
			<?php 
			comment_reply_link( 
				array_merge( 
					$args, 
					array( 
						'reply_text' => '<i class="fa fa-share"></i> <small>'.esc_html__( 'Reply', 'couponis' ).'</small>', 
						'add_below' => $add_below, 
						'depth' => $depth, 
						'max_depth' => $args['max_depth'] 
					) 
				) 
			); ?>
		</div>
		<div class="comment-content-wrap">
			<?php 
			if ($comment->comment_approved != '0'){
				comment_text();
			}
			else{
				echo '<p>'.esc_html__('Your comment is awaiting moderation.', 'couponis').'</p>';
			}
			?>		
		</div>
	</div>
	<?php  
}
}

if( !function_exists('couponis_end_comments') ){
function couponis_end_comments(){
	return "";
}
}

if( !function_exists('couponis_embed_html') ){
function couponis_embed_html( $html ) {
    return '<div class="video-container">' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'couponis_embed_html', 10, 3 );
add_filter( 'video_embed_html', 'couponis_embed_html' ); // Jetpack
}

if( !function_exists('couponis_password_form') ){
function couponis_password_form() {
	global $post;
	$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
	$form = '<form class="protected-post-form" action="' . site_url() . '/wp-login.php?action=postpass" method="post">
				' . esc_html__( "This post is password protected. To view it please enter your password below:", "couponis" ) . '
				<label for="' . $label . '">' . esc_html__( "Password:", "couponis" ) . ' </label><div class="couponis-form"><input name="post_password" class="form-control" id="' . $label . '" type="password" /><a class="btn submit_form"><i class="fa fa-sign-in"></i></a></div>
			</form>
	';
	return $form;
}
add_filter( 'the_password_form', 'couponis_password_form' );
}


if( !function_exists('couponis_custom_meta') ){
function couponis_custom_meta(){
	$meta_boxes = array();

	$coupon_meta = array(
		array(
			'id' 				=> 'expire',
			'name' 				=> esc_html__( 'Expire Time', 'couponis' ),
			'desc'				=> esc_html__( 'Settings to time 00:00:00 means that coupon will expire at the start of the selected day while selection 23:59:59 means that it will be available until end of the day.', 'couponis' ),
			'type' 				=> 'datetime_unix',
			'values_callback' 	=> 'couponis_get_coupon_meta',
			'save_callback' 	=> 'couponis_save_coupon_meta',
		),
		array(
			'id' 				=> 'ctype',
			'name' 				=> esc_html__( 'Coupon Type', 'couponis' ),
			'type' 				=> 'select',
			'options'			=> array(
				'1' => esc_html__( 'Online Code', 'couponis' ),
				'2' => esc_html__( 'In Store Code', 'couponis' ),
				'3' => esc_html__( 'Online Sale', 'couponis' ),
			),
			'values_callback' 	=> 'couponis_get_coupon_meta',
			'save_callback' 	=> 'couponis_save_coupon_meta'
		),
		array(
			'id' 				=> 'exclusive',
			'name' 				=> esc_html__( 'Is Exclusive', 'couponis' ),
			'type' 				=> 'checkbox',
			'values_callback' 	=> 'couponis_get_coupon_meta',
			'save_callback' 	=> 'couponis_save_coupon_meta',
		),
		array(
			'id' 				=> 'used',
			'name' 				=> esc_html__( 'Used', 'couponis' ),
			'type' 				=> 'number',
			'values_callback' 	=> 'couponis_get_coupon_meta',
			'save_callback' 	=> 'couponis_save_coupon_meta',
		),
		array(
			'id' 				=> 'coupon_affiliate',
			'name' 				=> esc_html__( 'Affiliate Link', 'couponis' ),
			'type' 				=> 'text',
		),
		array(
			'id' 				=> 'coupon_code',
			'name' 				=> esc_html__( 'Code', 'couponis' ),
			'type' 				=> 'text',
		),
		array(
			'id' 				=> 'coupon_url',
			'name' 				=> esc_html__( 'Coupon Link', 'couponis' ),
			'type' 				=> 'text',
		),
		array(
			'id' 				=> 'coupon_printable',
			'name' 				=> esc_html__( 'Printable', 'couponis' ),
			'type' 				=> 'image',
		),
	);

	$meta_boxes[] = array(
		'title' 	=> esc_html__( 'Coupon Details', 'couponis' ),
		'pages' 	=> 'coupon',
		'fields' 	=> $coupon_meta,
	);

	return $meta_boxes;
}
add_filter('cmb_meta_boxes', 'couponis_custom_meta');
}

if( !function_exists('couponis_get_coupon_meta') ){
function couponis_get_coupon_meta( $post_id, $field_id, $single = false ){
	global $wpdb;
	$value = array();
	$metas = $wpdb->get_results( $wpdb->prepare( "SELECT ".esc_sql( $field_id )." FROM {$wpdb->prefix}couponis_coupon_data WHERE post_id = %d LIMIT 1", $post_id ) );
	if( !empty( $metas[0] ) || ( isset( $metas[0] ) && $metas[0] == 0 ) ){
		if( $field_id == 'expire' && $metas[0]->$field_id == 99999999999 ){
			$value = array();
		}
		else{
			$value = array( $metas[0]->$field_id );
		}

		if( $single ){
			$value = array_shift( $value );
		}
	}

	return $value;
}
}

if( !function_exists('couponis_save_coupon_meta') ){
function couponis_save_coupon_meta( $meta_value, $meta_key, $post_id ){
	global $wpdb;
	if( is_array( $meta_value ) ){
		$meta_value = array_shift( $meta_value );
	}

	$result = $wpdb->query( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}couponis_coupon_data WHERE post_id = %d", $post_id ) );
	if( $result > 0 ){

		$meta_value = ( $meta_key == 'expire' && empty( $meta_value ) ) ? 99999999999 : $meta_value;
		$meta_value = ( $meta_key == 'used' && empty( $meta_value ) ) ? 0 : $meta_value;

		$wpdb->update(
			$wpdb->prefix.'couponis_coupon_data',
			array(
				$meta_key => $meta_value
			),		
			array( 
				'post_id' => $post_id
			),
			array(
				'%s',
			),
			array(
				'%d',
			)
		);
	}
	else{
		$meta_value = ( $meta_key == 'expire' && empty( $meta_value ) ) ? 99999999999 : $meta_value;
		$defaults = array(
			'coupon_id'		=> '',
			'post_id' 		=> $post_id,
			'expire' 		=> 99999999999,
			'ctype' 		=> '',
			'exclusive' 	=> 0,
			'used' 			=> 0,
			'positive'		=> 0,
			'negative'		=> 0,
			'success'		=> 0
		);

		$vals = array_merge( $defaults, array( $meta_key => $meta_value ) );

		$wpdb->insert(
			$wpdb->prefix.'couponis_coupon_data',
			$vals,
			array(
				'%d',
				'%d',
				'%d',
				'%d',
				'%d',
				'%d',
			)
		);
	}
}
}


/*
Remove data from extra table
*/
if( !function_exists('couponis_delete_extra_data') ){
function couponis_delete_extra_data( $post_id ){
	global $wpdb;
	$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}couponis_coupon_data WHERE post_id = %d", $post_id ) );

	$delete_coupon_images = couponis_get_option( 'delete_coupon_images' );

	if( $delete_coupon_images == 'yes' ){
		$coupon_printable = get_post_meta( $post_id, 'coupon_printable', true );
		if( !empty( $coupon_printable ) ){
			wp_delete_attachment( $coupon_printable, true );
		}
	    if( has_post_thumbnail( $post_id ) ){
			$attachment_id = get_post_thumbnail_id( $post_id );
			wp_delete_attachment( $attachment_id, true );
	    }
	}
}
}

/*
Remove row in extra table
*/
if( !function_exists('couponis_before_delete_post') ){
function couponis_before_delete_post( $post_id ){
	global $post_type;   
	if ( $post_type != 'coupon' ){
		return;	
	}
	else{
		couponis_delete_extra_data( $post_id );
	}	
}
}
add_action( 'before_delete_post', 'couponis_before_delete_post' );

if( !function_exists('couponis_cat_count_span') ){
function couponis_cat_count_span($links) {
  $links = str_replace('</a> (', '</a> <span>', $links);
  $links = str_replace(')', '</span>', $links);
  return $links;
}
add_filter('wp_list_categories', 'couponis_cat_count_span');
}

if( !function_exists('couponis_archive_count_inline') ){
function couponis_archive_count_inline($links) {
	$links = str_replace('&nbsp;(', ' <span>', $links);
	$links = str_replace(')', '</span>', $links);
	return $links;
}
add_filter('get_archives_link', 'couponis_archive_count_inline');
}

/*
Get first category
*/
if( !function_exists('couponis_get_category') ){
function couponis_get_category(){
	$categories = get_the_category();
	$category = array_shift( $categories );
	if( !empty( $category ) ){
		echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
	}
}
}

/*
Create export button
*/
if( !function_exists( 'couponis_create_menu_items' ) ){
function couponis_create_menu_items(){
	add_theme_page( esc_html__( 'Export / Import Custom Data', 'couponis' ), esc_html__( 'Export / Import Custom Data', 'couponis' ), 'switch_themes', 'couponis_export_import', 'couponis_cd_import_export' );
}
add_action('admin_menu', 'couponis_create_menu_items');
}

/*
Include export import file
*/
if( !function_exists( 'couponis_cd_import_export' ) ){
function couponis_cd_import_export(){
	include( get_theme_file_path( 'includes/cd-exp-imp.php' ) );
}
}

/*
Export custom data values
*/
if( !function_exists( 'couponis_export_cd_values' ) ){
function couponis_export_cd_values(){
	global $wpdb;
	$data = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}couponis_coupon_data", ARRAY_A );
	echo '<textarea class="cd-import">'.json_encode( $data ).'</textarea>';
}
}

/*
Import cutsom data values
*/
if( !function_exists( 'couponis_import_cd_values' ) ){
function couponis_import_cd_values(){
	global $wpdb;
	if( !empty( $_POST['couponis_custom_data'] ) ){
		$couponis_custom_data = json_decode( stripslashes( $_POST['couponis_custom_data'] ), true );
		if( json_last_error() > 0 ){
			$couponis_custom_data = json_decode( $_POST['couponis_custom_data'], true );
		}
		if( !empty( $couponis_custom_data ) ){
			foreach( $couponis_custom_data as $row ){
				$info = $wpdb->insert(
					$wpdb->prefix.'couponis_coupon_data',
					$row,
					array(
						'%d',
						'%d',
						'%s',
						'%s',
						'%s',
						'%d',
						'%d',
						'%d',
						'%d'
					)
				);
			}
			?>
			<div class="updated notice notice-success is-dismissible">
				<p><?php esc_html_e( 'Import process finished', 'couponis' ) ?></p>
				<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice.', 'couponis' ) ?></span></button>
			</div>
			<?php
		}
	}
}
}

/*
Save store link
*/
if( !function_exists('couponis_save_store_link') ){
function couponis_save_store_link( $store_id ){
	if( get_option( 'users_can_register' ) ){
		if( !is_user_logged_in() ){
			$link_part = 'href="#" class="save-store" data-toggle="modal" data-target="#login"';
		}
		else{
			$user_id = get_current_user_id();
			$saved_stores = get_user_meta( $user_id, 'saved_stores', true );
			$saved_stores = !empty( $saved_stores ) ? explode( ',', $saved_stores ) : array();

			$link_part = 'href="javascript:;" class="save-store save-store-action '.( in_array( $store_id, $saved_stores ) ? 'added' : '' ).'"';
		}
		return '<a '.$link_part.' data-store_id="'.esc_attr( $store_id ).'" title="'.esc_attr__( 'Add To Favorite', 'couponis' ).'">
					<span class="icon-heart"></span>
				</a>';
	}
}
}

/*
Save store
*/
if( !function_exists('couponis_save_store') ){
function couponis_save_store(){
	if( is_user_logged_in() ){
		$store_id = esc_sql( $_POST['store_id'] );
		$user_id = get_current_user_id();
		$saved_stores = get_user_meta( $user_id, 'saved_stores', true );
		$saved_stores = !empty( $saved_stores ) ? explode( ',', $saved_stores ) : array();

		if( in_array( $store_id, $saved_stores ) ){
			$saved_stores = array_diff( $saved_stores, array( $store_id ) );
		}
		else{
			$saved_stores[] = $store_id;
		}

		update_user_meta( $user_id, 'saved_stores', implode( ',', $saved_stores ) );
	}	
}
add_action('wp_ajax_save_store', 'couponis_save_store');
add_action('wp_ajax_nopriv_save_store', 'couponis_save_store');
}

/*
Get coupon store image
*/
if( !function_exists('couponis_get_coupon_store_logo') ){
function couponis_get_coupon_store_logo( $store_id, $image_size = 'couponis-logo' ){
	$store_logo = get_term_meta( $store_id, 'store_image', true );
	return  wp_get_attachment_image( $store_logo, $image_size );
}
}

/*
Show featured image and if there is no any show store logo
*/
if( !function_exists('couponis_get_coupon_image') ){
function couponis_get_coupon_image( $image_size ){
	$coupon_listing_image = couponis_get_option( 'coupon_listing_image' );
	$show_featured = true;
	if( $coupon_listing_image !== 'featured' || (  $coupon_listing_image == 'featured' && !has_post_thumbnail() ) ) {
		$show_featured = false;
		$store_image = couponis_get_coupon_hrefed_store_logo( $image_size == 'couponis-list' ? 'couponis-logo' : $image_size );
		if( !empty( $store_image ) ){
			echo $store_image;
		}
		else{
			$show_featured = true;
		}
	}

	if( $show_featured ){
		echo '<a href="'.esc_url( get_the_permalink() ).'" class="coupon-image">'.get_the_post_thumbnail( get_the_ID(), $image_size ).'</a>';
	}
}
}

/*
Get store logo of the visited coupon
*/
if( !function_exists('couponis_get_coupon_hrefed_store_logo') ){
function couponis_get_coupon_hrefed_store_logo( $image_size = 'couponis-logo' ){
	$store = get_the_terms( get_the_ID(), 'coupon-store' );
	if( $store ){
		if( is_array( $store ) ){
			$store = array_shift( $store );
		}
		$link = get_term_link( $store );
		$image = couponis_get_coupon_store_logo( $store->term_id, $image_size );
	}

	if( !empty( $image ) ){
		return '<a href="'.esc_url( $link ).'" class="coupon-image">'.$image.'</a>';
	}

	return '';
}
}

/*
Get type badge
*/
if( !function_exists('couponis_get_type_badge') ){
function couponis_get_type_badge( $type ){
	$badge = '';
	switch( $type ){
		case '1' : $badge = '<span class="badges online-code">'.esc_html__( 'online code', 'couponis' ).'</span>'; break;
		case '2' : $badge = '<span class="badges in-store-code">'.esc_html__( 'in store code', 'couponis' ).'</span>'; break;
		case '3' : $badge = '<span class="badges online-sale">'.esc_html__( 'online sale', 'couponis' ).'</span>'; break;
	}

	return $badge;
}
}

/*
Get exclusive badge
*/
if( !function_exists('couponis_get_exclusive_badge') ){
function couponis_get_exclusive_badge(){
	return '<span class="badges exclusive">'.esc_html__( 'exclusive', 'couponis' ).'</span>';
}
}

/*
Get expire
*/
if( !function_exists('couponis_get_expire_badge') ){
function couponis_get_expire_badge( $expire ){
	if( $expire != '99999999999' ){
		$format = get_option( 'date_format' );
		$time_on_badge = couponis_get_option( 'time_on_badge' );
		if( $time_on_badge == 'yes' ){
			$format .= ' '.get_option( 'time_format' );
		}
		return '<span class="expire"><span class="icon-clock"></span> '.date_i18n( $format, $expire ).'</span>';
	}
}
}

/*
Get coupon action button
*/
if( !function_exists('couponis_coupon_action_button') ){
function couponis_coupon_action_button( $type ){

	$link = '<a '.couponis_get_coupon_action_link_atts().'>';

	if( $type == 1 ){
		$coupon_code = get_post_meta( get_the_ID(), 'coupon_code', true );
		$link .= '<span class="code-text">'.esc_html__( 'GET CODE', 'couponis' ).'</span><span class="partial-code">&nbsp;'.substr( $coupon_code, -4, 4 ).'</span>';
	}
	else if( $type == 2 ){
		$link .= '<span class="code-text-full">'.esc_html__( 'PRINT CODE', 'couponis' ).'</span>';
	}
	else if( $type == 3 ){
		$link .= '<span class="code-text-full">'.esc_html__( 'GET DEAL', 'couponis' ).'</span>';
	}

	$link .= '</a>';

	return $link;
}
}

/*
Get link for the coupon
*/
if( !function_exists('couponis_get_coupon_action_link') ){
function couponis_get_coupon_action_link_atts(){
	$href = '#o-'.get_the_ID();
	$data_href = '';
	$coupon_affiliate = get_post_meta( get_the_ID(), 'coupon_affiliate', true );
	if( !empty( $coupon_affiliate ) ){
		$href = add_query_arg( array() ).$href;
		$data_href = add_query_arg( array( 'cout' => get_the_ID() ), home_url('/') );
	}

	return 'class="coupon-action-button header-alike" href="'.esc_attr( $href ).'" '.( !empty( $data_href ) ? 'data-affiliate="'.esc_url( $data_href ).'" target="_blank"' : '' ).' rel="nofollow"';
}
}

/*
Get coupon link
*/
if( !function_exists('couponis_get_coupon_link') ){
function couponis_get_coupon_link(){
	$use_coupon_single = couponis_get_option( 'use_coupon_single' );
	if( $use_coupon_single == 'yes' ){
		return 'href="'.get_the_permalink().'"';
	}
	else{
		$atts = couponis_get_coupon_action_link_atts();
		$atts = str_replace( 'header-alike', '', $atts );
		return $atts;
	}
}
}

/*
Save coupon link
*/
if( !function_exists('couponis_save_coupon_link') ){
function couponis_save_coupon_link( $post_id ){
	if( get_option( 'users_can_register' ) ){
		if( !is_user_logged_in() ){
			$link_part = 'href="#" class="save-coupon" data-toggle="modal" data-target="#login"';
		}
		else{
			$user_id = get_current_user_id();
			$saved_coupons = get_user_meta( $user_id, 'saved_coupons', true );
			$saved_coupons = !empty( $saved_coupons ) ? explode( ',', $saved_coupons ) : array();

			$link_part = 'href="javascript:;" class="save-coupon save-coupon-action '.( in_array( $post_id, $saved_coupons ) ? 'added' : '' ).'"';
		}
		return '<li><a '.$link_part.' data-post_id="'.esc_attr( $post_id ).'" title="'.esc_attr__( 'Save Coupon', 'couponis' ).'">
					<span class="icon-star"></span>
				</a></li>';
	}
}
}

/*
Save coupon
*/
if( !function_exists('couponis_save_coupon') ){
function couponis_save_coupon(){
	if( is_user_logged_in() ){
		$post_id = esc_sql( $_POST['post_id'] );
		$user_id = get_current_user_id();
		$saved_coupons = get_user_meta( $user_id, 'saved_coupons', true );
		$saved_coupons = !empty( $saved_coupons ) ? explode( ',', $saved_coupons ) : array();

		if( in_array( $post_id, $saved_coupons ) ){
			$saved_coupons = array_diff( $saved_coupons, array( $post_id ) );
		}
		else{
			$saved_coupons[] = $post_id;
		}

		update_user_meta( $user_id, 'saved_coupons', implode( ',', $saved_coupons ) );
	}	
}
add_action('wp_ajax_save_coupon', 'couponis_save_coupon');
add_action('wp_ajax_nopriv_save_coupon', 'couponis_save_coupon');
}

/*
Get only parent coupon categories
*/
if( !function_exists('couponis_get_coupon_parents') ){
function couponis_get_coupon_parents(){
	$parents = array();
	$categories = get_the_terms( get_the_ID(), 'coupon-category' );
	if( !empty($categories) ){
		foreach( $categories as $category ){
			if( $category->parent == 0 ){
				$parents[] = $category;
			}
		}
	}

	return $parents;
}
}

/*
Print coupoon categories in comma separated list
*/
if( !function_exists('couponis_print_coupon_parents') ){
function couponis_print_coupon_parents( $categories ){
	$cats = array();
	foreach( $categories as $category ){
		$cats[] = '<a href="'.get_term_link( $category, 'coupon-category' ).'">'.$category->name.'</a>';
	}

	return implode( ', ', $cats );
}
}

/*
Print coupon type badge
*/
if( !function_exists('couponis_coupon_type_badge') ){
function couponis_coupon_type_badge( $type ){
	switch( $type ){
		case '1' : $badge = '<span class="badges online-code">'.esc_html__( 'online code', 'couponis' ).'</span>'; break;
		case '2' : $badge = '<span class="badges in-store-code">'.esc_html__( 'in store code', 'couponis' ).'</span>'; break;
		case '3' : $badge = '<span class="badges online-sale">'.esc_html__( 'online sale', 'couponis' ).'</span>'; break;
		default: $badge = '';
	}

	return $badge;
}
}

/*
Increment usage number
*/
if( !function_exists('couponis_register_coupon_used')){
function couponis_register_coupon_used( $coupon_id, $used ){
	$used = couponis_get_coupon_meta( $coupon_id, 'used', true );
	if( empty( $used ) ){
		$used = 0;
	}

	$used++;

	couponis_save_coupon_meta( $used, 'used', $coupon_id );

	return $used;
}
}

/*
Generate coupon modal content
*/
if( !function_exists( 'couponis_show_code' ) ){
function couponis_show_code(){
	$coupon_id = esc_sql( $_POST['coupon_id'] );

	$coupon = get_post( $coupon_id );
	$coupon_modal = '';
	if( !empty( $coupon ) ){

		$used = couponis_get_coupon_meta( $coupon->ID, 'used', true );
		$used = couponis_register_coupon_used( $coupon_id, $used );

		$store = get_the_terms( $coupon, 'coupon-store' );
		$store = array_shift( $store );
		$store_url = get_term_meta( $store->term_id, 'store_url', true );

		$type = couponis_get_coupon_meta( $coupon_id, 'ctype', true );

		?>
		<div class="modal-header">
			<h4 class="text-center"><?php echo  $coupon->post_title; ?></h4>
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</i></button>
		</div>

		<div class="modal-body">

			<div class="text-center">
		        <?php if( !empty( $store_url ) ): ?>
		            <a class="store-image" href="<?php echo esc_url( add_query_arg( array( 'sout' => $store->term_id ), home_url('/') ) ) ?>" rel="nofollow" target="_blank">
		        <?php endif; ?>
					<?php echo couponis_get_coupon_store_logo( $store->term_id ); ?>
		        <?php if( !empty( $store_url ) ): ?>
		            </a>
		        <?php endif; ?>
	        </div>

			<?php
			if( $type == '1' ){
				$coupon_code = get_post_meta( $coupon_id, 'coupon_code', true );
				$external = get_post_meta( $coupon_id, 'coupon_affiliate', true );

				if( !empty( $external ) ){
					$after_text = esc_html__( 'Code is coped, use it ', 'couponis' ).'<a href="'.esc_url( add_query_arg( array( 'cout' => $coupon_id ), home_url('/') ) ).'" target="_blank">'.esc_html__( 'here', 'couponis' ).'</a>';
					$manual_text = esc_html__( 'Copy or write down code and use it ', 'couponis' ).'<a href="'.esc_url( add_query_arg( array( 'cout' => $coupon_id ), home_url('/') ) ).'">'.esc_html__( 'here', 'couponis' ).'</a>';
				}
				else{
					$after_text = esc_html__( 'Code is copied', 'couponis' );
					$manual_text = esc_html__( 'Copy or write down code above', 'couponis' );
				}
				echo '<input type="text" class="coupon-code-modal header-alike" readonly="readonly" value="'.esc_attr( $coupon_code ).'" />';
				echo '<p class="coupon-code-copied">'.esc_html__( 'Click the code to auto copy', 'couponis' ).'</p>';
				echo '<p class="coupon-code-copied after-copy">'.$after_text.'</p>';
				echo '<p class="coupon-code-manual">'.$manual_text.'</p>';
			}
			else if( $type == '2' ){
				$coupon_printable = get_post_meta( $coupon_id, 'coupon_printable', true );
				if( !empty( $coupon_printable ) ){
					$image_data = wp_get_attachment_image_src( $coupon_printable, 'full' );
					echo '<a class="coupon-code-modal header-alike" href="'.esc_url( $image_data[0] ).'" target="_blank">'.esc_html__( 'PRINT CODE', 'couponis' ).'</a>';
				}
			}
			else if( $type == '3' ){
				echo '<a class="coupon-code-modal header-alike sale-act-btn" href="'.esc_url( add_query_arg( array( 'dout' => $coupon_id ), home_url('/') ) ).'" target="_blank">'.esc_html__( 'GET DEAL', 'couponis' ).'</a>';
				echo '<p class="coupon-code-copied">'.esc_html__( 'Click button above to shop online and save', 'couponis' ).'</p>';
			}		
			?>

			<div class="coupon-works">
				<span><?php esc_html_e( 'Did it worked?','couponis' ) ?></span>
				<p class="feedback-wrap">
					<?php couponis_feedback_links( $coupon_id ); ?>
				</p>
			</div>
		</div>

		<div class="modal-body modal-body-share">

			<div class="flex-wrap flex-always">
				<div class="flex-left">
					<a href="javascript:;" class="small-action modal-content-action">
						<?php esc_html_e( 'SHOW INFORMATION', 'couponis' ) ?>
					</a>
				</div>
				<div class="flex-right">
					<?php include( get_theme_file_path( 'includes/share.php' ) ) ?>
				</div>
			</div>

			<div class="modal-coupon-content hidden">
				<?php echo apply_filters( 'the_content', $coupon->post_content ); ?>
			</div>

		</div>

		<div class="modal-footer">
			<ul class="list-unstyled list-inline">
				<li>
					<span class="icon-lock-open"></span> <?php esc_html_e( 'Used by', 'couponis' ) ?>  <?php echo  $used; ?>
				</li>
				<?php if( !empty( $store ) ): ?>
					<li>
						<a href="<?php echo get_term_link( $store ) ?>">
							<?php echo esc_html__( 'See all ', 'couponis' ).'<strong>'.$store->name.'</strong>'.esc_html__( ' Coupons & Deals', 'couponis' ); ?>
						</a>
					</li>
				<?php endif; ?>
			</ul>

		</div>

		<?php
	}
	die();
}
add_action('wp_ajax_show_code', 'couponis_show_code');
add_action('wp_ajax_nopriv_show_code', 'couponis_show_code');
}

/*
Get feedback cookie
*/
if( !function_exists('couponis_get_feedback_cookie') ){
function couponis_get_feedback_cookie(){
	$coupon_ids = array();
	if( !empty( $_COOKIE['couponis_feedback'] ) ){
		$coupon_ids = explode( '-', $_COOKIE['couponis_feedback'] );
	}

	return $coupon_ids;
}
}

/*
Prepare feedback links
*/
if( !function_exists('couponis_feedback_links') ){
function couponis_feedback_links( $coupon_id ){
	$coupon_ids = couponis_get_feedback_cookie();

	if( in_array( $coupon_id, $coupon_ids ) ){
		?>
		<a href="javascript:;" class="disabled"><i class="icon-like"></i></a>
		<a href="javascript:;" class="disabled"><i class="icon-dislike"></i></a>
		<?php
	}
	else{
		?>
		<a href="javascript:;" class="feedback-record-action" data-value="+" data-coupon_id="<?php echo esc_attr( $coupon_id ) ?>"><i class="icon-like"></i></a>
		<a href="javascript:;" class="feedback-record-action" data-value="-" data-coupon_id="<?php echo esc_attr( $coupon_id ) ?>"><i class="icon-dislike"></i></a>
		<?php
	}
}
}

/*
Save feedback
*/
if( !function_exists('couponis_save_feedback') ){
function couponis_save_feedback(){
	$coupon_ids = couponis_get_feedback_cookie();

	$coupon_id = esc_sql( $_POST['coupon_id'] );
	$feedback = esc_sql( $_POST['feedback'] );
	$positive = couponis_get_coupon_meta( $coupon_id, 'positive', true );
	$negative = couponis_get_coupon_meta( $coupon_id, 'negative', true );
	$feedback == '+' ? $positive++ : $negative++;

	$success = round( ( $positive / ( $positive + $negative ) ) * 100 );

	if( $feedback == '+' ){
		couponis_save_coupon_meta( $positive, 'positive', $coupon_id );
	}
	else{
		couponis_save_coupon_meta( $negative, 'negative', $coupon_id );
	}
	couponis_save_coupon_meta( $success, 'success', $coupon_id );

	$coupon_ids[] = $coupon_id;
	setcookie( 'couponis_feedback', implode( '-' , $coupon_ids ),  time()+60*60*24*700, '/' );

	?>
	<a href="javascript:;" class="disabled"><i class="icon-like"></i></a>
	<a href="javascript:;" class="disabled"><i class="icon-dislike"></i></a>
	<?php
	die();
}
add_action('wp_ajax_feedback', 'couponis_save_feedback');
add_action('wp_ajax_nopriv_feedback', 'couponis_save_feedback');
}

/*
Sort taxonomies hierarchicaly.
*/
if( !function_exists( 'couponis_sort_terms_hierarchicaly' ) ){
function couponis_sort_terms_hierarchicaly(Array &$cats, Array &$into, $parentId = 0){
    foreach ($cats as $i => $cat) {
        if ($cat->parent == $parentId) {
            $into[$cat->term_id] = $cat;
            unset($cats[$i]);
        }
    }

    foreach ($into as $topCat) {
        $topCat->children = array();
        couponis_sort_terms_hierarchicaly($cats, $topCat->children, $topCat->term_id);
    }

}
}

/*
Get hierarchical_terms
*/
if( !function_exists('couponis_get_hierarchical_terms') ){
function couponis_get_hierarchical_terms( $taxonomy, $hide_empty = true ){
	$terms = get_terms(array(
		'taxonomy' 		=> $taxonomy,
		'hide_empty'	=> $hide_empty
	));
	$sorted_terms = array();
	couponis_sort_terms_hierarchicaly( $terms, $sorted_terms );
	usort( $sorted_terms, "couponis_organized_sort_name_asc" );
	
	return $sorted_terms;
}
}

/*
Organize by name ASC
*/
if( !function_exists( 'couponis_organized_sort_name_asc' ) ){
function couponis_organized_sort_name_asc( $a, $b ){
    return strcasecmp( $a->name, $b->name );
}
}

/*
List terms in select options
*/
if( !function_exists('couponis_list_terms_select') ){
function couponis_list_terms_select( $terms, $selected = '', $level = 0 ){
	if( !empty( $terms ) ){
		foreach( $terms as $term ){
			echo '<option value="'.esc_attr( $term->term_id ).'" '.( $term->term_id == $selected ? 'selected="selected"' : '' ).'>'.str_repeat('&nbsp;', $level).$term->name.'</option>';
			if( !empty( $term->children ) ){
				couponis_list_terms_select( $term->children, $selected, $level+1 );
			}
		}
	}
}
}

/*
Couponis login to site
*/
if( !function_exists('couponis_login') ){
function couponis_login(){
	$username = esc_sql( $_POST['l_username'] );	
	$password = esc_sql( $_POST['l_password'] );
	$remember = isset( $_POST['l_remember'] ) ? true : false;

	if( empty( $_POST['captcha'] ) || empty( $username ) || empty( $password ) ){
		$response = array(
			'message' => '<div class="alert alert-danger">'.esc_html__( 'Fields marked with * are required.', 'couponis' ).'</div>',
		);
	}
	else{
		$user = get_user_by( 'login', $username );
		if( $user ){
			$activated = get_user_meta( $user->ID, 'activation_hash', true );
			if( !empty( $activated ) ){
					$response = array(
						'message' 	=> '<div class="alert alert-danger">'.esc_html__( 'Account is not activated yet.', 'couponis' ).'</div>'
					);
			}
			else{
				$user = wp_signon(array(
					'user_login' 		=> $username,
					'user_password'		=> $password,
					'rememberme'		=> $remember
				));

				if( !is_wp_error( $user ) ){
					$response = array(
						'message' 	=> '<div class="alert alert-success">'.esc_html__( 'You are logged in, wait a second.', 'couponis' ).'</div>',
						'reload'	=> true
					);
				}
				else{
					$response = array(
						'message' 	=> '<div class="alert alert-danger">'.esc_html__( 'Credentials are invalid.', 'couponis' ).'</div>'
					);
				}
			}
		}
		else{
			$response = array(
				'message' 	=> '<div class="alert alert-danger">'.esc_html__( 'Credentials are invalid.', 'couponis' ).'</div>'
			);
		}
	}
	
	echo json_encode( $response );

	die();	
}
add_action('wp_ajax_login', 'couponis_login');
add_action('wp_ajax_nopriv_login', 'couponis_login');
}

/*
Generate lost instructions
*/
if( !function_exists('couponis_lost') ){
function couponis_lost(){
	$email = esc_sql( $_POST['l_email'] );	

	if( empty( $_POST['captcha'] ) || empty( $email ) ){
		$response = array(
			'message' => '<div class="alert alert-danger">'.esc_html__( 'Fields marked with * are required.', 'couponis' ).'</div>',
		);
	}
	else if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
		$response = array(
			'message' => '<div class="alert alert-danger">'.esc_html__( 'E-mail address is not valid.', 'couponis' ).'</div>',
		);	
	}
	else{
		$user = get_user_by( 'email', $email );
		if( $user ) {
			$hash = md5( time() );
			update_user_meta( $user->ID, 'recover_hash', $hash );
			$link = add_query_arg( array( 'recover_hash' => $hash, 'login' => $user->user_login ), home_url( '/' ) );
	    	$message = '
<table style="background-color:#f2f2f2" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
	<tbody>
        <tr>
    	   <td style="padding:40px 20px" align="center" valign="top">
        	   <table style="width:600px" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="padding-bottom:30px" align="center" valign="top">
                                <table style="background-color:#ffffff;border-collapse:separate!important;border-radius:4px" border="0" cellpadding="0" cellspacing="0" width="100%">
                        	        <tbody>
                                        <tr>
                                            <td style="color:#606060;font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:150%;padding-top:40px;padding-right:40px;padding-bottom:20px;padding-left:40px;text-align:left" align="center" valign="top">
                                               '.sprintf( esc_html__( 'Someone requested password recovery for your account ( username: %s ). If you have not done this then ignore this mail.', 'couponis'), '<strong>'.$user->user_login.'</strong>' ).'
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-right:40px;padding-bottom:40px;padding-left:40px" align="center" valign="middle">
                                                <table style="background-color:#6dc6dd;border-collapse:separate!important;border-radius:3px" border="0" cellpadding="0" cellspacing="0">
                                                    <tbody>
                                                        <tr>
                                                            <td style="color:#ffffff;font-family:Helvetica,Arial,sans-serif;font-size:15px;font-weight:bold;line-height:100%;padding-top:18px;padding-right:15px;padding-bottom:15px;padding-left:15px" align="center" valign="middle">
                                                                <a href="'.$link.'" style="color:#ffffff;text-decoration:none" target="_blank">'.esc_html__( 'Recover', 'couponis' ).'</a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>';

			wp_mail( $email, get_bloginfo( 'name' ).' - '.esc_html__( 'Password Recovery', 'couponis' ), $message, array( "Content-Type: text/html; charset=UTF-8" ));
			$response = array(
				'message' => '<div class="alert alert-success">'.esc_html__( 'Instructions are sent on provided mail.', 'couponis' ).'</div>',
			);
		}
		else{
			$response = array(
				'message' => '<div class="alert alert-danger">'.esc_html__( 'Unrecognized email.', 'couponis' ).'</div>',
			);
		}
	}
	
	echo json_encode( $response );
	
	die();	
}
add_action('wp_ajax_lost', 'couponis_lost');
add_action('wp_ajax_nopriv_lost', 'couponis_lost');
}

/*
Generate lost instructions
*/
if( !function_exists('couponis_recover') ){
function couponis_recover(){
	$password = esc_sql( $_POST['rl_password'] );
	$password_confirm = esc_sql( $_POST['rl_password_confirm'] );
	$login = esc_sql( $_POST['rl_login'] );
	$recover_hash = esc_sql( $_POST['rl_recover_hash'] );


	if( empty( $_POST['captcha'] ) || empty( $password ) || empty( $password_confirm ) ){
		$response = array(
			'message' => '<div class="alert alert-danger">'.esc_html__( 'Fields marked with * are required.', 'couponis' ).'</div>',
		);
	}
	else if( $password !== $password_confirm ){
		$response = array(
			'message' => '<div class="alert alert-danger">'.esc_html__( 'Passwords do not match.', 'couponis' ).'</div>',
		);
	}
	else{
		$user = get_user_by( 'login', $login );
		if( $user ){
			wp_set_password( $password, $user->ID );
			delete_user_meta( $user->ID, 'recover_hash' );
			$response = array(
				'message' => '<div class="alert alert-success">'.esc_html__( 'Password is updated.', 'couponis' ).'</div>',
			);
		}
	}
	
	echo json_encode( $response );
	
	die();	
}
add_action('wp_ajax_recover', 'couponis_recover');
add_action('wp_ajax_nopriv_recover', 'couponis_recover');
}

/*
Generate lost instructions
*/
if( !function_exists('couponis_register') ){
function couponis_register(){
	$username = esc_sql( $_POST['r_username'] );
	$email = esc_sql( $_POST['r_email'] );
	$password = esc_sql( $_POST['r_password'] );
	$password_confirm = esc_sql( $_POST['r_password_confirm'] );

	if( empty( $_POST['captcha'] ) || empty( $username ) || empty( $email ) || empty( $password ) || empty( $password_confirm ) ){
		$response = array(
			'message' => '<div class="alert alert-danger">'.esc_html__( 'Fields marked with * are required.', 'couponis' ).'</div>',
		);
	}
	else if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
		$response = array(
			'message' => '<div class="alert alert-danger">'.esc_html__( 'E-mail address is not valid.', 'couponis' ).'</div>',
		);	
	}
	else if( $password !== $password_confirm ){
		$response = array(
			'message' => '<div class="alert alert-danger">'.esc_html__( 'Passwords do not match.', 'couponis' ).'</div>',
		);
	}
	else if( email_exists( $email ) ){
		$response = array(
			'message' => '<div class="alert alert-danger">'.esc_html__( 'Email is already registered.', 'couponis' ).'</div>',
		);
	}
	else if( username_exists( $username ) ){
		$response = array(
			'message' => '<div class="alert alert-danger">'.esc_html__( 'Username is already registered.', 'couponis' ).'</div>',
		);
	}
	else{
		$user = wp_insert_user(array(
		    'user_login'  =>  $username,
		    'user_email'  =>  $email,
		    'user_pass'   =>  $password
		));
		if( !is_wp_error( $user ) ){
			$user = get_user_by( 'id', $user );
			$hash = md5( time() );
			update_user_meta( $user->ID, 'activation_hash', $hash );
			$link = add_query_arg( array( 'activation_hash' => $hash, 'login' => $user->user_login ), home_url( '/' ) );
	    	$message = '
<table style="background-color:#f2f2f2" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
	<tbody>
        <tr>
    	   <td style="padding:40px 20px" align="center" valign="top">
        	   <table style="width:600px" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="padding-bottom:30px" align="center" valign="top">
                                <table style="background-color:#ffffff;border-collapse:separate!important;border-radius:4px" border="0" cellpadding="0" cellspacing="0" width="100%">
                        	        <tbody>
                                        <tr>
                                            <td style="color:#606060;font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:150%;padding-top:40px;padding-right:40px;padding-bottom:20px;padding-left:40px;text-align:left" align="center" valign="top">
                                               <strong>'.$user->user_login.'</strong> '.esc_html__( 'your account is created. Click on the button bellow to verify this email address.', 'couponis' ).'
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-right:40px;padding-bottom:40px;padding-left:40px" align="center" valign="middle">
                                                <table style="background-color:#6dc6dd;border-collapse:separate!important;border-radius:3px" border="0" cellpadding="0" cellspacing="0">
                                                    <tbody>
                                                        <tr>
                                                            <td style="color:#ffffff;font-family:Helvetica,Arial,sans-serif;font-size:15px;font-weight:bold;line-height:100%;padding-top:18px;padding-right:15px;padding-bottom:15px;padding-left:15px" align="center" valign="middle">
                                                                <a href="'.$link.'" style="color:#ffffff;text-decoration:none" target="_blank">'.esc_html__( 'Verify Email', 'couponis' ).'</a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>';

			wp_mail( $email, get_bloginfo( 'name' ).' - '.esc_html__( 'Account Registration', 'couponis' ), $message, array( "Content-Type: text/html; charset=UTF-8" ));
			$response = array(
				'message' => '<div class="alert alert-success">'.esc_html__( 'Account is created, check your mail.', 'couponis' ).'</div>',
			);
		}
	}
	
	echo json_encode( $response );
	
	die();	
}
add_action('wp_ajax_register', 'couponis_register');
add_action('wp_ajax_nopriv_register', 'couponis_register');
}

/*
Check for account activation
*/
if( !function_exists('couponis_activate_account') ){
function couponis_activate_account(){
	if( !empty( $_GET['activation_hash'] ) && !empty( $_GET['login'] )){
		$user = get_user_by( 'login', $_GET['login'] );
		if( $user ){
			$activation_hash = get_user_meta( $user->ID, 'activation_hash', true );
			if( $activation_hash == $_GET['activation_hash'] ){
				delete_user_meta( $user->ID, 'activation_hash' );
				?>
				<div class="alert alert-success activation-alert"><?php echo esc_html__( 'Hello', 'couponis' ).' <strong>'.$_GET['login'].'</strong>. '.esc_html__( 'Your account is activated now.', 'couponis' ); ?></div>
				<?php
			}
		}
	}
}
}

/*
Update profile
*/
if( !function_exists('couponis_update_profile') ){
function couponis_update_profile(){
	$email = esc_sql( $_POST['email'] );
	$password = esc_sql( $_POST['password'] );
	$password_confirm = esc_sql( $_POST['password_confirm'] );

	if( empty( $email ) ){
		$response = array(
			'message' => '<div class="alert alert-danger">'.esc_html__( 'Fields marked with * are required.', 'couponis' ).'</div>',
		);
	}
	else if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
		$response = array(
			'message' => '<div class="alert alert-danger">'.esc_html__( 'E-mail address is not valid.', 'couponis' ).'</div>',
		);	
	}
	else{
		$update_email = false;
		$update_password = false;
		$error = false;
		$response['message'] = '';

		$user = wp_get_current_user();
		if( $user->user_email !== $email ){
			$update_email = true;
		}

		if( !empty( $password ) && !empty( $password_confirm ) ){
			if( $password != $password_confirm ){
				$error = true;
				$response = array(
					'message' => '<div class="alert alert-danger">'.esc_html__( 'Passwords do not match.', 'couponis' ).'</div>',
				);
			}
			else{
				$update_password = true;
			}
		}

		$userdata = array();
		if( $update_email ){
			$userdata['user_email'] = $email;
		}
		if( $update_password ){
			$userdata['user_pass'] = $password;
		}

		if( !empty( $userdata ) && !$error ){
			$userdata['ID'] = $user->ID;
			wp_update_user( $userdata );
			$response = array(
				'message' => '<div class="alert alert-success">'.esc_html__( 'Your profile is updated.', 'couponis' ).'</div>',
			);
		}
	}
	
	echo json_encode( $response );
	
	die();
}
add_action('wp_ajax_update_profile', 'couponis_update_profile');
add_action('wp_ajax_nopriv_update_profile', 'couponis_update_profile');
}

/*
Save submited coupons
*/
if( !function_exists('couponis_submit_coupon')){
function couponis_submit_coupon(){
	$store = esc_sql( $_POST['store'] );
	$no_store = isset( $_POST['no_store'] ) ? true : false;
	$new_store_name = esc_sql( $_POST['new_store_name'] );
	$new_store_link = esc_sql( $_POST['new_store_link'] );

	$category = esc_sql( $_POST['category'] );

	$type = esc_sql( $_POST['type'] );
	$coupon_code = esc_sql( $_POST['coupon_code'] );
	$coupon_printable = (isset($_FILES['coupon_printable']) && $_FILES['coupon_printable']['size'] > 0) ? true : false;
	$coupon_url = esc_sql( $_POST['coupon_url'] );

	$featured_image = (isset($_FILES['featured_image']) && $_FILES['featured_image']['size'] > 0) ? true : false;

	$expire = esc_sql( $_POST['expire'] );
	$no_expire = isset( $_POST['no_expire'] ) ? true : false;

	$title = esc_sql( $_POST['title'] );
	$exclusive = isset( $_POST['exclusive'] ) ? 1 : false;
	$description = esc_sql( $_POST['description'] );

	if( ( empty( $store ) && !$no_store ) || ( $no_store && ( empty( $new_store_name ) || empty( $new_store_link ) ) ) 
		|| empty( $category ) 
		|| ( $type == 1 && empty( $coupon_code ) ) || ( $type == 2 && !$coupon_printable ) || ( $type == 3 && empty( $coupon_url ) )
		|| empty( $title )
		|| empty( $description )
	){
		$response = array(
			'message' => '<div class="alert alert-danger">'.esc_html__( 'Fields marked with * are required.', 'couponis' ).'</div>',
		);
	}
	else{
		if( $no_store ){
			$check_store = get_term_by( 'slug', sanitize_title( $new_store_name ), 'coupon-store' );
			if( $check_store ){
				$store = $check_store->term_id;
			}
			else{
				$store_data = wp_insert_term( $new_store_name, 'coupon-store' );
				$store = $store_data['term_id'];
				update_term_meta( $store, 'store_url', $new_store_link );
			}
		}

		$post_id = wp_insert_post(array(
			'post_type'		=> 'coupon',
			'post_title'	=> $title,
			'post_status'	=> 'pending',
			'post_content'	=> $description
		));

		wp_set_post_terms( $post_id, array( $store ), 'coupon-store' );

		$ancestors = get_ancestors( $category, 'coupon-category' );
		$ancestors[] = $category;
		wp_set_post_terms( $post_id, $ancestors, 'coupon-category' );

		couponis_save_coupon_meta( $type, 'ctype', $post_id );
		if( $type == 1 ){
			update_post_meta( $post_id, 'coupon_code', $coupon_code );
		}
		else if( $type == 2 ){
			$coupon_printable = couponis_handle_image_upload( $_FILES['coupon_printable'] );
			update_post_meta( $post_id, 'coupon_printable', $coupon_printable );
		}
		else if( $type == 3 ){
			update_post_meta( $post_id, 'coupon_url', $coupon_url );
		}

		if( !empty( $expire ) && !$no_expire ){
			$expire = strtotime( $expire );
		}
		else{
			$expire = '';
		}

		if( $featured_image === true ){
			$featured_image = couponis_handle_image_upload( $_FILES['featured_image'] );
			set_post_thumbnail( $post_id, $featured_image );
		}

		couponis_save_coupon_meta( $expire, 'expire', $post_id );
		couponis_save_coupon_meta( $exclusive, 'exclusive', $post_id );

		$response = array(
			'message' => '<div class="alert alert-success">'.esc_html__( 'Coupon is submited for review. Thank You!', 'couponis' ).'</div>',
		);

	}

	echo json_encode( $response );
	die();
}
add_action('wp_ajax_submit', 'couponis_submit_coupon');
add_action('wp_ajax_nopriv_submit', 'couponis_submit_coupon');
}

if( !function_exists('couponis_handle_image_upload') ){
function couponis_handle_image_upload( $file, $attach_to = 0 ){
	$movefile = wp_handle_upload( $file, array( 'test_form' => false ) );

	$attachment = array(
		'guid'           => $movefile['url'],
		'post_mime_type' => $movefile['type'],
		'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $movefile['file'] ) ),
		'post_content'   => '',
		'post_status'    => 'inherit'
	);

	$attach_id = wp_insert_attachment( $attachment, $movefile['file'], $attach_to );

	require_once( ABSPATH . 'wp-admin/includes/image.php' );

	$attach_data = wp_generate_attachment_metadata( $attach_id, $movefile['file'] );
	wp_update_attachment_metadata( $attach_id, $attach_data );

	return $attach_id;
}
}

/*
couponis breadcrumbs
*/
if( !function_exists('couponis_breadcrumbs') ){
function couponis_breadcrumbs(){
	$breadcrumb = '';
	if( is_front_page() || ( is_home() && !class_exists('ReduxFramework') ) ){
		return '';
	}
	$breadcrumb .= '<ul class="breadcrumb">';
	if( !is_front_page() ){
		$breadcrumb .= '<li><a href="'.esc_url( home_url('/') ).'">'.esc_html__( 'Home', 'couponis' ).'</a></li>';
	}
	if( is_home() ){
		$page_for_posts = get_option( 'page_for_posts' );
		if( !empty( $page_for_posts ) ){
			$breadcrumb .= '<li>'.get_the_title( $page_for_posts ).'</li>';
		}
		else{
			$breadcrumb .= '<li>'.esc_html__( 'Blog', 'couponis' ).'</li>';
		}
	}
	else if( is_category() ){
		$breadcrumb .= '<li>'.single_cat_title( '', false ).'</li>';
	}
	else if( is_404() ){
		$breadcrumb .= '<li>'.esc_html__( '404', 'couponis' ).'</li>';
	}
	else if( is_tag() ){
		$breadcrumb .= '<li>'.esc_html__('Search by tag: ', 'couponis'). get_query_var('tag').'</li>';
	}
	else if( is_author() ){
		$breadcrumb .= '<li>'.esc_html__('Posts by', 'couponis').'</li>';
	}
	else if( is_archive() ){
		$breadcrumb .= '<li>'.esc_html__('Archive for:', 'couponis'). single_month_title(' ',false).'</li>';
	}
	else if( is_search() ){
		$breadcrumb .= '<li>'.esc_html__('Search results for: ', 'couponis').' '. get_search_query().'</li>';
	}
	else if( is_page() ){
		$ancestors = get_post_ancestors( get_the_ID() );
		if( !empty( $ancestors ) ){
			$ancestors = array_reverse( $ancestors );
			foreach( $ancestors as $ancestor ){
				$breadcrumb .= '<li><a href="'.get_the_permalink( $ancestor ).'">'.get_the_title( $ancestor ).'</a></li>';
			}
		}
		$breadcrumb .= '<li>'.get_the_title().'</li>';
	}
	else{
		$breadcrumb .= '<li>'.get_the_title().'</li>';
	}
	$breadcrumb .= '</ul>';

	return $breadcrumb;
}
}

/*
If search page is updated resave permalinks
*/
if( !function_exists('couponis_flush_permalinks') ){
function couponis_flush_permalinks( $post_id, $post ){
    $post_type = get_post_type($post_id);

    if ( "page" != $post_type ){
    	return;
    }

    if( $post->page_template == 'page-tpl_search.php' ){
    	update_option( 'couponis_search_coupons_slug', $post->post_name );
		flush_rewrite_rules();
    }
}
add_action( 'save_post', 'couponis_flush_permalinks', 10 , 2 );
}

/*
Create rewrite rules
*/
if( !function_exists('couponis_rewrite_rules') ){
function couponis_rewrite_rules() {
	$search_coupons_slug = get_option( 'couponis_search_coupons_slug' );
	if( !empty( $search_coupons_slug ) ){
		add_rewrite_rule( $search_coupons_slug.'/page/?([^/]*)', 'index.php?pagename='.$search_coupons_slug.'&paged=$matches[1]', 'top' );
	}
}
add_action('init', 'couponis_rewrite_rules');
}



/*
Make wordpress aware of custom slugs
*/
if( !function_exists('couponis_query_vars') ){
function couponis_query_vars( $vars ) {
	$search_coupons_slug = get_option( 'couponis_search_coupons_slug' );

	if( !empty( $search_coupons_slug ) ){
		$vars[] = $search_coupons_slug;
	}

	return $vars;
}
add_filter('query_vars', 'couponis_query_vars');
}

/*
Set coupons per page on taxonomy
*/
if( !function_exists('coupons_taxonomy_pre_get') ){
function coupons_taxonomy_pre_get( $query ){
	if( $query->is_main_query() ){
		if( $query->is_tax( 'coupon-store' ) || $query->is_tax( 'coupon-category' ) ){
			$coupons_per_page = couponis_get_option( 'coupons_per_page' );
			$query->set( 'posts_per_page', $coupons_per_page );
		}
	}
}
add_action( 'pre_get_posts', 'coupons_taxonomy_pre_get' );
}

/*
get search order by cookie vlue
*/
if( !function_exists('couponis_get_search_orderby_cookie') ){
function couponis_get_search_orderby_cookie(){
	$selected = '';
	if( !empty( $_COOKIE['couponis-orderby'] ) ){
		$selected = $_COOKIE['couponis-orderby'];
	}

	return $selected;
}
}

/*
Order by select
*/
if( !function_exists('couponis_search_orderby') ){
function couponis_search_orderby(){
	$selected = couponis_get_search_orderby_cookie();
	?>
	<div class="styled-select">
		<select name="orderby" class="orderby">
			<option value="expire" <?php echo  $selected == 'expire' ? 'selected="selected"' : '' ?>><?php esc_html_e( 'Ending Soon', 'couponis' ) ?></option>
			<option value="used" <?php echo  $selected == 'used' ? 'selected="selected"' : '' ?>><?php esc_html_e( 'Popular', 'couponis' ) ?></option>
			<option value="name" <?php echo  $selected == 'name' ? 'selected="selected"' : '' ?>><?php esc_html_e( 'Name', 'couponis' ) ?></option>
			<option value="date" <?php echo  $selected == 'date' ? 'selected="selected"' : '' ?>><?php esc_html_e( 'Date Added', 'couponis' ) ?></option>
		</select>
	</div>
	<?php
}
}

/*
Get selected listing method
*/
if( !function_exists('couponis_get_listing_style') ){
function couponis_get_listing_style(){
	if( !empty( $_COOKIE['couponis-listing-style'] ) ){
		return $_COOKIE['couponis-listing-style'];
	}
	else{
		return couponis_get_option( 'coupon_listing_style' );
	}
}
}

/*
Get listing style icons
*/
if( !function_exists('couponis_get_listing_style_icons') ){
function couponis_get_listing_style_icons(){
	$style = couponis_get_listing_style();

	?>
	<div class="listing-action">
		<a href="javascript:;" class="listing-style <?php echo  $style == 'grid' ? esc_attr('active') : '' ?>" data-value="grid" title="<?php esc_attr_e( 'Grid View', 'couponis' ) ?>"><i class="icon-grid"></i></a>
		<a href="javascript:;" class="listing-style <?php echo  $style == 'list' ? esc_attr('active') : '' ?>" data-value="list" title="<?php esc_attr_e( 'List View', 'couponis' ) ?>"><i class="icon-layers"></i></a>
	</div>
	<?php
}
}

/*
Get image sizes
*/
if( !function_exists('couponis_get_image_sizes') ){
function couponis_get_image_sizes(){
	$sizes = get_intermediate_image_sizes();
	$sizes_right = array();
	foreach( $sizes as $size ){
		$sizes_right[$size] = $size;
	}
	
	return $sizes_right;
}
}

if( !function_exists('couponis_set_direction') ){
function couponis_set_direction() {
	global $wp_locale, $wp_styles;

	$_user_id = get_current_user_id();
	$direction = couponis_get_option( 'direction' );
	if( empty( $direction ) ){
		$direction = 'ltr';
	}

	if ( $direction ) {
		update_user_meta( $_user_id, 'rtladminbar', $direction );
	} else {
		$direction = get_user_meta( $_user_id, 'rtladminbar', true );
		if ( false === $direction )
			$direction = isset( $wp_locale->text_direction ) ? $wp_locale->text_direction : 'ltr' ;
	}

	$wp_locale->text_direction = $direction;
	if ( ! is_a( $wp_styles, 'WP_Styles' ) ) {
		$wp_styles = new WP_Styles();
	}
	$wp_styles->text_direction = $direction;
}
add_action( 'init', 'couponis_set_direction' );
}

if( !function_exists('couponis_search_stores') ){
function couponis_search_stores(){
	$stores = get_terms(array(
		'taxonomy' 	=> 'coupon-store',
		'search'	=> $_POST['keyword']
	));

	if( !empty( $stores ) ){
		?>
		<div class="row">
			<?php
			$counter = 0;
			foreach( $stores as $store ){
				if( $counter == 6 ){
					echo '</div><div class="row">';
					$counter = 0;
				}
				$counter++;
				
				include( get_theme_file_path( 'includes/stores/store-box.php' ) );
			}
			?>
		</div>		
		<?php
	}
	else{
		?>
		<h4><?php esc_html_e( 'No stores found matching your criteria', 'couponis' ) ?></h4>
		<?php
	}
	die();
}
add_action('wp_ajax_search_stores', 'couponis_search_stores');
add_action('wp_ajax_nopriv_search_stores', 'couponis_search_stores');
}


if( !function_exists('couponis_remove_coupon_images') ){
function couponis_remove_coupon_images( $post_id ){
	global $post_type;   
	if ( $post_type != 'coupon' ){
		return;	
	}
	else{
		$coupon_printable = get_post_meta( $post_id, 'coupon_printable', true );
		if( !empty( $coupon_printable ) ){
			wp_delete_attachment( $coupon_printable, true );
		}
	    if( has_post_thumbnail( $post_id ) ){
			$attachment_id = get_post_thumbnail_id( $post_id );
			wp_delete_attachment( $attachment_id, true );
	    }
	}
}
add_action( 'before_delete_post', 'couponis_remove_coupon_images', 10 );
}

remove_filter ('wp_get_attachment_image_src', 'kc_get_attachment_image_src', 999, 4);

/*
Add quick filter link to coupons to show expired ones
*/
if( !function_exists('couponis_admin_filter_expired') ){
function couponis_admin_filter_expired( $views ) {
	global $wpdb;
	$expired = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(coupon_id) FROM {$wpdb->prefix}couponis_coupon_data AS ccd INNER JOIN {$wpdb->posts} AS posts ON ccd.post_id = posts.ID WHERE expire <= %d AND post_status = 'publish' AND post_type = 'coupon'", current_time( 'timestamp' ) ) );
    $views['expired'] = '<a href="'.esc_url( admin_url('edit.php?post_type=coupon&expired_coupons=1') ).'">'.esc_html__( 'Expired', 'couponis' ).' <span class="count">('.$expired.')</span></a>';
    return $views;
}
add_filter('views_edit-coupon','couponis_admin_filter_expired');
}

/*
If we are on on admin listing opf coupons add filters
*/
if( !function_exists('couponis_admin_filter_expired_coupons') ){
function couponis_admin_filter_expired_coupons( $query ) {
	if( !empty( $_GET['expired_coupons'] ) ){
		add_filter( 'posts_join', 'couponis_admin_expired_filter_join' );
		add_filter( 'posts_where', 'couponis_admin_expired_filter_where' );
	}
	return $query;
}
add_filter('pre_get_posts', 'couponis_admin_filter_expired_coupons');
}

/*
Join table for coupons listing in admin
*/
if( !function_exists('couponis_admin_expired_filter_join') ){
function couponis_admin_expired_filter_join( $sql ){
	global $wpdb;
	return $sql . " INNER JOIN {$wpdb->prefix}couponis_coupon_data AS coupons ON {$wpdb->posts}.ID = coupons.post_id ";
}
}

/*
Where filter for admin coupon listing
*/
if( !function_exists('couponis_admin_expired_filter_where') ){
function couponis_admin_expired_filter_where( $sql ){
	global $wpdb;
	return $sql .= $wpdb->prepare( " AND coupons.expire <= %d AND post_status = 'publish' ", current_time('timestamp') );
}
}

/*
Get all available letters of the stores
*/
if( !function_exists('couponis_fetch_store_letters') ){
function couponis_fetch_store_letters(){
	global $wpdb;
	$list_empt_cats_stores = couponis_get_option( 'list_empt_cats_stores' );
	$letters_sql = "SELECT DISTINCT ( CASE WHEN LEFT(name, 1) BETWEEN  '0' AND '9' THEN '0-9' ELSE UPPER(LEFT(name, 1)) END ) AS letter FROM {$wpdb->prefix}terms AS wt LEFT JOIN {$wpdb->prefix}term_taxonomy AS wtt ON wt.term_id = wtt.term_id WHERE taxonomy = 'coupon-store' ";
	if( $list_empt_cats_stores == 'yes' ){
		$letters_sql .= "AND count > 0 ";
	}
	$letters_sql .= "ORDER BY letter ASC";
	$letters = $wpdb->get_col( $letters_sql );

	return $letters;
}
}

/*
Get stopres by letter
*/
if( !function_exists('couponis_fetch_stores_by_letter') ){
function couponis_fetch_stores_by_letter( $letter, $all = false ){
	global $wpdb;
	$list_empt_cats_stores = couponis_get_option( 'list_empt_cats_stores' );
	$stores_sql = "SELECT ".( $all ? '' : 'SQL_CALC_FOUND_ROWS' )." * FROM {$wpdb->prefix}terms AS wt LEFT JOIN {$wpdb->prefix}term_taxonomy AS wtt ON wt.term_id = wtt.term_id WHERE taxonomy = 'coupon-store' AND LEFT(name, 1) ";
	if( $letter == '0-9' ){
		$stores_sql .= "BETWEEN '0' AND '9' ";
	}
	else{
		$stores_sql .= $wpdb->prepare( " = %s ", $letter );
	}
	if( $list_empt_cats_stores == 'yes' ){
		$stores_sql .= "AND count > 0 ";
	}
	if( $all ){
		$stores_sql .= "ORDER BY name ASC LIMIT 100000 OFFSET 6";
	}
	else{
		$stores_sql .= "ORDER BY name ASC LIMIT 6";
	}
	$stores = $wpdb->get_results( $stores_sql );

	return $stores;
}
}

/*
Get number of pages for stores by letter
*/
if( !function_exists('couponis_fetch_found_stores_by_letter') ){
function couponis_fetch_found_stores_by_letter(){
	global $wpdb;
	return $wpdb->get_var( "SELECT FOUND_ROWS()" );
}
}

/*
Print stores for alt page
*/
if( !function_exists('couponis_print_alt_stores') ){
function couponis_print_alt_stores( $stores ){
	if( !empty( $stores ) ){
		?>
		<div class="row">
			<?php
			$counter = 0;
			foreach( $stores as $store ){
				if( $counter == 6 ){
					echo '</div><div class="row">';
					$counter = 0;
				}
				$counter++;
				echo $store;
			}
			?>
		</div>
		<?php
	}
}
}

/*
Fetch stores by letter ajax
*/
if( !function_exists('couponis_load_all_stores_letter') ){
function couponis_load_all_stores_letter(){
	global $wpdb;
	$letter = $_POST['letter'];
	if( !empty( $letter ) ){
		$stores = couponis_fetch_stores_by_letter( $letter, true );
		$stores_html = array();
		if( !empty( $stores ) ){
			foreach( $stores as $store ){
				ob_start();
				include( get_theme_file_path( 'includes/stores/store-box.php' ) );
				$stores_html[] = ob_get_contents();
				ob_end_clean();
			}
			couponis_print_alt_stores( $stores_html );
		}
	}
	die();
}
add_action( 'wp_ajax_load_all_stores_letter', 'couponis_load_all_stores_letter' );
add_action( 'wp_ajax_nopriv_load_all_stores_letter', 'couponis_load_all_stores_letter' );
}

/*
* Get taxonomy via ajax
*/
if( !function_exists('couponis_taxonomy_ajax') ){
function couponis_taxonomy_ajax(){
	$terms = get_terms(array(
		'taxonomy' 		=> $_REQUEST['taxonomy'],
		'name__like' 	=> $_REQUEST['s'],
	));

	$result = array();
	if( !empty( $terms ) ){
		foreach( $terms as $term ){
			$result[] = array(
				'id'	=> $term->term_id,
				'text'	=> $term->name
			);
		}
	}

	echo json_encode(array(
		'results' 		=> $result,
		'pagination'	=> array(
			'more'	=> false
		)
	));
	die();
}
add_action( 'wp_ajax_taxonomy_ajax', 'couponis_taxonomy_ajax' );
add_action( 'wp_ajax_nopriv_taxonomy_ajax', 'couponis_taxonomy_ajax' );
}

include( get_theme_file_path( 'includes/class-tgm-plugin-activation.php' ) );
include( get_theme_file_path( 'includes/class.coupon-query.php' ) );
include( get_theme_file_path( 'includes/widgets.php' ) );
include( get_theme_file_path( 'includes/fonts.php' ) );
include( get_theme_file_path( 'includes/font-icons.php' ) );
include( get_theme_file_path( 'includes/theme-options.php' ) );
include( get_theme_file_path( 'includes/category-icon.php' ) );
include( get_theme_file_path( 'includes/store-image.php' ) );
include( get_theme_file_path( 'includes/shortcodes.php' ) );
?>