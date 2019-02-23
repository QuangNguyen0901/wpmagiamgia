<?php

	/**********************************************************************
	***********************************************************************
	COUPONIS FUNCTIONS
	**********************************************************************/

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
	    if( $smeta_data['couponis-demo.php']['Version'] != '1.5' ):
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

}
add_action( 'admin_notices', 'couponis_check_api' );
}


/***********************************************
************************************************
************************************************/


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
	
	add_theme_support('post-thumbnails');
	
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
	wp_enqueue_style( 'bootstrap', get_theme_file_uri( '/css/bootstrap.min.css' ) );
	wp_enqueue_style( 'font-awesome', get_theme_file_uri( '/css/font-awesome.min.css' ) );
	wp_enqueue_style( 'simple-line-icons', get_theme_file_uri( '/css/simple-line-icons.css' ) );
	wp_enqueue_style( 'magnific-popup', get_theme_file_uri( '/css/magnific-popup.css' ) );

	wp_enqueue_style( 'select2', get_theme_file_uri( '/css/select2.min.css' ) );	
	wp_enqueue_script('select2', get_theme_file_uri( '/js/select2.min.js' ), array('jquery'), false, true);
	

	/*load selecte fonts*/
	couponis_enqueue_font();
	
	/* load style.css */
	
	if (is_singular() && comments_open() && get_option('thread_comments')){
		wp_enqueue_script('comment-reply');
	}

	/* bootstrap */
	wp_enqueue_script('bootstrap', get_theme_file_uri( '/js/bootstrap.min.js' ), array('jquery'), false, true);

	/* custom */
	wp_enqueue_script('magnific-popup', get_theme_file_uri( '/js/jquery.magnific-popup.min.js' ), array('jquery'), false, true);

	if( ( is_page() && get_page_template_slug() == 'page-tpl_contact.php' ) || is_tax( 'coupon-store' ) ){
		$api = '';
		$google_api_key = couponis_get_option( 'google_api_key' );
		if( !empty( $google_api_key ) ){
			$api = '&key='.$google_api_key;
		}
		wp_enqueue_script( 'couponis-googlemap', 'https://maps.googleapis.com/maps/api/js?'.$api, false, false, true );
	}

	if( is_page() && get_page_template_slug() == 'page-tpl_home.php' ){
		wp_enqueue_style( 'owl-carousel', get_theme_file_uri( '/css/owl.carousel.css' ) );
		wp_enqueue_script('owl-carousel', get_theme_file_uri( '/js/owl.carousel.min.js' ), array('jquery'), false, true);
	}

	if( is_page() && get_page_template_slug() == 'page-tpl_submit.php' ){
		if( function_exists('cmb_init') ){
			wp_enqueue_style( 'cmb-jquery-ui', trailingslashit( CMB_URL ) . 'css/vendor/jquery-ui/jquery-ui.css');
			wp_enqueue_style( 'cmb-timepicker-ui', trailingslashit( CMB_URL ) . '/css/jquery-ui-timepicker-addon.css');
			wp_enqueue_style( 'cmb-datetimepicker', get_theme_file_uri( '/css/datetimepicker.min.css' ) );
			wp_enqueue_script( 'cmb-timepicker', trailingslashit( CMB_URL ) . 'js/jquery-ui-timepicker-addon.js', array( 'jquery', 'jquery-ui-slider', 'jquery-ui-core', 'jquery-ui-datepicker' ) );
		}
	}

	if( is_singular( 'coupon' ) ){
		wp_enqueue_script( 'countdown',  get_theme_file_uri( '/js/countdown.js' ), array('jquery'), false, true );
	}

	if( is_tax('coupon-category') || is_tax('coupon-store') || (is_page() && get_page_template_slug() == 'page-tpl_search.php') ){
		wp_enqueue_script('cookie', get_theme_file_uri( '/js/js.cookie.js' ), array( 'jquery' ), false, true);
	}

	wp_enqueue_script('couponis-custom', get_theme_file_uri( '/js/custom.js' ), array('jquery'), false, true);
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
	include( get_theme_file_path( '/css/main-color.css.php' ) );
	$custom_css = ob_get_contents();
	ob_end_clean();
	wp_add_inline_style( 'couponis-style', $custom_css );	
}
add_action('wp_enqueue_scripts', 'couponis_add_main_style', 13);
}

