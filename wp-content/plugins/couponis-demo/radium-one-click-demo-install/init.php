<?php
/**
 * Version 0.0.3
 *
 * This file is just an example you can copy it to your theme and modify it to fit your own needs.
 * Watch the paths though.
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if ( !class_exists( 'Radium_Theme_Demo_Data_Importer' ) ) {

	require_once( plugin_dir_path( __FILE__ ).'importer/radium-importer.php' ); //load admin theme data importer

	class Radium_Theme_Demo_Data_Importer extends Radium_Theme_Importer {

		/**
		 * Set framewok
		 *
		 * options that can be used are 'default', 'radium' or 'optiontree'
		 *
		 * @since 0.0.3
		 *
		 * @var string
		 */
		public $theme_options_framework = 'default';

		/**
		 * Holds a copy of the object for easy reference.
		 *
		 * @since 0.0.1
		 *
		 * @var object
		 */
		private static $instance;

		/**
		 * Set the key to be used to store theme options
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $theme_option_name       = 'couponis_options'; //set theme options name here (key used to save theme options). Optiontree option name will be set automatically

		/**
		 * Set name of the theme options file
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $theme_options_file_name = 'theme_options.txt';

		/**
		 * Set name of the widgets json file
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $widgets_file_name       = 'widgets.json';

		/**
		 * Set name of the content file
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $content_demo_file_name  = 'content.xml';

		/**
		 * Holds a copy of the widget settings
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $widget_import_results;

		/**
		 * Constructor. Hooks all interactions to initialize the class.
		 *
		 * @since 0.0.1
		 */
		public function __construct() {

			$this->demo_files_path = plugin_dir_path( __FILE__ ).'demo-files/'; //can
			
			add_action( 'radium_import_end', array( $this, 'import_custom_data' ) );

			self::$instance = $this;
			parent::__construct();

		}

		/**
		 * Add custom data - import from custom data file
		 *
		 * @since 0.0.1
		 */
		public function import_custom_data(){
			$file = $this->demo_files_path.'custom_data.txt';
	    	// Does the File exist?
			if ( file_exists( $file ) ) {

				// Get file contents				
				$_POST['couponis_custom_data'] = file_get_contents( $file );
				couponis_import_cd_values();

      		} else {

	      		wp_die(
      				esc_htmlesc_html__( 'Theme options Import file could not be found. Please try again.', 'radium' ),
      				'',
      				array( 'back_link' => true )
      			);
       		}
		}

		/**
		 * Add menus - the menus listed here largely depend on the ones registered in the theme
		 *
		 * @since 0.0.1
		 */
		public function set_demo_menus(){

			// Menus to Import and assign - you can remove or add as many as you want
			$top_menu = get_term_by('name', 'Main Menu', 'nav_menu');
			$footermenu = get_term_by('name', 'Footer Menu', 'nav_menu');

			set_theme_mod( 'nav_menu_locations', array(
					'main-navigation' => $top_menu->term_id,
					'footer-navigation' => $footermenu->term_id
				)
			);

			$this->flag_as_imported['menus'] = true;

			/* Assign Home and Blog page */
			$home = get_page_by_title('Home');
			update_option('page_on_front',$home->ID);
			update_option('show_on_front','page');

			$blog = get_page_by_title('Blog');
			update_option('page_for_posts',$blog->ID);


			$list = array(
				'accessories' 	=> 'bullseye',
				'beauty' 		=> 'female',
				'black-friday' 	=> 'tag',
				'clothing' 		=> 'child',
				'electronics' 	=> 'desktop',
				'financial' 	=> 'bank',
				'food' 			=> 'cutlery',
				'free-shipping' => 'shopping-cart',
				'furniture' 	=> 'bed',
				'home-garden' 	=> 'home',
				'jewlery' 		=> 'diamond',
				'medical' 		=> 'heartbeat',
				'spoorting' 	=> 'soccer-ball-o',
				'stuff-picks' 	=> 'bullhorn',
				'travel' 		=> 'plane',
			);

			foreach( $list as $slug => $icon ){
				$term = get_term_by( 'slug', $slug, 'coupon-category' );
				if( $term ){
					update_term_meta( $term->term_id, 'category_icon', $icon );
				}
			}

			$stores = get_terms( 'coupon-store', array(
			    'hide_empty' => false,
			) );

			foreach( $stores as $store ){
				update_term_meta( $store->term_id, 'store_image', '360' );
			}

		}

	}

	new Radium_Theme_Demo_Data_Importer;

}