<?php

if( !function_exists('couponis_remove_default_elements') ){
function couponis_remove_default_elements( $atts, $base ){
    if( in_array( 
    		$base, 
    		array( 
    			'kc_box', 
    			'kc_raw_code', 
    			'kc_icon', 
    			'kc_google_maps', 
    			'kc_flip_box', 
    			'kc_post_type_list', 
    			'kc_carousel_post', 
    			'kc_testimonial', 
    			'kc_team',
    			'kc_pricing',
    			'kc_dropcaps',
    			'kc_image_fadein',
    			'kc_image_hover_effects',
    			'kc_call_to_action',
    			'kc_tooltip',
    			'kc_multi_icons',
    			'kc_blog_posts',
    			'kc_nested',
    			'kc_title',
    			'kc_twitter_feed',
    			'kc_instagram_feed',
    			'kc_fb_recent_post',
    			'kc_video_play',
    			'kc_counter_box',
    			'kc_carousel_images',
    			'kc_image_gallery',
    			'kc_coundown_timer',
    			'kc_divider',
    			'kc_box_alert',
    			'kc_feature_box',
    			'kc_creative_button',
    			'kc_pie_chart',
    			'kc_accordion',
    			'kc_button',
    			'kc_progress_bars',
    		) 
    	) )
    {
        return null;
    }

    return $atts;
}
add_filter('kc_add_map', 'couponis_remove_default_elements', 1 , 2 );
}

