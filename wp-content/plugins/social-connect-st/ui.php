<?php

if( !function_exists('sc_is_sc_set') ){
function sc_is_sc_set(){
	$twitter_enabled = get_option( 'social_connect_twitter_enabled' ) && get_option( 'social_connect_twitter_consumer_key' ) && get_option( 'social_connect_twitter_consumer_secret' );
	$facebook_enabled = get_option( 'social_connect_facebook_enabled') && get_option( 'social_connect_facebook_api_key' ) && get_option( 'social_connect_facebook_secret_key' );
	$google_plus_enabled = get_option( 'social_connect_google_plus_enabled' );

	if ( $twitter_enabled || $facebook_enabled || $google_plus_enabled ) {
		return true;
	}
	else{
		return false;
	}
}
}

if (!function_exists('sc_render_login_form_social_connect')) :

function sc_render_login_form_social_connect( $args = NULL ) {
	$display_label = false;

	if( $args == NULL )
		$display_label = true;
	elseif ( is_array( $args ) )
		extract( $args );

	if( !isset( $images_url ) )
		$images_url = apply_filters('social_connect_images_url', SOCIAL_CONNECT_PLUGIN_URL . '/media/img/');

	$twitter_enabled = get_option( 'social_connect_twitter_enabled' ) && get_option( 'social_connect_twitter_consumer_key' ) && get_option( 'social_connect_twitter_consumer_secret' );
	$facebook_enabled = get_option( 'social_connect_facebook_enabled') && get_option( 'social_connect_facebook_api_key' ) && get_option( 'social_connect_facebook_secret_key' );
	$google_plus_enabled = get_option( 'social_connect_google_plus_enabled' );
	?>
	
	<?php if ($twitter_enabled || $facebook_enabled || $google_plus_enabled ) : ?>
		<div class="social_connect_ui <?php if( strpos( $_SERVER['REQUEST_URI'], 'wp-signup.php' ) ) echo 'mu_signup'; ?>">
			<div class="social_connect_form">
			<?php do_action ('social_connect_pre_form'); ?>
				<div class="social-login-wrap clearfix">
					<?php if( $facebook_enabled ) :
						echo apply_filters('social_connect_login_facebook','<a href="javascript:void(0);" title="Facebook" class="social_connect_login social_connect_login_facebook"><i class="fa fa-facebook"></i></a>');
					endif; ?>
					<?php if( $twitter_enabled ) :
						echo apply_filters('social_connect_login_twitter','<a href="javascript:void(0);" title="Twitter" class="social_connect_login social_connect_login_twitter"><i class="fa fa-twitter"></i></a>');
					endif; ?>
					<?php if( $google_plus_enabled ) :
						echo apply_filters('social_connect_login_google_plus','<a href="javascript:void(0);" title="Google+" class="social_connect_login social_connect_login_google_plus"><i class="fa fa-google-plus"></i></a>');
					endif; ?>
				</div>
			<?php do_action ('social_connect_post_form'); ?>
			</div>
	
			<?php
			$social_connect_provider = isset( $_COOKIE['social_connect_current_provider']) ? $_COOKIE['social_connect_current_provider'] : '';
		
			do_action ('social_connect_auth'); ?>
			<div class="social_connect_facebook_auth_id">
				<input type="hidden" name="client_id" value="<?php echo get_option( 'social_connect_facebook_api_key' ); ?>" />
				<input type="hidden" name="redirect_uri" value="<?php echo home_url('index.php?social-connect=facebook-callback'); ?>" />
			</div>
			
			<div class="social_connect_twitter_auth_id"><input type="hidden" name="redirect_uri" value="<?php echo home_url('index.php?social-connect=twitter'); ?>" /></div>
			<div class="social_connect_google_plus_auth_id"><input type="hidden" name="redirect_uri" value="<?php echo home_url('index.php?social-connect=google-plus'); ?>" /></div>
		</div> <!-- End of social_connect_ui div -->
	<?php endif;
}
endif; // function_exist

//add_action( 'login_form',          'sc_render_login_form_social_connect', 10 );
//add_action( 'register_form',       'sc_render_login_form_social_connect', 10 );
//add_action( 'after_signup_form',   'sc_render_login_form_social_connect', 10 );
//add_action( 'social_connect_form', 'sc_render_login_form_social_connect', 10 );


function sc_social_connect_add_comment_meta( $comment_id ) {
	$social_connect_comment_via_provider = isset( $_POST['social_connect_comment_via_provider']) ? $_POST['social_connect_comment_via_provider'] : '';
	if( $social_connect_comment_via_provider != '' ) {
		update_comment_meta( $comment_id, 'social_connect_comment_via_provider', $social_connect_comment_via_provider );
	}
}
//add_action( 'comment_post', 'sc_social_connect_add_comment_meta' );


function sc_social_connect_render_comment_meta( $link ) {
	global $comment;
	$images_url = SOCIAL_CONNECT_PLUGIN_URL . '/media/img/';
	$social_connect_comment_via_provider = get_comment_meta( $comment->comment_ID, 'social_connect_comment_via_provider', true );
	if( $social_connect_comment_via_provider && current_user_can( 'manage_options' )) {
		return $link . '&nbsp;<img class="social_connect_comment_via_provider" alt="'.$social_connect_comment_via_provider.'" src="' . $images_url . $social_connect_comment_via_provider . '_16.png"  />';
	} else {
		return $link;
	}
}
//add_action( 'get_comment_author_link', 'sc_social_connect_render_comment_meta' );


function sc_render_comment_form_social_connect() {
	if( comments_open() && !is_user_logged_in()) {
		sc_render_login_form_social_connect();
	}
}
//add_action( 'comment_form_top', 'sc_render_comment_form_social_connect' );


function sc_render_login_page_uri(){
	?>
	<input type="hidden" id="social_connect_login_form_uri" value="<?php echo site_url( 'wp-login.php', 'login_post' ); ?>" />
	<?php
}
add_action( 'wp_footer', 'sc_render_login_page_uri' );


function sc_social_connect_shortcode_handler( $args ) {
	if( !is_user_logged_in()) {
		sc_render_login_form_social_connect();
	}
}
add_shortcode( 'social_connect', 'sc_social_connect_shortcode_handler' );