<?php
	
	/* MAIN COLOR */
	$main_color = couponis_get_option( 'main_color' );
	$main_color_font = couponis_get_option( 'main_color_font' );

	/* COUPONS */
	$sale_badge_bg = couponis_get_option( 'sale_badge_bg' );
	$sale_badge_font = couponis_get_option( 'sale_badge_font' );
	$exclusive_badge_bg = couponis_get_option( 'exclusive_badge_bg' );
	$exclusive_badge_font = couponis_get_option( 'exclusive_badge_font' );
	$online_badge_bg = couponis_get_option( 'online_badge_bg' );
	$online_badge_font = couponis_get_option( 'online_badge_font' );
	$in_store_badge_bg = couponis_get_option( 'in_store_badge_bg' );
	$in_store_badge_font = couponis_get_option( 'in_store_badge_font' );
	$action_btn_bg = couponis_get_option( 'action_btn_bg' );
	$action_btn_font = couponis_get_option( 'action_btn_font' );

	/* HEADER */
	$header_bg_color = couponis_get_option( 'header_bg_color' );
	$header_font_color = couponis_get_option( 'header_font_color' );
	$header_font_color_active = couponis_get_option( 'header_font_color_active' );
	$header_input_background = couponis_get_option( 'header_input_background' );

	/* TEXT */
	$navigation_font = couponis_get_option( 'navigation_font' );
	$navigation_font_size = couponis_get_option( 'navigation_font_size' );
	$navigation_font_weight = couponis_get_option( 'navigation_font_weight' );

	$text_font = couponis_get_option( 'text_font' );
	$text_font_size = couponis_get_option( 'text_font_size' );
	$text_font_weight = couponis_get_option( 'text_font_weight' );
	$text_font_line_height = couponis_get_option( 'text_font_line_height' );

	$title_font = couponis_get_option( 'title_font' );
	$title_font_weight = couponis_get_option( 'title_font_weight' );
	$h1_font_size = couponis_get_option( 'h1_font_size' );
	$h1_font_line_height = couponis_get_option( 'h1_font_line_height' );	
	$h2_font_size = couponis_get_option( 'h2_font_size' );
	$h2_font_line_height = couponis_get_option( 'h2_font_line_height' );
	$h3_font_size = couponis_get_option( 'h3_font_size' );
	$h3_font_line_height = couponis_get_option( 'h3_font_line_height' );
	$h4_font_size = couponis_get_option( 'h4_font_size' );
	$h4_font_line_height = couponis_get_option( 'h4_font_line_height' );
	$h5_font_size = couponis_get_option( 'h5_font_size' );
	$h5_font_line_height = couponis_get_option( 'h5_font_line_height' );
	$h6_font_size = couponis_get_option( 'h6_font_size' );
	$h6_font_line_height = couponis_get_option( 'h6_font_line_height' );

	/* TYPOGRAPHY COLORS */
	$title_color = couponis_get_option( 'title_color' );
	$link_color = couponis_get_option( 'link_color' );
	$text_color = couponis_get_option( 'text_color' );

	/* COPYRIGHTS */
	$copyrights_bg_color = couponis_get_option( 'copyrights_bg_color' );
	$copyrights_font_color = couponis_get_option( 'copyrights_font_color' );
	$copyrights_font_color_active = couponis_get_option( 'copyrights_font_color_active' );

	$custom_css = couponis_get_option( 'custom_css' );
?>

/* BODY */
body[class*=" "]{
	font-family: "<?php echo esc_html( $text_font ) ?>", sans-serif;
	color: <?php echo esc_html( $text_color ) ?>;
	font-weight: <?php echo esc_html( $text_font_weight ) ?>;
	font-size: <?php echo esc_html( $text_font_size ) ?>;
	line-height: <?php echo esc_html( $text_font_line_height ) ?>;
}


a, a:visited{
	color: <?php echo esc_html( $link_color ) ?>;
}


a:hover, a:focus, a:active, body .blog-item-title a:hover, .infobox-content a:hover,
.blog-item-meta a:hover,
.leading-icon,
.single-expire,
.navbar-default .navbar-nav .open .dropdown-menu > li > a:hover,
.navbar-default .navbar-nav .open > a, 
.navbar-default .navbar-nav .open > a:hover, 
.navbar-default .navbar-nav .open > a:focus,
.navbar-default .navbar-nav li a:hover,
.navbar-default .navbar-nav li.current_page_ancestor > a,
.navbar-default .navbar-nav li.current_page_ancestor > a:visited,
.navbar-default .navbar-nav li.current_page_item > a,
.navbar-default .navbar-nav li.current_page_item > a:visited,
.navbar-toggle,
.special-action a,
.widget_widget_categories li:hover i,
.footer-subscribe i.icon-envelope,
.copyrights a:hover,
.error404 .icon-compass,
.image-loader,
.categories-list li:hover i,
.categories-carousel-list .owl-item i,
.save-store:hover,
.save-store.added:active,
.save-store.added,
.category-icon,
.coupon-box h4:hover,
.show-hide-more,
.save-coupon.added,
body .kc_tabs_nav > li > a:hover,
body .kc_tabs_nav > .ui-tabs-active,
body .kc_tabs_nav > .ui-tabs-active:hover,
body .kc_tabs_nav > .ui-tabs-active > a,
body .kc_tabs_nav > .ui-tabs-active > a:hover,
.category-block i,
.listing-style.active,
.letter-title h3,
.ui-state-hover, 
.ui-widget-content .ui-state-hover, 
.ui-widget-header .ui-state-hover, 
.ui-state-focus, 
.ui-widget-content .ui-state-focus, 
.ui-widget-header .ui-state-focus,
.ui-state-hover .ui-icon:before, 
.ui-widget-content .ui-state-hover .ui-icon:before, 
.ui-widget-header .ui-state-hover .ui-icon:before, 
.ui-state-focus .ui-icon:before, 
.ui-widget-content .ui-state-focus .ui-icon:before, 
.ui-widget-header .ui-state-focus .ui-icon:before,
.ui-datepicker-next .ui-icon:hover:before
{
	color: <?php echo esc_html( $main_color ) ?>;
}

