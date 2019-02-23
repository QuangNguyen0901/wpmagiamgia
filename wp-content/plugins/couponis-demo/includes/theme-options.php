<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: https://docs.reduxframework.com
     * */   

    global $couponis_opts;

    if ( ! class_exists( 'Couponis_Options' ) ) {

        class Couponis_Options {

            public $args = array();
            public $sections = array();
            public $theme;
            public $ReduxFramework;

            public function __construct() {

                if ( ! class_exists( 'ReduxFramework' ) ) {
                    return;
                }

                // This is needed. Bah WordPress bugs.  ;)
                //if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                    $this->initSettings();
                // } else {
                //     add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
                // }

            }

            public function initSettings() {

                // Just for demo purposes. Not needed per say.
                $this->theme = wp_get_theme();

                // Set the default arguments
                $this->setArguments();

                // Create the sections and fields
                $this->setSections();

                if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                    return;
                }

                // If Redux is running as a plugin, this will remove the demo notice and links
                //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

                $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
            }

            // Remove the demo link and the notice of integrated demo from the redux-framework plugin
            function remove_demo() {

                // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
                if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                    remove_filter( 'plugin_row_meta', array(
                        ReduxFrameworkPlugin::instance(),
                        'plugin_metalinks'
                    ), null, 2 );

                    // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                    remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
                }
            }

            public function setSections() {

                /**********************************************************************
                ***********************************************************************
                OVERALL
                **********************************************************************/
                $this->sections[] = array(
                    'title' => esc_html__('Overall', 'couponis') ,
                    'icon' => '',
                    'desc' => esc_html__('This is basic section where you can set up main settings for your website.', 'couponis'),
                    'fields' => array(
                        //Site Logo
                        array(
                            'id'        => 'site_logo',
                            'type'      => 'media',
                            'title'     => esc_html__('Site Logo', 'couponis') ,
                            'desc'      => esc_html__('Upload site logo', 'couponis')
                        ),

                        array(
                            'id'        => 'enable_sticky',
                            'type'      => 'select',
                            'options'   => array(
                                'yes'       => esc_html__( 'Yes', 'couponis' ),
                                'no'        => esc_html__( 'No', 'couponis' )
                            ),
                            'title'     => esc_html__('Sticky Menu', 'couponis'),
                            'desc'      => esc_html__('Enable or disable sticky menu', 'couponis'),
                            'default'   => 'yes'
                        ),
                        array(
                            'id' => 'direction',
                            'type' => 'select',
                            'options' => array(
                                'ltr' => __('LTR', 'couponis'),
                                'rtl' => __('RTL', 'couponis')
                            ),
                            'title' => __('Choose Site Content Direction', 'couponis'),
                            'desc' => __('Choose overall website text direction which can be RTL (right to left) or LTR (left to right).', 'couponis'),
                            'default' => 'ltr'
                        ),
                        array(
                            'id'        => 'custom_css',
                            'type'      => 'ace_editor',
                            'mode'      => 'css',
                            'title'     => esc_html__('Custom CSS', 'couponis'),
                            'desc'      => esc_html__('Here you can add custom CSS.', 'couponis'),
                        ),
                        array(
                            'id'        => 'google_ads',
                            'type'      => 'textarea',
                            'title'     => esc_html__('Google Ads Code', 'couponis'),
                            'desc'      => esc_html__('Input your google ads code. This can be used in header ( see option bellow ) and it will also be available as widget in Appearance -> Widgets', 'couponis'),
                        ),
                        array(
                            'id'        => 'google_ads_header',
                            'type'      => 'select',
                            'options'   => array(
                                'yes'       => esc_html__( 'Yes', 'couponis' ),
                                'no'        => esc_html__( 'No', 'couponis' )
                            ),
                            'title'     => esc_html__('Display Ads In Header', 'couponis'),
                            'desc'      => esc_html__('Enable or disable display of ads in header', 'couponis'),
                            'default'   => 'no'
                        ),
                        array(
                            'id'        => 'enable_share',
                            'type'      => 'select',
                            'options'   => array(
                                'yes'       => esc_html__( 'Yes', 'couponis' ),
                                'no'        => esc_html__( 'No', 'couponis' )
                            ),
                            'title'     => esc_html__('Enable Share', 'couponis'),
                            'desc'      => esc_html__('Enable or disable share', 'couponis'),
                            'default'   => 'yes'
                        ),
                    )
                );

                /**********************************************************************
                ***********************************************************************
                COUPONS
                **********************************************************************/
                $this->sections[] = array(
                    'title' => esc_html__('Coupons', 'couponis') ,
                    'icon' => '',
                    'desc' => esc_html__('Coupon settings.', 'couponis'),
                    'fields' => array(
                        array(
                            'id'        => 'coupon_listing_style',
                            'type'      => 'select',
                            'options'   => array(
                                'list'      => esc_html__( 'List', 'couponis' ),
                                'grid'      => esc_html__( 'Grid', 'couponis' ),
                            ),
                            'title'     => esc_html__('Coupon Listing Type', 'couponis') ,
                            'desc'      => esc_html__('Select style of the coupon boxes in listings', 'couponis'),
                            'default'   => 'list'
                        ),
                        array(
                            'id'        => 'coupon_listing_image',
                            'type'      => 'select',
                            'options'   => array(
                                'store'         => esc_html__( 'Store Logo', 'couponis' ),
                                'featured'      => esc_html__( 'Featured Logo', 'couponis' ),
                            ),
                            'title'     => esc_html__('Coupon Listing Image', 'couponis') ,
                            'desc'      => esc_html__('Select which image to show on coupon listing ( If featured is selected and there is no any store logo will be used )', 'couponis'),
                            'default'   => 'store'
                        ),
                        array(
                            'id'        => 'coupons_per_page',
                            'type'      => 'text',
                            'title'     => esc_html__('Coupons Per Page', 'couponis') ,
                            'desc'      => esc_html__('Input how mny coupons per page to display on lsiting', 'couponis'),
                            'default'   => '10'
                        ),
                        array(
                            'id'        => 'expired_stamp',
                            'type'      => 'media',
                            'title'     => esc_html__('Expired Image', 'couponis') ,
                            'desc'      => esc_html__('Select iamge which will be added as expired stamp over coupon box once it is expired', 'couponis'),
                            'default'   => ''
                        ),
                        array(
                            'id'        => 'list_empt_cats_stores',
                            'type'      => 'select',
                            'options'   => array(
                                'yes' => esc_html__( 'Hide', 'couponis' ),
                                'no' => esc_html__( 'Show', 'couponis' ),
                            ),
                            'title'     => esc_html__('Hide Empty Stores & Categories', 'couponis') ,
                            'desc'      => esc_html__('Enable or disable display of empty categories and stores on their listing', 'couponis'),
                            'default'   => 'yes'
                        ),
                        array(
                            'id'        => 'single_coupon_sidebar_pos',
                            'type'      => 'select',
                            'options'   => array(
                                'right'      => esc_html__( 'Right Sidebar', 'couponis' ),
                                'left'       => esc_html__( 'Left Sidebar', 'couponis' ),
                            ),
                            'title'     => esc_html__('Coupon Single Sidebar Position', 'couponis') ,
                            'desc'      => esc_html__('Select location of the sidebar on coupon single pages', 'couponis'),
                            'default'   => 'right'
                        ),
                        array(
                            'id'        => 'single_coupon_similar',
                            'type'      => 'select',
                            'options'   => array(
                                'yes'      => esc_html__( 'Yes', 'couponis' ),
                                'no'       => esc_html__( 'No', 'couponis' ),
                            ),
                            'title'     => esc_html__('Show Similar', 'couponis') ,
                            'desc'      => esc_html__('Show or hide similar coupons on single coupon pages', 'couponis'),
                            'default'   => 'yes'
                        ),
                        array(
                            'id'        => 'time_on_badge',
                            'type'      => 'select',
                            'options'   => array(
                                'yes'      => esc_html__( 'Yes', 'couponis' ),
                                'no'       => esc_html__( 'No', 'couponis' ),
                            ),
                            'title'     => esc_html__('Show Time On Boxes', 'couponis') ,
                            'desc'      => esc_html__('Show or hide time of expiration on coupon boxes', 'couponis'),
                            'default'   => 'no'
                        ),                        
                        array(
                            'id'        => 'single_coupon_similar_number',
                            'type'      => 'text',
                            'title'     => esc_html__('Number Of Similar', 'couponis') ,
                            'desc'      => esc_html__('How many similar coupons to display', 'couponis'),
                            'default'   => '5'
                        ),
                        array(
                            'id'        => 'delete_coupon_images',
                            'type'      => 'select',
                            'options'   => array(
                                'no'      => esc_html__( 'No', 'couponis' ),
                                'yes'       => esc_html__( 'Yes', 'couponis' ),
                            ),
                            'title'     => esc_html__('Delete Coupon Images', 'couponis') ,
                            'desc'      => esc_html__('On coupon delete delete also featured and printable images ( If multiple coupons use same images it will make images unavailable to other coupons if this options is set to Yes )', 'couponis'),
                            'default'   => 'no'
                        ),
                        array(
                            'id'        => 'delete_store_images',
                            'type'      => 'select',
                            'options'   => array(
                                'no'      => esc_html__( 'No', 'couponis' ),
                                'yes'       => esc_html__( 'Yes', 'couponis' ),
                            ),
                            'title'     => esc_html__('Delete Store Images', 'couponis') ,
                            'desc'      => esc_html__('On store delete delete also featured and printable images. ( If multiple stores use same image it will make image unavailable to other stores if this options is set to Yes )', 'couponis'),
                            'default'   => 'no'
                        ),
                        array(
                            'id'        => 'can_submit',
                            'type'      => 'select',
                            'options'   => array(
                                'yes'       => esc_html__( 'Yes', 'couponis' ),
                                'no'        => esc_html__( 'No', 'couponis' ),
                            ),
                            'title'     => esc_html__('Can Users Submit Coupons?', 'couponis') ,
                            'desc'      => esc_html__('Enable or disable submitting of coupons', 'couponis'),
                            'default'   => 'yes'
                        ),
                        array(
                            'id'        => 'coupon_types',
                            'type'      => 'select',
                            'multi'     => true,
                            'options'   => array(
                                '1' => esc_html__( 'Online Codes', 'couponis' ),
                                '2' => esc_html__( 'Store Codes', 'couponis' ),
                                '3' => esc_html__( 'Online Sales', 'couponis' ),
                            ),
                            'title'     => esc_html__('Coupon Types', 'couponis') ,
                            'desc'      => esc_html__('Select which coupon types to display or leave empty to display them all', 'couponis'),
                        ),
                        array(
                            'id'        => 'ajax_taxonomy',
                            'type'      => 'select',
                            'options'   => array(
                                'yes'   => esc_html__( 'Yes', 'couponis' ),
                                'no'    => esc_html__( 'No', 'couponis' ),
                            ),
                            'title'     => esc_html__('AJAX Taxonomy', 'couponis') ,
                            'desc'      => esc_html__('Enable or disable ajax category/store selection', 'couponis'),
                            'default'   => 'no'
                        ),
                        array(
                            'id'        => 'use_coupon_single',
                            'type'      => 'select',
                            'options'   => array(
                                'yes'   => esc_html__( 'Yes', 'couponis' ),
                                'no'    => esc_html__( 'No', 'couponis' ),
                            ),
                            'title'     => esc_html__('Coupon Single', 'couponis') ,
                            'desc'      => esc_html__('Enable or disable coupon single pages', 'couponis'),
                            'default'   => 'yes'
                        )
                    )
                );

                $this->sections[] = array(
                    'title' => esc_html__('Slugs', 'couponis') ,
                    'icon' => '',
                    'subsection' => true,
                    'desc' => esc_html__('Change slugs. After changes done here you must go Settings -> Permalinks and rese them ( just click Save Changes button ).', 'couponis'),
                    'fields' => array(
                        array(
                            'id' => 'trans_coupon',
                            'type' => 'text',
                            'title' => esc_html__('Coupon Slug', 'couponis') ,
                            'desc' => esc_html__('Input slug you want to use for the coupon single page.', 'couponis'),
                            'default' => 'coupon'
                        ),
                        array(
                            'id' => 'trans_coupon-category',
                            'type' => 'text',
                            'title' => esc_html__('Coupons Category Slug', 'couponis') ,
                            'desc' => esc_html__('Input slug you want to use for the coupon categories.', 'couponis'),
                            'default' => 'coupon-category'
                        ),
                        array(
                            'id' => 'trans_coupon-store',
                            'type' => 'text',
                            'title' => esc_html__('Coupons Stores Slug', 'couponis') ,
                            'desc' => esc_html__('Input slug you want to use for the coupon stores.', 'couponis'),
                            'default' => 'coupon-store'
                        ),
                    )
                );           

                $this->sections[] = array(
                    'title' => esc_html__('Email', 'couponis') ,
                    'icon' => '',
                    'desc' => esc_html__('Email settings', 'couponis'),
                    'fields' => array(
                        array(
                            'id'        => 'sender_name',
                            'type'      => 'text',
                            'title'     => esc_html__('Sender Name', 'couponis') ,
                            'desc'      => esc_html__('Set sender name of emails for register, recover,...', 'couponis'),
                        ),
                        array(
                            'id'        => 'sender_email',
                            'type'      => 'text',
                            'title'     => esc_html__('Sender Email', 'couponis') ,
                            'desc'      => esc_html__('Set sender email of emails for register, recover,...', 'couponis'),
                        ),                        
                    )
                );

                /**********************************************************************
                ***********************************************************************
                SUBSCRIPTION
                **********************************************************************/
                
                $this->sections[] = array(
                    'title'     => esc_html__('Subscription', 'couponis') ,
                    'icon'      => '',
                    'desc'      => esc_html__('Set up subscription API key and list ID.', 'couponis'),
                    'fields'    => array(
                        // Mail Chimp API
                        array(
                            'id'        => 'mail_chimp_api',
                            'type'      => 'text',
                            'title'     => esc_html__('API Key', 'couponis') ,
                            'desc'      => esc_html__('Type your mail chimp api key.', 'couponis')
                        ) , 
                        // Mail Chimp List ID
                        array(
                            'id'        => 'mail_chimp_list_id',
                            'type'      => 'text',
                            'title'     => esc_html__('List ID', 'couponis') ,
                            'desc'      => esc_html__('Type here ID of the list on which users will subscribe.', 'couponis')
                        ) ,
                    )
                );

                /***********************************************************************
                Appearance
                **********************************************************************/
                $this->sections[] = array(
                    'title'     => esc_html__('Appearance', 'couponis') ,
                    'icon'      => '',
                    'desc'      => esc_html__('Set up the looks.', 'couponis'),
                    'fields'    => array(
                        array(
                            'id'            => 'main_color',
                            'type'          => 'color',
                            'title'         => esc_html__('Select Main Color', 'couponis'),
                            'desc'          => esc_html__('Select main color of the site.', 'couponis'),
                            'transparent'   => false,
                            'default'       => '#1ab1b7'
                        ),
                        array(
                            'id'            => 'main_color_font',
                            'type'          => 'color',
                            'title'         => esc_html__('Select Font Main Color', 'couponis'),
                            'desc'          => esc_html__('Select font color for the elements which have main collor as their background.', 'couponis'),
                            'transparent'   => false,
                            'default'       => '#fff'
                        ),
                    )
                );

                $this->sections[] = array(
                    'title'         => esc_html__('Coupons', 'couponis') ,
                    'icon'          => '',
                    'subsection'    => true,
                    'desc'          => esc_html__('Set up the looks.', 'couponis'),
                    'fields'        => array(
                        array(
                            'id'            => 'sale_badge_bg',
                            'type'          => 'color',
                            'title'         => esc_html__('Sale Badge Background Color', 'couponis'),
                            'desc'          => esc_html__('Select background color of the sale badges.', 'couponis'),
                            'transparent'   => false,
                            'default'       => '#48c78c'
                        ),
                        array(
                            'id'            => 'sale_badge_font',
                            'type'          => 'color',
                            'title'         => esc_html__('Sale Badge Font Color', 'couponis'),
                            'desc'          => esc_html__('Select font color of the sale badges.', 'couponis'),
                            'transparent'   => false,
                            'default'       => '#fff'
                        ),
                        array(
                            'id'            => 'exclusive_badge_bg',
                            'type'          => 'color',
                            'title'         => esc_html__('Exclusive Badge Background Color', 'couponis'),
                            'desc'          => esc_html__('Select background color of the sale badges.', 'couponis'),
                            'transparent'   => false,
                            'default'       => '#1ab1b7'
                        ),
                        array(
                            'id'            => 'exclusive_badge_font',
                            'type'          => 'color',
                            'title'         => esc_html__('Exclusive Badge Font Color', 'couponis'),
                            'desc'          => esc_html__('Select font color of the sale badges.', 'couponis'),
                            'transparent'   => false,
                            'default'       => '#fff'
                        ),
                        array(
                            'id'            => 'online_badge_bg',
                            'type'          => 'color',
                            'title'         => esc_html__('Online Badge Background Color', 'couponis'),
                            'desc'          => esc_html__('Select background color of the sale badges.', 'couponis'),
                            'transparent'   => false,
                            'default'       => '#c2c748'
                        ),
                        array(
                            'id'            => 'online_badge_font',
                            'type'          => 'color',
                            'title'         => esc_html__('Online Badge Font Color', 'couponis'),
                            'desc'          => esc_html__('Select font color of the sale badges.', 'couponis'),
                            'transparent'   => false,
                            'default'       => '#fff'
                        ),
                        array(
                            'id'            => 'in_store_badge_bg',
                            'type'          => 'color',
                            'title'         => esc_html__('In Store Badge Background Color', 'couponis'),
                            'desc'          => esc_html__('Select background color of the sale badges.', 'couponis'),
                            'transparent'   => false,
                            'default'       => '#5f93ce'
                        ),
                        array(
                            'id'            => 'in_store_badge_font',
                            'type'          => 'color',
                            'title'         => esc_html__('In Store Badge Font Color', 'couponis'),
                            'desc'          => esc_html__('Select font color of the sale badges.', 'couponis'),
                            'transparent'   => false,
                            'default'       => '#fff'
                        ),
                        array(
                            'id'            => 'action_btn_bg',
                            'type'          => 'color',
                            'title'         => esc_html__('Action Button Background Color', 'couponis'),
                            'desc'          => esc_html__('Select background color of the action button.', 'couponis'),
                            'transparent'   => false,
                            'default'       => '#FFA619'
                        ),
                        array(
                            'id'            => 'action_btn_font',
                            'type'          => 'color',
                            'title'         => esc_html__('Action Badge Font Color', 'couponis'),
                            'desc'          => esc_html__('Select font color of the action button.', 'couponis'),
                            'transparent'   => false,
                            'default'       => '#fff'
                        ),
                    )
                );

                $this->sections[] = array(
                    'title'         => esc_html__('Header', 'couponis') ,
                    'icon'          => '',
                    'subsection'    => true,
                    'desc'          => esc_html__('Set up the looks.', 'couponis'),
                    'fields'        => array(
                        array(
                            'id'            => 'header_bg_color',
                            'type'          => 'color',
                            'title'         => esc_html__('Header Background Color', 'couponis'),
                            'desc'          => esc_html__('Select background color of the header section.', 'couponis'),
                            'default'       => '#202020',
                            'transparent'   => false,
                        ),
                        array(
                            'id'            => 'header_font_color',
                            'type'          => 'color',
                            'title'         => esc_html__('Header Font Color', 'couponis'),
                            'desc'          => esc_html__('Select font color of the header categories.', 'couponis'),
                            'transparent'   => false,
                            'default'       => '#bbb'
                        ),
                        array(
                            'id'            => 'header_font_color_active',
                            'type'          => 'color',
                            'title'         => esc_html__('Header Font Color Active', 'couponis'),
                            'desc'          => esc_html__('Select font color of the header categories on hover.', 'couponis'),
                            'transparent'   => false,
                            'default'       => '#eee'
                        ),
                    )
                );

                $this->sections[] = array(
                    'title' => esc_html__('Typography', 'couponis') ,
                    'icon' => '',
                    'subsection' => true,
                    'desc' => esc_html__('Set up the looks.', 'couponis'),
                    'fields' => array(
                        array(
                            'id'            => 'navigation_font',
                            'type'          => 'select',
                            'title'         => esc_html__('Navigation Font', 'couponis'),
                            'desc'          => esc_html__('Select navigation font.', 'couponis'),
                            'transparent'   => false,
                            'options'       => couponis_all_google_fonts(),
                            'default'       => 'Montserrat'
                        ),
                        array(
                            'id'            => 'navigation_font_weight',
                            'type'          => 'text',
                            'title'         => esc_html__('Navigation Font Weight', 'couponis'),
                            'desc'          => esc_html__('Input weight of the font ( 300, 400, 500, 600, 700, 900 )', 'couponis'),
                            'default'       => '600'
                        ),
                        array(
                            'id'            => 'navigation_font_size',
                            'type'          => 'text',
                            'title'         => esc_html__('Navigation Font Size', 'couponis'),
                            'desc'          => esc_html__('Input font size for the navigation text.', 'couponis'),
                            'default'       => '14px'
                        ),
                        array(
                            'id'            => 'text_font',
                            'type'          => 'select',
                            'title'         => esc_html__('Text Font', 'couponis'),
                            'desc'          => esc_html__('Select font for the regular text.', 'couponis'),
                            'options'       => couponis_all_google_fonts(),
                            'default'       => 'Open Sans'
                        ),
                        array(
                            'id'            => 'text_font_weight',
                            'type'          => 'text',
                            'title'         => esc_html__('Text Font Weight', 'couponis'),
                            'desc'          => esc_html__('Input weight of the font ( 300, 400, 500, 600, 700, 900 )', 'couponis'),
                            'default'       => '400'
                        ),
                        array(
                            'id'            => 'text_font_size',
                            'type'          => 'text',
                            'title'         => esc_html__('Text Font Size', 'couponis'),
                            'desc'          => esc_html__('Input font size for the regular text.', 'couponis'),
                            'default'       => '14px'
                        ),
                        array(
                            'id'            => 'text_font_line_height',
                            'type'          => 'text',
                            'title'         => esc_html__('Text Font Line Height', 'couponis'),
                            'desc'          => esc_html__('Input font line height for the regular text.', 'couponis'),
                            'default'       => '1.7'
                        ),
                        array(
                            'id'            => 'title_font',
                            'type'          => 'select',
                            'title'         => esc_html__('Title Font', 'couponis'),
                            'desc'          => esc_html__('Select font for the title text.', 'couponis'),
                            'options'       => couponis_all_google_fonts(),
                            'default'       => 'Montserrat'
                        ),
                        array(
                            'id'            => 'title_font_weight',
                            'type'          => 'text',
                            'title'         => esc_html__('Title Font Weight', 'couponis'),
                            'desc'          => esc_html__('Input weight of the font ( 300, 400, 500, 600, 700, 900 )', 'couponis'),
                            'default'       => '600'
                        ),
                        array(
                            'id'            => 'h1_font_size',
                            'type'          => 'text',
                            'title'         => esc_html__('Heading 1 Font Size', 'couponis'),
                            'desc'          => esc_html__('Input font size for the heading 1.', 'couponis'),
                            'default'       => '2.6179em'
                        ),
                        array(
                            'id'            => 'h1_font_line_height',
                            'type'          => 'text',
                            'title'         => esc_html__('Heading 1 Font Line Height', 'couponis'),
                            'desc'          => esc_html__('Input font line height for the heading 1.', 'couponis'),
                            'default'       => '1.4'
                        ),
                        array(
                            'id'            => 'h2_font_size',
                            'type'          => 'text',
                            'title'         => esc_html__('Heading 2 Font Size', 'couponis'),
                            'desc'          => esc_html__('Input font size for the heading 2.', 'couponis'),
                            'default'       => '2.0581em'
                        ),
                        array(
                            'id'            => 'h2_font_line_height',
                            'type'          => 'text',
                            'title'         => esc_html__('Heading 2 Font Line Height', 'couponis'),
                            'desc'          => esc_html__('Input font line height for the heading 2.', 'couponis'),
                            'default'       => '1.4'
                        ),
                        array(
                            'id'            => 'h3_font_size',
                            'type'          => 'text',
                            'title'         => esc_html__('Heading 3 Font Size', 'couponis'),
                            'desc'          => esc_html__('Input font size for the heading 3.', 'couponis'),
                            'default'       => '1.618em'
                        ),
                        array(
                            'id'            => 'h3_font_line_height',
                            'type'          => 'text',
                            'title'         => esc_html__('Heading 3 Font Line Height', 'couponis'),
                            'desc'          => esc_html__('Input font line height for the heading 3.', 'couponis'),
                            'default'       => '1.4'
                        ),
                        array(
                            'id'            => 'h4_font_size',
                            'type'          => 'text',
                            'title'         => esc_html__('Heading 4 Font Size', 'couponis'),
                            'desc'          => esc_html__('Input font size for the heading 4.', 'couponis'),
                            'default'       => '1.272em'
                        ),
                        array(
                            'id'            => 'h4_font_line_height',
                            'type'          => 'text',
                            'title'         => esc_html__('Heading 4 Font Line Height', 'couponis'),
                            'desc'          => esc_html__('Input font line height for the heading 4.', 'couponis'),
                            'default'       => '1.4'
                        ),
                        array(
                            'id'            => 'h5_font_size',
                            'type'          => 'text',
                            'title'         => esc_html__('Heading 5 Font Size', 'couponis'),
                            'desc'          => esc_html__('Input font size for the heading 5.', 'couponis'),
                            'default'       => '1em'
                        ),
                        array(
                            'id'            => 'h5_font_line_height',
                            'type'          => 'text',
                            'title'         => esc_html__('Heading 5 Font Line Height', 'couponis'),
                            'desc'          => esc_html__('Input font line height for the heading 5.', 'couponis'),
                            'default'       => '1.4'
                        ),
                        array(
                            'id'            => 'h6_font_size',
                            'type'          => 'text',
                            'title'         => esc_html__('Heading 6 Font Size', 'couponis'),
                            'desc'          => esc_html__('Input font size for the heading 6.', 'couponis'),
                            'default'       => '0.7862em'
                        ),
                        array(
                            'id'            => 'h6_font_line_height',
                            'type'          => 'text',
                            'title'         => esc_html__('Heading 6 Font Line Height', 'couponis'),
                            'desc'          => esc_html__('Input font line height for the heading 6.', 'couponis'),
                            'default'       => '1.4'
                        ),
                        array(
                            'id'            => 'title_color',
                            'type'          => 'color',
                            'title'         => esc_html__('Title Color', 'couponis'),
                            'desc'          => esc_html__('Select font color for the titles.', 'couponis'),
                            'transparent'   => false,
                            'default'       => '#202020'
                        ),
                        array(
                            'id'            => 'link_color',
                            'type'          => 'color',
                            'title'         => esc_html__('Link Color', 'couponis'),
                            'desc'          => esc_html__('Select link color.', 'couponis'),
                            'transparent'   => false,
                            'default'       => '#272727'
                        ),
                        array(
                            'id'            => 'text_color',
                            'type'          => 'color',
                            'title'         => esc_html__('Text Color', 'couponis'),
                            'desc'          => esc_html__('Select font color for the text.', 'couponis'),
                            'transparent'   => false,
                            'default'       => '#484848'
                        ),                        
                    )
                );

                $this->sections[] = array(
                    'title' => esc_html__('Copyrights', 'couponis') ,
                    'icon' => '',
                    'subsection' => true,
                    'desc' => esc_html__('Set up the looks.', 'couponis'),
                    'fields' => array(
                        array(
                            'id' => 'copyrights_bg_color',
                            'type' => 'color',
                            'title' => esc_html__('Background Color', 'couponis'),
                            'desc' => esc_html__('Select background color for the copyrights section.', 'couponis'),
                            'transparent' => false,
                            'default' => '#202020'
                        ),
                        array(
                            'id' => 'copyrights_font_color',
                            'type' => 'color',
                            'title' => esc_html__('Font Color', 'couponis'),
                            'desc' => esc_html__('Select font color for the copyrights section.', 'couponis'),
                            'transparent' => false,
                            'default' => '#bbb'
                        ),
                        array(
                            'id' => 'copyrights_font_color_active',
                            'type' => 'color',
                            'title' => esc_html__('Link Font Color On Hover', 'couponis'),
                            'desc' => esc_html__('Select font color for the copyrights links.', 'couponis'),
                            'transparent' => false,
                            'default' => '#1ab1b7'
                        ),
                    )
                );

                /***********************************************************************
                CONTACT PAGE SETTINGS
                **********************************************************************/
                
                $this->sections[] = array(
                    'title' => esc_html__('Contact Page', 'couponis') ,
                    'icon' => '',
                    'desc' => esc_html__('Contact page settings.', 'couponis'),
                    'fields' => array(
                        array(
                            'id' => 'contact_form_email',
                            'type' => 'text',
                            'title' => esc_html__('Email', 'couponis') ,
                            'desc' => esc_html__('Input email where the messages should arive.', 'couponis'),
                        ),
                        array(
                            'id' => 'markers',
                            'type' => 'multi_text',
                            'title' => esc_html__('Markers', 'couponis') ,
                            'desc' => esc_html__('Input markers for contact page in form LATITUDE,LONGITUDE.', 'couponis'),
                        ),
                        array(
                            'id' => 'marker_icon',
                            'type' => 'media',
                            'title' => esc_html__('Marker Icon', 'couponis') ,
                            'desc' => esc_html__('Select marker icon for the contact page.', 'couponis'),
                        ),
                        array(
                            'id' => 'markers_max_zoom',
                            'type' => 'text',
                            'title' => esc_html__('Markers Max Zoom', 'couponis') ,
                            'desc' => esc_html__('Markers max zoom 0 - 19.', 'couponis'),
                        ),
                        array(
                            'id' => 'google_api_key',
                            'type' => 'text',
                            'title' => esc_html__('Google API Key', 'couponis') ,
                            'desc' => esc_html__('Input google API key', 'couponis'),
                        ),
                        array(
                            'id' => 'agreement_text',
                            'type' => 'editor',
                            'args'  => array(
                                'media_buttons' => false
                            ),
                            'title' => esc_html__('Agreement Text', 'couponis') ,
                            'desc' => esc_html__('Input text of the agreement', 'couponis'),
                        ),
                    )
                );
                

                /***********************************************************************
                COPYRIGHTS
                **********************************************************************/

                $this->sections[] = array(
                    'title' => esc_html__('Footer', 'couponis') ,
                    'icon' => '',
                    'desc' => esc_html__('Footer settings.', 'couponis'),
                    'fields' => array(
                        array(
                            'id'        => 'subscribe',
                            'type'      => 'select',
                            'options'   => array(
                                'no'    => esc_html__( 'No', 'couponis' ),
                                'yes'    => esc_html__( 'Yes', 'couponis' ),
                            ),
                            'title'     => esc_html__('Show Subscribe', 'couponis') ,
                            'desc'      => esc_html__('Show or hide subscribe section in footer.', 'couponis'),
                            'default'   => 'no'
                        ),
                        array(
                            'id' => 'ft_facebook',
                            'type' => 'text',
                            'title' => esc_html__('Facebook', 'couponis') ,
                            'desc' => esc_html__('Input link to your facebook page.', 'couponis'),
                        ),
                        array(
                            'id' => 'ft_twitter',
                            'type' => 'text',
                            'title' => esc_html__('Twitter', 'couponis') ,
                            'desc' => esc_html__('Input link to your twitter page.', 'couponis'),
                        ),
                        array(
                            'id' => 'ft_google',
                            'type' => 'text',
                            'title' => esc_html__('Google', 'couponis') ,
                            'desc' => esc_html__('Input link to your google page.', 'couponis'),
                        ),
                        array(
                            'id' => 'ft_youtube',
                            'type' => 'text',
                            'title' => esc_html__('YouTube', 'couponis') ,
                            'desc' => esc_html__('Input link to your youtube page.', 'couponis'),
                        ),
                        array(
                            'id' => 'ft_linkedin',
                            'type' => 'text',
                            'title' => esc_html__('Linkedin', 'couponis') ,
                            'desc' => esc_html__('Input link to your linkedin page.', 'couponis'),
                        ),
                        array(
                            'id' => 'ft_tumblr',
                            'type' => 'text',
                            'title' => esc_html__('Tumblr', 'couponis') ,
                            'desc' => esc_html__('Input link to your tumbl page.', 'couponis'),
                        ),
                        array(
                            'id' => 'ft_pinterest',
                            'type' => 'text',
                            'title' => esc_html__('Pinterest', 'couponis') ,
                            'desc' => esc_html__('Input link to your pinterest page.', 'couponis'),
                        ),
                        array(
                            'id' => 'ft_instagram',
                            'type' => 'text',
                            'title' => esc_html__('Instagram', 'couponis') ,
                            'desc' => esc_html__('Input link to your instagram page.', 'couponis'),
                        ),
                        array(
                            'id' => 'copyrights',
                            'type' => 'text',
                            'title' => esc_html__('Copyrights', 'couponis') ,
                            'desc' => esc_html__('Input copyrights which will be visible at the bottom of the page.', 'couponis'),
                        ),
                    )
                );                

            }

            /**
             * All the possible arguments for Redux.
             * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
             * */
            public function setArguments() {

                $theme = wp_get_theme(); // For use with some settings. Not necessary.

                $this->args = array(
                    // TYPICAL -> Change these values as you need/desire
                    'opt_name'             => 'couponis_options',
                    // This is where your data is stored in the database and also becomes your global variable name.
                    'display_name'         => $theme->get( 'Name' ),
                    // Name that appears at the top of your panel
                    'display_version'      => $theme->get( 'Version' ),
                    // Version that appears at the top of your panel
                    'menu_type'            => 'menu',
                    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                    'allow_sub_menu'       => true,
                    // Show the sections below the admin menu item or not
                    'menu_title'           => esc_html__( 'Couponis WP', 'couponis' ),
                    'page_title'           => esc_html__( 'Couponis WP', 'couponis' ),
                    // You will need to generate a Google API key to use this feature.
                    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                    'google_api_key'       => '',
                    // Set it you want google fonts to update weekly. A google_api_key value is required.
                    'google_update_weekly' => false,
                    // Must be defined to add google fonts to the typography module
                    'async_typography'     => true,
                    // Use a asynchronous font on the front end or font string
                    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                    'admin_bar'            => true,
                    // Show the panel pages on the admin bar
                    'admin_bar_icon'     => 'dashicons-portfolio',
                    // Choose an icon for the admin bar menu
                    'admin_bar_priority' => 50,
                    // Choose an priority for the admin bar menu
                    'global_variable'      => '',
                    // Set a different name for your global variable other than the opt_name
                    'dev_mode'             => false,
                    // Show the time the page took to load, etc
                    'update_notice'        => true,
                    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                    'customizer'           => true,
                    // Enable basic customizer support
                    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                    // OPTIONAL -> Give you extra features
                    'page_priority'        => null,
                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                    'page_parent'          => 'themes.php',
                    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                    'page_permissions'     => 'manage_options',
                    // Specify a custom URL to an icon
                    'last_tab'             => '',
                    // Force your panel to always open to a specific tab (by id)
                    'page_icon'            => 'icon-themes',
                    // Icon displayed in the admin panel next to your menu_title
                    'page_slug'            => '_options',
                    // Page slug used to denote the panel
                    'save_defaults'        => true,
                    // On load save the defaults to DB before user clicks save or not
                    'default_show'         => false,
                    // If true, shows the default value next to each field that is not the default value.
                    'default_mark'         => '',
                    // What to print by the field's title if the value shown is default. Suggested: *
                    'show_import_export'   => true,
                    // Shows the Import/Export panel when not used as a field.

                    // CAREFUL -> These options are for advanced use only
                    'transient_time'       => 60 * MINUTE_IN_SECONDS,
                    'output'               => true,
                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                    'output_tag'           => true,
                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                    'database'             => '',
                    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                    'system_info'          => false,
                    // REMOVE

                    // HINTS
                    'hints'                => array(
                        'icon'          => 'icon-question-sign',
                        'icon_position' => 'right',
                        'icon_color'    => 'lightgray',
                        'icon_size'     => 'normal',
                        'tip_style'     => array(
                            'color'   => 'light',
                            'shadow'  => true,
                            'rounded' => false,
                            'style'   => '',
                        ),
                        'tip_position'  => array(
                            'my' => 'top left',
                            'at' => 'bottom right',
                        ),
                        'tip_effect'    => array(
                            'show' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'mouseover',
                            ),
                            'hide' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'click mouseleave',
                            ),
                        ),
                    )
                );


            }

        }

        global $couponis_opts;
        $couponis_opts = new Couponis_Options();
        } else {
        echo "The class named Couponis_Options has already been called. <strong>Developers, you need to prefix this class with your company name or you'll run into problems!</strong>";
    }