if( !function_exists('couponis_start_shortcodes') ){
function couponis_start_shortcodes() {
	if ( function_exists( 'kc_add_map' ) ){ 
		global $kc;

		$shortcode_template = get_theme_file_path( 'includes/kingcomposer/' );
	    $kc->set_template_path( $shortcode_template );
		
	    kc_add_map(
	        array(
	            'kc_featured_coupons' => array(
	                'name' 			=> esc_html__( 'Featured Coupons', 'couponis' ),
	                'description' 	=> esc_html__('Select which coupons to display in slider', 'couponis'),
	                'icon' 			=> 'sl-paper-plane',
	                'category' 		=> 'Content',
	                'params' 		=> array(
	                    array(
	                        'name' 			=> 'coupon_source',
	                        'label' 		=> esc_html__( 'Source', 'couponis' ),
	                        'type' 			=> 'select',
	                        'options'		=> array(
	                        	'selected'			=> esc_html__( 'Selected Coupons', 'couponis' ),
	                        	'filtered'			=> esc_html__( 'Filtered', 'couponis' ),
	                        ),	                        
	                        'description'	=> esc_html__( 'Select source of your featured coupons', 'couponis' )
	                    ),	                	
	                    array(
	                        'name' 			=> 'coupon_ids',
	                        'label' 		=> esc_html__( 'Coupons', 'couponis' ),
	                        'relation' => array(
	                        	'parent'		=> 'coupon_source',
	                        	'show_when'		=> 'selected',
	                        ),
	                        'type' 			=> 'autocomplete',
	                        'options'		=> array(
	                        	'multiple'		=> true,
	                        	'post_type'		=> 'coupon'
	                        ),
	                        'description'	=> esc_html__( 'Select coupons you wish to display', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'coupon_categories',
	                        'label' 		=> esc_html__( 'Categories', 'couponis' ),
	                        'relation' => array(
	                        	'parent'		=> 'coupon_source',
	                        	'show_when'		=> 'filtered',
	                        ),
	                        'type' 			=> 'autocomplete',
	                        'options'		=> array(
	                        	'multiple'		=> true,
	                        	'taxonomy'		=> 'coupon-category'
	                        ),	                        
	                        'description'	=> esc_html__( 'Select categories you wish to display or leave empty to show all', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'coupon_stores',
	                        'label' 		=> esc_html__( 'Strores', 'couponis' ),
	                        'relation' => array(
	                        	'parent'		=> 'coupon_source',
	                        	'show_when'		=> 'filtered',
	                        ),
	                        'type' 			=> 'autocomplete',
	                        'options'		=> array(
	                        	'multiple'		=> true,
	                        	'taxonomy'		=> 'coupon-store'
	                        ),	                        
	                        'description'	=> esc_html__( 'Select stores to filter coupons', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'coupon_orderby',
	                        'label' 		=> esc_html__( 'Order By', 'couponis' ),
	                        'relation' => array(
	                        	'parent'		=> 'coupon_source',
	                        	'show_when'		=> 'filtered',
	                        ),
	                        'type' 			=> 'select',
	                        'options'		=> array(
	                        	'title'			=> esc_html__( 'Title', 'couponis' ),
	                        	'date'			=> esc_html__( 'Date', 'couponis' ),
	                        	'rand'			=> esc_html__( 'Random', 'couponis' ),
	                        ),	                        
	                        'description'	=> esc_html__( 'Select by which field to order coupons', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'coupon_order',
	                        'label' 		=> esc_html__( 'Order', 'couponis' ),
	                        'relation' => array(
	                        	'parent'		=> 'coupon_source',
	                        	'show_when'		=> 'filtered',
	                        ),
	                        'type' 			=> 'select',
	                        'options'		=> array(
	                        	'ASC'			=> esc_html__( 'Ascending', 'couponis' ),
	                        	'DESC'			=> esc_html__( 'Descending', 'couponis' ),
	                        ),	                        
	                        'description'	=> esc_html__( 'Select how to order coupons', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'coupon_type',
	                        'label' 		=> esc_html__( 'Coupon Type', 'couponis' ),
	                        'relation' => array(
	                        	'parent'		=> 'coupon_source',
	                        	'show_when'		=> 'filtered',
	                        ),
	                        'type' 			=> 'select',
	                        'options'		=> array(
	                        	''				=> esc_html__( 'All', 'couponis' ),
	                        	'1'				=> esc_html__( 'Online Codes', 'couponis' ),
	                        	'2'				=> esc_html__( 'In Store Code', 'couponis' ),
	                        	'3'				=> esc_html__( 'Online Sale', 'couponis' ),
	                        ),	                        
	                        'description'	=> esc_html__( 'Select type of coupo to show', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'coupon_number',
	                        'label' 		=> esc_html__( 'Number Of Coupons', 'couponis' ),
	                        'relation' => array(
	                        	'parent'		=> 'coupon_source',
	                        	'show_when'		=> 'filtered',
	                        ),
	                        'type' 			=> 'text',
	                        'description'	=> esc_html__( 'Input how many coupons to show. Default is 5', 'couponis' )
	                    ),
	                )
	            ),
	        )
	    );   

	    kc_add_map(
	        array(
	            'kc_categories_list' => array(
	                'name' 			=> esc_html__( 'Categories List', 'couponis' ),
	                'description' 	=> esc_html__('Display categories with their icons', 'couponis'),
	                'icon' 			=> 'sl-paper-plane',
	                'category' 		=> 'Content',
	                'params' 		=> array(
	                    array(
	                        'name' 			=> 'number',
	                        'label' 		=> esc_html__( 'Number Of Categories', 'couponis' ),
	                        'type' 			=> 'text',
	                        'description'	=> esc_html__( 'Input how many categories to show or leave empty', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'coupon_categories',
	                        'label' 		=> esc_html__( 'Categories', 'couponis' ),
	                        'type' 			=> 'autocomplete',
	                        'options'		=> array(
	                        	'multiple'		=> true,
	                        	'taxonomy'		=> 'coupon-category'
	                        ),	                        
	                        'description'	=> esc_html__( 'Select categories you wish to display or leave empty to show all', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'show_icons',
	                        'label' 		=> esc_html__( 'Show Icons', 'couponis' ),
	                        'type' 			=> 'select',
	                        'options'		=> array(
	                        	'yes'	=> esc_html__( 'Yes', 'couponis' ),
	                        	'no'	=> esc_html__( 'No', 'couponis' ),
	                        ),
	                        'description'	=> esc_html__( 'Show or hide category icons', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'show_count',
	                        'label' 		=> esc_html__( 'Show Count', 'couponis' ),
	                        'type' 			=> 'select',
	                        'options'		=> array(
	                        	'yes'	=> esc_html__( 'Yes', 'couponis' ),
	                        	'no'	=> esc_html__( 'No', 'couponis' ),
	                        ),
	                        'description'	=> esc_html__( 'Show or hide category count', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'hide_empty',
	                        'label' 		=> esc_html__( 'Hide Empty', 'couponis' ),
	                        'type' 			=> 'select',
	                        'options'		=> array(
	                        	'yes'	=> esc_html__( 'Yes', 'couponis' ),
	                        	'no'	=> esc_html__( 'No', 'couponis' ),
	                        ),
	                        'description'	=> esc_html__( 'Allow categories without coupons to be displayed', 'couponis' )
	                    ),
	                )
	            ),
	        )
	    );

	    kc_add_map(
	        array(
	            'kc_stores_carousel' => array(
	                'name' 			=> esc_html__( 'Carousel Stores', 'couponis' ),
	                'description' 	=> esc_html__('Display stores in carousel', 'couponis'),
	                'icon' 			=> 'sl-paper-plane',
	                'category' 		=> 'Content',
	                'params' 		=> array(
	                    array(
	                        'name' 			=> 'number',
	                        'label' 		=> esc_html__( 'Number Of Stores', 'couponis' ),
	                        'type' 			=> 'text',
	                        'description'	=> esc_html__( 'Input how many stores to show or leave empty', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'title',
	                        'label' 		=> esc_html__( 'Block Title', 'couponis' ),
	                        'type' 			=> 'text',
	                        'description'	=> esc_html__( 'Input title or leave empty to disable ( All Stores link will also be gone )', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'stores_carousel',
	                        'label' 		=> esc_html__( 'Stores', 'couponis' ),
	                        'type' 			=> 'autocomplete',
	                        'options'		=> array(
	                        	'multiple'		=> true,
	                        	'taxonomy'		=> 'coupon-store'
	                        ),	 
	                        'description'	=> esc_html__( 'Select stores you wish to display or leave empty to show all', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'visible_items',
	                        'label' 		=> esc_html__( 'Visible Items', 'couponis' ),
	                        'type'			=> 'number_slider',
	                        'value'			=> 6,
							'options' 		=> array(
								'min' 			=> 1,
								'max' 			=> 6,
								'show_input' 	=> true
							),
	                        'description'	=> esc_html__( 'Input how many stores to be visible', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'hide_empty',
	                        'label' 		=> esc_html__( 'Hide Empty', 'couponis' ),
	                        'type' 			=> 'select',
	                        'options'		=> array(
	                        	'yes'	=> esc_html__( 'Yes', 'couponis' ),
	                        	'no'	=> esc_html__( 'No', 'couponis' ),
	                        ),
	                        'description'	=> esc_html__( 'Allow stores without coupons to be displayed', 'couponis' )
	                    ),
	                )
	            ),
	        )
	    );

	    kc_add_map(
	        array(
	            'kc_stores_carousel_alt' => array(
	                'name' 			=> esc_html__( 'Carousel Stores Alt', 'couponis' ),
	                'description' 	=> esc_html__('Display stores in carousel', 'couponis'),
	                'icon' 			=> 'sl-paper-plane',
	                'category' 		=> 'Content',
	                'params' 		=> array(
	                    array(
	                        'name' 			=> 'number',
	                        'label' 		=> esc_html__( 'Number Of Stores', 'couponis' ),
	                        'type' 			=> 'text',
	                        'description'	=> esc_html__( 'Input how many stores to show or leave empty', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'title',
	                        'label' 		=> esc_html__( 'Block Title', 'couponis' ),
	                        'type' 			=> 'text',
	                        'description'	=> esc_html__( 'Input title or leave empty to disable ( All Stores link will also be gone )', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'stores_carousel',
	                        'label' 		=> esc_html__( 'Stores', 'couponis' ),
	                        'type' 			=> 'autocomplete',
	                        'options'		=> array(
	                        	'multiple'		=> true,
	                        	'taxonomy'		=> 'coupon-store'
	                        ),	 
	                        'description'	=> esc_html__( 'Select stores you wish to display or leave empty to show all', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'visible_items',
	                        'label' 		=> esc_html__( 'Visible Items', 'couponis' ),
	                        'type'			=> 'number_slider',
	                        'value'			=> 6,
							'options' 		=> array(
								'min' 			=> 1,
								'max' 			=> 6,
								'show_input' 	=> true
							),
	                        'description'	=> esc_html__( 'Input how many stores to be visible', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'hide_empty',
	                        'label' 		=> esc_html__( 'Hide Empty', 'couponis' ),
	                        'type' 			=> 'select',
	                        'options'		=> array(
	                        	'yes'	=> esc_html__( 'Yes', 'couponis' ),
	                        	'no'	=> esc_html__( 'No', 'couponis' ),
	                        ),
	                        'description'	=> esc_html__( 'Allow stores without coupons to be displayed', 'couponis' )
	                    ),
	                )
	            ),
	        )
	    );

	    kc_add_map(
	        array(
	            'kc_categories_carousel' => array(
	                'name' 			=> esc_html__( 'Carousel Categories', 'couponis' ),
	                'description' 	=> esc_html__('Display categories in carousel', 'couponis'),
	                'icon' 			=> 'sl-paper-plane',
	                'category' 		=> 'Content',
	                'params' 		=> array(
	                    array(
	                        'name' 			=> 'number',
	                        'label' 		=> esc_html__( 'Number Of Categories', 'couponis' ),
	                        'type' 			=> 'text',
	                        'description'	=> esc_html__( 'Input how many categories to show or leave empty', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'title',
	                        'label' 		=> esc_html__( 'Block Title', 'couponis' ),
	                        'type' 			=> 'text',
	                        'description'	=> esc_html__( 'Input title or leave empty to disable ( All Stores link will also be gone )', 'couponis' )
	                    ),	                    
	                    array(
	                        'name' 			=> 'categories_carousel',
	                        'label' 		=> esc_html__( 'Categories', 'couponis' ),
	                        'type' 			=> 'autocomplete',
	                        'options'		=> array(
	                        	'multiple'		=> true,
	                        	'taxonomy'		=> 'coupon-category'
	                        ),	 
	                        'description'	=> esc_html__( 'Select categories wish to display or leave empty to show all', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'visible_items',
	                        'label' 		=> esc_html__( 'Visible Items', 'couponis' ),
	                        'type'			=> 'number_slider',
	                        'value'			=> 6,
							'options' 		=> array(
								'min' 			=> 1,
								'max' 			=> 6,
								'show_input' 	=> true
							),
	                        'description'	=> esc_html__( 'Input how many categories to be visible', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'hide_empty',
	                        'label' 		=> esc_html__( 'Hide Empty', 'couponis' ),
	                        'type' 			=> 'select',
	                        'options'		=> array(
	                        	'yes'	=> esc_html__( 'Yes', 'couponis' ),
	                        	'no'	=> esc_html__( 'No', 'couponis' ),
	                        ),
	                        'description'	=> esc_html__( 'Allow categories without coupons to be displayed', 'couponis' )
	                    ),
	                )
	            ),
	        )
	    );

	    kc_add_map(
	        array(
	            'kc_search_coupons' => array(
	                'name' 			=> esc_html__( 'Search Coupons', 'couponis' ),
	                'description' 	=> esc_html__('Display form for searching coupons', 'couponis'),
	                'icon' 			=> 'sl-paper-plane',
	                'category' 		=> 'Content',
	                'params' 		=> array()
	            ),
	        )
	    );

	    kc_add_map(
	        array(
	            'kc_latest_coupons' => array(
	                'name' 			=> esc_html__( 'Latest Coupons', 'couponis' ),
	                'description' 	=> esc_html__('Display latest coupons', 'couponis'),
	                'icon' 			=> 'sl-paper-plane',
	                'category' 		=> 'Content',
	                'params' 		=> array(
	                    array(
	                        'name' 			=> 'number',
	                        'label' 		=> esc_html__( 'Number Of Coupons', 'couponis' ),
	                        'type' 			=> 'text',
	                        'description'	=> esc_html__( 'Input how many coupons to display', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'style',
	                        'label' 		=> esc_html__( 'Style', 'couponis' ),
	                        'type'			=> 'select',
	                        'value'			=> 'list',
							'options' 		=> array(
								'list' 			=> esc_html__( 'List', 'couponis' ),
								'grid' 			=> esc_html__( 'Grid', 'couponis' )
							),
	                        'description'	=> esc_html__( 'Select type of coupon listing', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'number_in_row',
	                        'relation' => array(
	                        	'parent'		=> 'style',
	                        	'show_when'		=> 'grid',
	                        ),
	                        'label' 		=> esc_html__( 'Number Of Coupons In Row', 'couponis' ),
	                        'type' 			=> 'select',
	                        'options'		=> array(
	                        	'1'	=> '1',
	                        	'2'	=> '2',
	                        	'3'	=> '3'
	                        ),
	                        'description'	=> esc_html__( 'Input how many coupons to display in one row', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'coupon_type',
	                        'label' 		=> esc_html__( 'Coupon Type', 'couponis' ),
	                        'type' 			=> 'select',
	                        'options'		=> array(
	                        	''				=> esc_html__( 'All', 'couponis' ),
	                        	'1'				=> esc_html__( 'Online Codes', 'couponis' ),
	                        	'2'				=> esc_html__( 'In Store Code', 'couponis' ),
	                        	'3'				=> esc_html__( 'Online Sale', 'couponis' ),
	                        ),	                        
	                        'description'	=> esc_html__( 'Select type of coupo to show', 'couponis' )
	                    ),
	                )
	            ),
	        )
	    );

	    kc_add_map(
	        array(
	            'kc_ending_coupons' => array(
	                'name' 			=> esc_html__( 'Ending Coupons', 'couponis' ),
	                'description' 	=> esc_html__('Display ending coupons', 'couponis'),
	                'icon' 			=> 'sl-paper-plane',
	                'category' 		=> 'Content',
	                'params' 		=> array(
	                    array(
	                        'name' 			=> 'number',
	                        'label' 		=> esc_html__( 'Number Of Coupons', 'couponis' ),
	                        'type' 			=> 'text',
	                        'description'	=> esc_html__( 'Input how many coupons to display', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'style',
	                        'label' 		=> esc_html__( 'Style', 'couponis' ),
	                        'type'			=> 'select',
	                        'value'			=> 'list',
							'options' 		=> array(
								'list' 			=> esc_html__( 'List', 'couponis' ),
								'grid' 			=> esc_html__( 'Grid', 'couponis' )
							),
	                        'description'	=> esc_html__( 'Select type of coupon listing', 'couponis' )
	                    ),
	                    array(
	                        'relation' => array(
	                        	'parent'		=> 'style',
	                        	'show_when'		=> 'grid',
	                        ),
	                        'name' 			=> 'number_in_row',
	                        'label' 		=> esc_html__( 'Number Of Coupons In Row', 'couponis' ),
	                        'type' 			=> 'select',
	                        'options'		=> array(
	                        	'1'	=> '1',
	                        	'2'	=> '2',
	                        	'3'	=> '3'
	                        ),
	                        'description'	=> esc_html__( 'Input how many coupons to display in one row', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'coupon_type',
	                        'label' 		=> esc_html__( 'Coupon Type', 'couponis' ),
	                        'type' 			=> 'select',
	                        'options'		=> array(
	                        	''				=> esc_html__( 'All', 'couponis' ),
	                        	'1'				=> esc_html__( 'Online Codes', 'couponis' ),
	                        	'2'				=> esc_html__( 'In Store Code', 'couponis' ),
	                        	'3'				=> esc_html__( 'Online Sale', 'couponis' ),
	                        ),	                        
	                        'description'	=> esc_html__( 'Select type of coupo to show', 'couponis' )
	                    ),
	                )
	            ),
	        )
	    );

	    kc_add_map(
	        array(
	            'kc_popular_coupons' => array(
	                'name' 			=> esc_html__( 'Popular Coupons', 'couponis' ),
	                'description' 	=> esc_html__('Display popular coupons', 'couponis'),
	                'icon' 			=> 'sl-paper-plane',
	                'category' 		=> 'Content',
	                'params' 		=> array(
	                    array(
	                        'name' 			=> 'number',
	                        'label' 		=> esc_html__( 'Number Of Coupons', 'couponis' ),
	                        'type' 			=> 'text',
	                        'description'	=> esc_html__( 'Input how many coupons to display', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'style',
	                        'label' 		=> esc_html__( 'Style', 'couponis' ),
	                        'type'			=> 'select',
	                        'value'			=> 'list',
							'options' 		=> array(
								'list' 			=> esc_html__( 'List', 'couponis' ),
								'grid' 			=> esc_html__( 'Grid', 'couponis' )
							),
	                        'description'	=> esc_html__( 'Select type of coupon listing', 'couponis' )
	                    ),
	                    array(
	                        'relation' => array(
	                        	'parent'		=> 'style',
	                        	'show_when'		=> 'grid',
	                        ),
	                        'name' 			=> 'number_in_row',
	                        'label' 		=> esc_html__( 'Number Of Coupons In Row', 'couponis' ),
	                        'type' 			=> 'select',
	                        'options'		=> array(
	                        	'1'	=> '1',
	                        	'2'	=> '2',
	                        	'3'	=> '3'
	                        ),
	                        'description'	=> esc_html__( 'Input how many coupons to display in one row', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'coupon_type',
	                        'label' 		=> esc_html__( 'Coupon Type', 'couponis' ),
	                        'type' 			=> 'select',
	                        'options'		=> array(
	                        	''				=> esc_html__( 'All', 'couponis' ),
	                        	'1'				=> esc_html__( 'Online Codes', 'couponis' ),
	                        	'2'				=> esc_html__( 'In Store Code', 'couponis' ),
	                        	'3'				=> esc_html__( 'Online Sale', 'couponis' ),
	                        ),	                        
	                        'description'	=> esc_html__( 'Select type of coupo to show', 'couponis' )
	                    ),
	                )
	            ),
	        )
	    );


	    kc_add_map(
	        array(
	            'kc_coupons_by_category' => array(
	                'name' 			=> esc_html__( 'Coupons By Category', 'couponis' ),
	                'description' 	=> esc_html__('Display coupons filtered by category', 'couponis'),
	                'icon' 			=> 'sl-paper-plane',
	                'category' 		=> 'Content',
	                'params' 		=> array(
	                    array(
	                        'name' 			=> 'coupon_categories',
	                        'label' 		=> esc_html__( 'Categories', 'couponis' ),
	                        'type' 			=> 'autocomplete',
	                        'options'		=> array(
	                        	'multiple'		=> true,
	                        	'taxonomy'		=> 'coupon-category'
	                        ),	                        
	                        'description'	=> esc_html__( 'Select categories from which to show the coupons', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'number',
	                        'label' 		=> esc_html__( 'Number Of Coupons', 'couponis' ),
	                        'type' 			=> 'text',
	                        'description'	=> esc_html__( 'Input how many coupons to display', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'style',
	                        'label' 		=> esc_html__( 'Style', 'couponis' ),
	                        'type'			=> 'select',
	                        'value'			=> 'list',
							'options' 		=> array(
								'list' 			=> esc_html__( 'List', 'couponis' ),
								'grid' 			=> esc_html__( 'Grid', 'couponis' )
							),
	                        'description'	=> esc_html__( 'Select type of coupon listing', 'couponis' )
	                    ),
	                    array(
	                        'relation' => array(
	                        	'parent'		=> 'style',
	                        	'show_when'		=> 'grid',
	                        ),
	                        'name' 			=> 'number_in_row',
	                        'label' 		=> esc_html__( 'Number Of Coupons In Row', 'couponis' ),
	                        'type' 			=> 'select',
	                        'options'		=> array(
	                        	'1'	=> '1',
	                        	'2'	=> '2',
	                        	'3'	=> '3'
	                        ),
	                        'description'	=> esc_html__( 'Input how many coupons to display in one row', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'coupon_type',
	                        'label' 		=> esc_html__( 'Coupon Type', 'couponis' ),
	                        'type' 			=> 'select',
	                        'options'		=> array(
	                        	''				=> esc_html__( 'All', 'couponis' ),
	                        	'1'				=> esc_html__( 'Online Codes', 'couponis' ),
	                        	'2'				=> esc_html__( 'In Store Code', 'couponis' ),
	                        	'3'				=> esc_html__( 'Online Sale', 'couponis' ),
	                        ),	                        
	                        'description'	=> esc_html__( 'Select type of coupo to show', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'orderby',
	                        'label' 		=> esc_html__( 'Order By', 'couponis' ),
	                        'type' 			=> 'select',
	                        'options'		=> array(
	                        	'name'			=> esc_html__( 'Name', 'couponis' ),
	                        	'date'			=> esc_html__( 'Date', 'couponis' ),
	                        	'ID'			=> esc_html__( 'Expire', 'couponis' ),
	                        	'rand'			=> esc_html__( 'Random', 'couponis' ),
	                        )
	                    ),
	                    array(
	                        'name' 			=> 'order',
	                        'label' 		=> esc_html__( 'Order', 'couponis' ),
	                        'type' 			=> 'select',
	                        'options'		=> array(
	                        	'ASC'			=> esc_html__( 'Ascending', 'couponis' ),
	                        	'DESC'			=> esc_html__( 'Descending', 'couponis' ),
	                        )
	                    ),
	                )
	            ),
	        )
	    );

	    kc_add_map(
	        array(
	            'kc_coupons_by_store' => array(
	                'name' 			=> esc_html__( 'Coupons By Store', 'couponis' ),
	                'description' 	=> esc_html__('Display coupons filtered by store', 'couponis'),
	                'icon' 			=> 'sl-paper-plane',
	                'category' 		=> 'Content',
	                'params' 		=> array(
	                    array(
	                        'name' 			=> 'coupon_stores',
	                        'label' 		=> esc_html__( 'Stores', 'couponis' ),
	                        'type' 			=> 'autocomplete',
	                        'options'		=> array(
	                        	'multiple'		=> true,
	                        	'taxonomy'		=> 'coupon-store'
	                        ),	                        
	                        'description'	=> esc_html__( 'Select stores from which to show the coupons', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'number',
	                        'label' 		=> esc_html__( 'Number Of Coupons', 'couponis' ),
	                        'type' 			=> 'text',
	                        'description'	=> esc_html__( 'Input how many coupons to display', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'style',
	                        'label' 		=> esc_html__( 'Style', 'couponis' ),
	                        'type'			=> 'select',
	                        'value'			=> 'list',
							'options' 		=> array(
								'list' 			=> esc_html__( 'List', 'couponis' ),
								'grid' 			=> esc_html__( 'Grid', 'couponis' )
							),
	                        'description'	=> esc_html__( 'Select type of coupon listing', 'couponis' )
	                    ),
	                    array(
	                        'relation' => array(
	                        	'parent'		=> 'style',
	                        	'show_when'		=> 'grid',
	                        ),
	                        'name' 			=> 'number_in_row',
	                        'label' 		=> esc_html__( 'Number Of Coupons In Row', 'couponis' ),
	                        'type' 			=> 'select',
	                        'options'		=> array(
	                        	'1'	=> '1',
	                        	'2'	=> '2',
	                        	'3'	=> '3'
	                        ),
	                        'description'	=> esc_html__( 'Input how many coupons to display in one row', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'coupon_type',
	                        'label' 		=> esc_html__( 'Coupon Type', 'couponis' ),
	                        'type' 			=> 'select',
	                        'options'		=> array(
	                        	''				=> esc_html__( 'All', 'couponis' ),
	                        	'1'				=> esc_html__( 'Online Codes', 'couponis' ),
	                        	'2'				=> esc_html__( 'In Store Code', 'couponis' ),
	                        	'3'				=> esc_html__( 'Online Sale', 'couponis' ),
	                        ),	                        
	                        'description'	=> esc_html__( 'Select type of coupo to show', 'couponis' )
	                    ),
	                    array(
	                        'name' 			=> 'orderby',
	                        'label' 		=> esc_html__( 'Order By', 'couponis' ),
	                        'type' 			=> 'select',
	                        'options'		=> array(
	                        	'name'			=> esc_html__( 'Name', 'couponis' ),
	                        	'date'			=> esc_html__( 'Date', 'couponis' ),
	                        	'ID'			=> esc_html__( 'Expire', 'couponis' ),
	                        	'rand'			=> esc_html__( 'Random', 'couponis' ),
	                        )
	                    ),
	                    array(
	                        'name' 			=> 'order',
	                        'label' 		=> esc_html__( 'Order', 'couponis' ),
	                        'type' 			=> 'select',
	                        'options'		=> array(
	                        	'ASC'			=> esc_html__( 'Ascending', 'couponis' ),
	                        	'DESC'			=> esc_html__( 'Descending', 'couponis' ),
	                        )
	                    ),
	                )
	            ),
	        )
	    );

	    kc_add_map(
	        array(
	            'kc_white_block_content' => array(
	                'name' 			=> esc_html__( 'White Block Content', 'couponis' ),
	                'description' 	=> esc_html__('Display content in white block', 'couponis'),
	                'icon' 			=> 'sl-paper-plane',
	                'category' 		=> 'Content',
	                'is_container' 	=> true, 
	                'params' 		=> array(
	                    array(
	                        'name' 			=> 'content',
	                        'label' 		=> esc_html__( 'Content', 'couponis' ),
	                        'type' 			=> 'textarea_html'
	                    ),
	                )
	            ),
	        )
	    );

	    kc_add_map(
	        array(
	            'kc_service' => array(
	                'name' 			=> esc_html__( 'Service', 'couponis' ),
	                'description' 	=> esc_html__('Display service', 'couponis'),
	                'icon' 			=> 'sl-paper-plane',
	                'category' 		=> 'Content',
	                'params' 		=> array(
	                    array(
	                        'name' 			=> 'icon',
	                        'label' 		=> esc_html__( 'Select Icon', 'couponis' ),
	                        'type' 			=> 'icon_picker'
	                    ),
	                    array(
	                        'name' 			=> 'icon_bg_color',
	                        'label' 		=> esc_html__( 'Icon BG Color', 'couponis' ),
	                        'type' 			=> 'color_picker'
	                    ),
	                    array(
	                        'name' 			=> 'icon_font_color',
	                        'label' 		=> esc_html__( 'Icon Font Color', 'couponis' ),
	                        'type' 			=> 'color_picker'
	                    ),
	                    array(
	                        'name' 			=> 'title',
	                        'label' 		=> esc_html__( 'Title', 'couponis' ),
	                        'type' 			=> 'text'
	                    ),
	                    array(
	                        'name' 			=> 'link',
	                        'label' 		=> esc_html__( 'Link', 'couponis' ),
	                        'type' 			=> 'text'
	                    ),
	                    array(
	                        'name' 			=> 'subtitle',
	                        'label' 		=> esc_html__( 'Subtitle', 'couponis' ),
	                        'type' 			=> 'text'
	                    ),
	                    array(
	                        'name' 			=> 'style',
	                        'label' 		=> esc_html__( 'Service Style', 'couponis' ),
	                        'type' 			=> 'select',
	                        'options'		=> array(
	                        	'vertical'			=> esc_html__( 'Vertical', 'couponis' ),
	                        	'horizontal'		=> esc_html__( 'Horizontal', 'couponis' ),
	                        	'horizontal right'	=> esc_html__( 'Horizontal With Icon Right', 'couponis' ),
	                        )
	                    ),
	                )
	            ),
	        )
	    );

	    kc_add_map(
	        array(
	            'kc_simple_slider' => array(
	                'name' 			=> esc_html__( 'Simple Slider', 'couponis' ),
	                'description' 	=> esc_html__('Slider with images only', 'couponis'),
	                'icon' 			=> 'sl-paper-plane',
	                'category' 		=> 'Content',
	                'params' 		=> array(
	                    array(
	                        'name' 			=> 'image_size',
	                        'label' 		=> esc_html__( 'Image Size', 'couponis' ),
	                        'type' 			=> 'select',
	                        'options'		=> couponis_get_image_sizes()
	                    ),
						array(
							'type'			=> 'group',
							'label'			=> esc_html__('Slides', 'couponis'),
							'name'			=> 'slides',
							'options'		=> array('add_text' => esc_html__('Add new slide', 'couponis')),
							'params' => array(
			                    array(
			                        'name' 			=> 'image',
			                        'label' 		=> esc_html__( 'Image', 'couponis' ),
			                        'type' 			=> 'attach_image'
			                    ),
			                    array(
			                        'name' 			=> 'title',
			                        'label' 		=> esc_html__( 'Title', 'couponis' ),
			                        'type' 			=> 'text'
			                    ),
			                    array(
			                        'name' 			=> 'subtitle',
			                        'label' 		=> esc_html__( 'Subitle', 'couponis' ),
			                        'type' 			=> 'text'
			                    ),
			                    array(
			                        'name' 			=> 'link',
			                        'label' 		=> esc_html__( 'Link', 'couponis' ),
			                        'type' 			=> 'text'
			                    ),
			                    array(
			                        'name' 			=> 'link_text',
			                        'label' 		=> esc_html__( 'Link Text', 'couponis' ),
			                        'type' 			=> 'text'
			                    )
							),
						)
	                )
	            ),
	        )
	    );

	    kc_add_map(
	        array(
	            'kc_blogs' => array(
	                'name' 			=> esc_html__( 'Blogs', 'couponis' ),
	                'description' 	=> esc_html__('Display blogs', 'couponis'),
	                'icon' 			=> 'sl-paper-plane',
	                'category' 		=> 'Content',
	                'params' 		=> array(
	                    array(
	                        'name' 			=> 'source',
	                        'label' 		=> esc_html__( 'Source', 'couponis' ),
	                        'type' 			=> 'select',
	                        'options'		=> array(
	                        	'latest'			=> esc_html__( 'Latest', 'couponis' ),
	                        	'post_ids'			=> esc_html__( 'Select Posts', 'couponis' ),
	                        	'categories'		=> esc_html__( 'From Categories', 'couponis' ),
	                        	'tags'				=> esc_html__( 'With Tags', 'couponis' )
	                        )
	                    ),
	                    array(
	                        'name' 			=> 'post_ids',
	                        'label' 		=> esc_html__( 'Posts', 'couponis' ),
	                        'type' 			=> 'autocomplete',
	                        'relation' 		=> array(
	                        	'parent'		=> 'source',
	                        	'show_when'		=> 'post_ids',
	                        ),
	                        'options'		=> array(
	                        	'multiple'		=> true,
	                        	'post_type'		=> 'post'
	                        ),
	                    ),
	                    array(
	                        'name' 			=> 'post_categories',
	                        'label' 		=> esc_html__( 'Categories', 'couponis' ),
	                        'type' 			=> 'autocomplete',
	                        'relation' 		=> array(
	                        	'parent'		=> 'source',
	                        	'show_when'		=> 'categories',
	                        ),
	                        'options'		=> array(
	                        	'multiple'		=> true,
	                        	'taxonomy'		=> 'category'
	                        ),
	                    ),
	                    array(
	                        'name' 			=> 'post_tags',
	                        'label' 		=> esc_html__( 'Tags', 'couponis' ),
	                        'type' 			=> 'autocomplete',
	                        'relation' 		=> array(
	                        	'parent'		=> 'source',
	                        	'show_when'		=> 'tags',
	                        ),
	                        'options'		=> array(
	                        	'multiple'		=> true,
	                        	'taxonomy'		=> 'post_tag'
	                        ),
	                    ),
	                    array(
	                        'name' 			=> 'number',
	                        'label' 		=> esc_html__( 'Number Of Posts', 'couponis' ),
	                        'type' 			=> 'number',
	                        'relation'		 => array(
	                        	'parent'		=> 'source',
	                        	'show_when'		=> array( 'categories', 'tags','latest' ),
	                        ),
	                    ),
	                    array(
	                        'name' 			=> 'orderby',
	                        'label' 		=> esc_html__( 'Order By', 'couponis' ),
	                        'type' 			=> 'select',
	                        'relation' 		=> array(
	                        	'parent'		=> 'source',
	                        	'show_when'		=> array( 'categories', 'tags' ),
	                        ),
	                        'options'		=> array(
	                        	'name'			=> esc_html__( 'Name', 'couponis' ),
	                        	'date'			=> esc_html__( 'Date', 'couponis' ),
	                        	'ID'			=> esc_html__( 'Post ID', 'couponis' ),
	                        	'rand'			=> esc_html__( 'Random', 'couponis' ),
	                        )
	                    ),
	                    array(
	                        'name' 			=> 'order',
	                        'label' 		=> esc_html__( 'Order', 'couponis' ),
	                        'type' 			=> 'select',
	                        'relation' 		=> array(
	                        	'parent'		=> 'source',
	                        	'show_when'		=> array( 'categories', 'tags' ),
	                        ),
	                        'options'		=> array(
	                        	'ASC'			=> esc_html__( 'Ascending', 'couponis' ),
	                        	'DESC'			=> esc_html__( 'Descending', 'couponis' ),
	                        )
	                    ),
	                    array(
	                        'name' 			=> 'number_in_row',
	                        'label' 		=> esc_html__( 'Number Of Coupons In Row', 'couponis' ),
	                        'type' 			=> 'select',
	                        'options'		=> array(
	                        	'1'	=> '1',
	                        	'2'	=> '2',
	                        	'3'	=> '3'
	                        ),
	                        'description'	=> esc_html__( 'Input how many coupons to display in one row', 'couponis' )
	                    ),
	                )
	            ),
	        )
	    );
	}
}  
add_action('init', 'couponis_start_shortcodes', 99 );
}

if( !function_exists('couponis_autocomplete_post_type') ){
function couponis_autocomplete_post_type( $data ){

	$posts = get_posts(array(
		'post_type'			=> $_POST['post_type'],
		'posts_per_page'	=> '-1',
		'post_status'		=> 'publish',
		's'					=> $_POST['s']
	));

	$result = array();
	if( !empty( $posts ) ){
		foreach( $posts as $post ){
			$result[] = $post->ID.':'.$post->post_title;
		}
	}

    return array( 'Results' => $result ); 
}
add_filter( 'kc_autocomplete_coupon_ids', 'couponis_autocomplete_post_type' );
add_filter( 'kc_autocomplete_post_ids', 'couponis_autocomplete_post_type' );
}

if( !function_exists('couponis_autocomplete_taxonomy') ){
function couponis_autocomplete_taxonomy( $data ){

	$terms = get_terms(array(
		'taxonomy'		=> $_POST['taxonomy'],
		'name__like'	=> $_POST['s']
	));

	$result = array();
	if( !empty( $terms ) ){
		foreach( $terms as $term ){
			$result[] = $term->term_id.':'.$term->name;
		}
	}

    return array( 'Results' => $result ); 
}
add_filter( 'kc_autocomplete_coupon_categories', 'couponis_autocomplete_taxonomy' );
add_filter( 'kc_autocomplete_stores_carousel', 'couponis_autocomplete_taxonomy' );
add_filter( 'kc_autocomplete_categories_carousel', 'couponis_autocomplete_taxonomy' );
add_filter( 'kc_autocomplete_coupon_stores', 'couponis_autocomplete_taxonomy' );
add_filter( 'kc_autocomplete_post_categories', 'couponis_autocomplete_taxonomy' );
add_filter( 'kc_autocomplete_post_tags', 'couponis_autocomplete_taxonomy' );
}

?>