.widget-title:after,
a.search-type:hover,
a.search-type.type-added,
.widget_widget_stores a:hover,
.stores-carousel-list .owl-item:hover a,
.categories-carousel-list .owl-item:hover a,
.store-logo:hover,
.coupon-image:hover,
.owl-dot.active
{
	border-color: <?php echo esc_html( $main_color ) ?>;
}

.styled-checkbox.active label:after,
.styled-checkbox input:checked + label:after,
.styled-radio.active label:after,
.styled-radio input:checked + label:after,
.form-submit #submit,
.form-submit a,
.tagcloud a, .btn, a.btn,
.blog-item-meta:before,
.main-search a,
.pagination a.btn:hover,
.pagination a.btn.active,
a.visit-store,
.tax-coupon-category .category-icon-wrap,
.nav.nav-tabs > li > a:hover,
.nav.nav-tabs > li.active > a, 
.nav.nav-tabs > li.active > a:hover, 
.nav.nav-tabs > li.active > a:focus,
.nav.nav-tabs > li.active > a:active,
.category-block:hover .white-block,
.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active,
.ui-widget-content.ui-slider-horizontal .ui-state-active,
.ui-datepicker .ui-datepicker-buttonpane button:hover
{
	background-color: <?php echo esc_html( $main_color ) ?>;
	color: <?php echo esc_html( $main_color_font ) ?>;
}

.online-sale{
	background-color: <?php echo esc_html( $sale_badge_bg ) ?>;
	color: <?php echo esc_html( $sale_badge_font ) ?>;
}

.exclusive{
	background-color: <?php echo esc_html( $exclusive_badge_bg ) ?>;
	color: <?php echo esc_html( $exclusive_badge_font ) ?>;
}

.online-code{
	background-color: <?php echo esc_html( $online_badge_bg ) ?>;
	color: <?php echo esc_html( $online_badge_font ) ?>;
}

.in-store-code{
	background-color: <?php echo esc_html( $in_store_badge_bg ) ?>;
	color: <?php echo esc_html( $in_store_badge_font ) ?>;
}

.coupon-code-modal,
.coupon-action-button.header-alike{
	border-color: <?php echo esc_html( $action_btn_bg ) ?>;
}

.code-text,
.code-text-full,
a.coupon-code-modal, a.coupon-code-modal:visited, a.coupon-code-modal:hover, a.coupon-code-modal:focus, a.coupon-code-modal:focus:active,
.similar-badge{
	background-color: <?php echo esc_html( $action_btn_bg ) ?>;
	color: <?php echo esc_html( $action_btn_font ) ?>;
}

.top-header{
	background-color: <?php echo esc_html( $header_bg_color ) ?>;
}

.header-categories a{
	color: <?php echo esc_html( $header_font_color ) ?>;
}

.header-categories a:hover{
	color: <?php echo esc_html( $header_font_color_active ) ?>;
}

.main-search input, .main-search input:focus, .main-search input:active, .main-search input:focus:active{
	background: <?php echo esc_html( $header_input_background  ); ?>;
}

.navbar-default .navbar-nav .open .dropdown-menu > li > a,
.navbar-default .navbar-nav li a{
	font-size: <?php echo esc_html( $navigation_font_size ) ?>;
	font-weight: <?php echo esc_html( $navigation_font_weight ) ?>;
	font-family: '<?php echo esc_html( $navigation_font ) ?>', sans-serif;
}

h1, h2, h3, h4, h5, h6{
	color: <?php echo esc_html( $title_color ) ?>;
}

h1, h2, h3, h4, h5, h6, .header-alike, .continue-read{
	font-weight: <?php echo esc_html( $title_font_weight ) ?>;
	font-family: '<?php echo esc_html( $title_font ) ?>', sans-serif;	
}

.continue-read{
	font-weight: <?php echo esc_html( $navigation_font_weight ) ?>;
}

h1{
	font-size: <?php echo esc_html( $h1_font_size ) ?>;
	line-height: <?php echo esc_html( $h1_font_line_height ) ?>;
}

h2{
	font-size: <?php echo esc_html( $h2_font_size ) ?>;
	line-height: <?php echo esc_html( $h2_font_line_height ) ?>;
}

h3{
	font-size: <?php echo esc_html( $h3_font_size ) ?>;
	line-height: <?php echo esc_html( $h3_font_line_height ) ?>;
}

h4{
	font-size: <?php echo esc_html( $h4_font_size ) ?>;
	line-height: <?php echo esc_html( $h4_font_line_height ) ?>;
}

h5{
	font-size: <?php echo esc_html( $h5_font_size ) ?>;
	line-height: <?php echo esc_html( $h5_font_line_height ) ?>;
}

h6{
	font-size: <?php echo esc_html( $h6_font_size ) ?>;
	line-height: <?php echo esc_html( $h6_font_line_height ) ?>;
}

.copyrights a,
.copyrights{
	color: <?php echo esc_html( $copyrights_font_color ) ?>;
	background: <?php echo esc_html( $copyrights_bg_color ) ?>;
}

.copyrights a:hover{
	color: <?php echo esc_html( $copyrights_font_color_active ) ?>;
}

<?php echo wp_strip_all_tags( $custom_css ); ?>