if( !function_exists('couponis_admin_scripts_styles') ){
function couponis_admin_scripts_styles( $hook ){
	wp_enqueue_script('admin-js', get_theme_file_uri( '/js/admin.js' ), array('jquery'), false, true);
	if( isset( $_GET['taxonomy'] ) && $_GET['taxonomy'] == 'coupon-store' ){
		wp_enqueue_media();
		wp_enqueue_script('admin-taxonomy', get_theme_file_uri( '/js/admin-taxonomy.js' ), array('jquery'), false, true);
	}
	wp_enqueue_style('couponis-admin-style', get_theme_file_uri( '/css/admin.css' ) );
	wp_enqueue_style('couponis-awesome', get_theme_file_uri( '/css/font-awesome.min.css' ) );
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

			echo wp_kses_post( $fb_output );
		}
	}
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

/* include custom made widgets */
if( !function_exists('couponis_widgets_init') ){
function couponis_widgets_init(){

	$sidebars = array(
		array(
			'name' 			=> esc_html__('Blog Sidebar', 'couponis') ,
			'id' 			=> 'blog',
			'description' 	=> esc_html__('Appears on the eight side of all pages.', 'couponis')
		),
		array(
			'name' 			=> esc_html__('Page Right Sidebar', 'couponis') ,
			'id' 			=> 'right',
			'description' 	=> esc_html__('Appears on the right side of the page.', 'couponis')
		),
		array(
			'name' 			=> esc_html__('Page Left Sidebar', 'couponis') ,
			'id' 			=> 'left',
			'description' 	=> esc_html__('Appears on the left side of the page.', 'couponis')
		),
		array(
			'name' 			=> esc_html__('Search Sidebar', 'couponis') ,
			'id' 			=> 'search',
			'description' 	=> esc_html__('Appears on the left side of the search page.', 'couponis')
		),
		array(
			'name' 			=> esc_html__('Category Sidebar', 'couponis') ,
			'id' 			=> 'category',
			'description' 	=> esc_html__('Appears on the right side of the category taxonomy page.', 'couponis')
		),
		array(
			'name' 			=> esc_html__('Store Sidebar', 'couponis') ,
			'id' 			=> 'store',
			'description' 	=> esc_html__('Appears on the right side of the store taxonomy page.', 'couponis')
		),
		array(
			'name' 			=> esc_html__('Account Sidebar', 'couponis') ,
			'id' 			=> 'account',
			'description' 	=> esc_html__('Appears on the right side of the account page.', 'couponis')
		),
		array(
			'name' 			=> esc_html__('Submit Sidebar', 'couponis') ,
			'id' 			=> 'submit',
			'description' 	=> esc_html__('Appears on the right side of the submit page.', 'couponis')
		),
		array(
			'name' 			=> esc_html__('Single Coupon Sidebar', 'couponis') ,
			'id' 			=> 'coupon',
			'description' 	=> esc_html__('Appears on the right side of the single coupon page.', 'couponis')
		)
	);

	foreach( $sidebars as $sidebar ){
		register_sidebar(array(
			'name' 			=> $sidebar['name'],
			'id' 			=> $sidebar['id'],
			'before_widget' => '<div class="widget white-block clearfix %2$s" ><div class="white-block-content">',
			'after_widget' 	=> '</div></div>',
			'before_title' 	=> '<div class="widget-title"><h4>',
			'after_title' 	=> '</h4></div>',
			'description' 	=> $sidebar['description']
		));			
	}
}

add_action('widgets_init', 'couponis_widgets_init');
}

include( get_theme_file_path( 'includes/class-tgm-plugin-activation.php' ) );
?>