<?php
$subscribe = couponis_get_option( 'subscribe' );
if( $subscribe == 'yes' ):
?>
<div class="footer-subscribe">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-sm-push-3">

				<i class="icon-envelope"></i>

				<h4><?php esc_html_e( 'Subscribe to have new coupon lists delivered directly to your inbox', 'couponis' ) ?></h4>

				<form class="ajax-form">
					<div class="relative-holder">
						<input type="text" class="form-control" name="email" placeholder="<?php esc_attr_e( 'Input your email and hit enter...', 'couponis' ) ?>" />
						<a href="javascript:;" class="btn submit-ajax-form"><?php esc_html_e( 'Subscribe', 'couponis' ) ?></a>
					</div>
					<input type="hidden" name="action" value="subscribe">
					<div class="ajax-form-result"></div>
				</form>
				<p><?php esc_html_e( 'We do not send spam or share your mail with third parties', 'couponis' ) ?></p>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

<?php
$copyrights = couponis_get_option( 'copyrights' );
if( !empty( $copyrights ) ):
?>
<div class="copyrights">
	<?php 
	$has_footer_nav = false;
	if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'footer-navigation' ] ) ) { 
		$has_footer_nav = true;
	}
	?>
	<div class="container <?php echo !$has_footer_nav ? esc_attr( 'text-center' ) : '' ?>">
		<div class="flex-wrap flex-always">
			<div class="flex-left">
				<?php echo wp_kses_post( $copyrights ) ?>
			</div>

			<?php
			$ft_facebook = couponis_get_option( 'ft_facebook' );
			$ft_twitter = couponis_get_option( 'ft_twitter' );
			$ft_google = couponis_get_option( 'ft_google' );
			$ft_youtube = couponis_get_option( 'ft_youtube' );
			$ft_linkedin = couponis_get_option( 'ft_linkedin' );
			$ft_tumblr = couponis_get_option( 'ft_tumblr' );
			$ft_pinterest = couponis_get_option( 'ft_pinterest' );
			$ft_instagram = couponis_get_option( 'ft_instagram' );

			if( !empty( $ft_facebook ) || !empty( $ft_twitter ) || !empty( $ft_google ) || !empty( $ft_youtube ) || !empty( $ft_linkedin ) || !empty( $ft_tumblr ) || !empty( $ft_pinterest ) || !empty( $ft_instagram ) ){
				?>
				<ul class="list-unstyled list-inline footer-social">
					<?php if( !empty( $ft_facebook ) ): ?>
						<li>
							<a href="<?php echo esc_url( $ft_facebook ) ?>" target="_blank" rel="nofollow">
								<i class="fa fa-facebook"></i>
							</a>
						</li>
					<?php endif; ?>
					<?php if( !empty( $ft_twitter ) ): ?>
						<li>
							<a href="<?php echo esc_url( $ft_twitter ) ?>" target="_blank" rel="nofollow">
								<i class="fa fa-twitter"></i>
							</a>
						</li>
					<?php endif; ?>
					<?php if( !empty( $ft_google ) ): ?>
						<li>
							<a href="<?php echo esc_url( $ft_google ) ?>" target="_blank" rel="nofollow">
								<i class="fa fa-google-plus"></i>
							</a>
						</li>
					<?php endif; ?>
					<?php if( !empty( $ft_youtube ) ): ?>
						<li>
							<a href="<?php echo esc_url( $ft_youtube ) ?>" target="_blank" rel="nofollow">
								<i class="fa fa-youtube"></i>
							</a>
						</li>
					<?php endif; ?>
					<?php if( !empty( $ft_linkedin ) ): ?>
						<li>
							<a href="<?php echo esc_url( $ft_linkedin ) ?>" target="_blank" rel="nofollow">
								<i class="fa fa-linkedin"></i>
							</a>
						</li>
					<?php endif; ?>
					<?php if( !empty( $ft_tumblr ) ): ?>
						<li>
							<a href="<?php echo esc_url( $ft_tumblr ) ?>" target="_blank" rel="nofollow">
								<i class="fa fa-tumblr"></i>
							</a>
						</li>
					<?php endif; ?>
					<?php if( !empty( $ft_pinterest ) ): ?>
						<li>
							<a href="<?php echo esc_url( $ft_pinterest ) ?>" target="_blank" rel="nofollow">
								<i class="fa fa-pinterest"></i>
							</a>
						</li>
					<?php endif; ?>
					<?php if( !empty( $ft_instagram ) ): ?>
						<li>
							<a href="<?php echo esc_url( $ft_instagram ) ?>" target="_blank" rel="nofollow">
								<i class="fa fa-instagram"></i>
							</a>
						</li>
					<?php endif; ?>
				</ul>
				<?php
			}
			?>

			<?php if( $has_footer_nav ): ?>
				<div class="flex-right">
					<ul class="list-unstyled list-inline">
						<?php
						wp_nav_menu( array(
							'theme_location'  	=> 'footer-navigation',
							'container'			=> false,
							'echo'          	=> true,
							'items_wrap'        => '%3$s',
							'depth'				=> 1,
							'walker' 			=> new couponis_walker
						) );
						?>
					</ul>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php endif; ?>



<div class="modal fade in" id="showCode" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content coupon_modal_content">

		</div>
	</div>
</div>

<?php if( !is_user_logged_in() ): ?>
<div class="modal fade in" id="login" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4><?php esc_html_e( 'Login To Your Account', 'couponis' ) ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<form class="ajax-form needs-captcha">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="l_username"><?php esc_html_e( 'Username', 'couponis' ) ?> *</label>
								<input type="text" name="l_username" id="l_username" class="form-control" />
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="l_password"><?php esc_html_e( 'Password', 'couponis' ) ?> *</label>
								<input type="password" name="l_password" id="l_password" class="form-control" />
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="styled-checkbox">
							<input type="checkbox" name="l_remember" id="l_remember" />
							<label for="l_remember"><?php esc_html_e( 'Remember Me', 'couponis' ) ?></label>
						</div>
					</div>

					<div class="ajax-form-result"></div>
					<a href="javascript:;" class="btn submit-ajax-form"><?php esc_html_e( 'Login', 'couponis' ) ?></a>

					<div class="row">
						<div class="col-sm-6">
							<a href="#" class="small-action" data-toggle="modal" data-target="#register" data-dismiss="modal"><?php esc_html_e( 'Not A Memeber?', 'couponis' ) ?></a>
						</div>
						<div class="col-sm-6 text-right">
							<a href="#" class="small-action" data-toggle="modal" data-target="#lost-password" data-dismiss="modal"><?php esc_html_e( 'Lost Password?', 'couponis' ) ?></a>
						</div>
					</div>

					<input type="hidden" name="action" value="login">

				</form>
			</div>
            <?php
            if( function_exists( 'sc_render_login_form_social_connect' ) && sc_is_sc_set() ){
            	?>
            	<div class="social-login">
            		<div class="modal-body">
            			<h5><?php esc_html_e( 'Login Using Social Networks', 'couponis' ) ?></h5>
            			<?php sc_render_login_form_social_connect(); ?>
            		</div>
            	</div>
            	<?php
            }
            ?>
		</div>
	</div>
</div>

<div class="modal fade in" id="register" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4><?php esc_html_e( 'Register Your Account', 'couponis' ) ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<form class="ajax-form needs-captcha">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="r_username"><?php esc_html_e( 'Username', 'couponis' ) ?> *</label>
								<input type="text" name="r_username" id="r_username" class="form-control" />
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="r_email"><?php esc_html_e( 'Email', 'couponis' ) ?> *</label>
								<input type="text" name="r_email" id="r_email" class="form-control" />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="r_password"><?php esc_html_e( 'Password', 'couponis' ) ?> *</label>
								<input type="password" name="r_password" id="r_password" class="form-control" />
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="r_password_confirm"><?php esc_html_e( 'Confirm Password', 'couponis' ) ?> *</label>
								<input type="password" name="r_password_confirm" id="r_password_confirm" class="form-control" />
							</div>
						</div>
					</div>

					<div class="ajax-form-result"></div>
					<a href="javascript:;" class="btn submit-ajax-form"><?php esc_html_e( 'Register', 'couponis' ) ?></a>

					<div class="row">
						<div class="col-sm-6">
							<a href="#" class="small-action" data-toggle="modal" data-target="#login" data-dismiss="modal"><?php esc_html_e( 'Already A Memebr?', 'couponis' ) ?></a>
						</div>
						<div class="col-sm-6 text-right">
							<a href="#" class="small-action" data-toggle="modal" data-target="#lost-password" data-dismiss="modal"><?php esc_html_e( 'Lost Password?', 'couponis' ) ?></a>
						</div>
					</div>

					<input type="hidden" name="action" value="register">

				</form>
			</div>
            <?php
            if( function_exists( 'sc_render_login_form_social_connect' ) && sc_is_sc_set() ){
            	?>
            	<div class="social-login">
            		<div class="modal-body">
            			<h5><?php esc_html_e( 'Register Using Social Networks', 'couponis' ) ?></h5>
            			<?php sc_render_login_form_social_connect(); ?>
            		</div>
            	</div>
            	<?php
            }
            ?>
		</div>
	</div>
</div>

<div class="modal fade in" id="lost-password" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4><?php esc_html_e( 'Recover Your Account', 'couponis' ) ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<form class="ajax-form needs-captcha">

					<div class="form-group">
						<label for="l_email"><?php esc_html_e( 'Email', 'couponis' ) ?> *</label>
						<input type="text" name="l_email" id="l_email" class="form-control" />
					</div>

					<div class="ajax-form-result"></div>
					<a href="javascript:;" class="btn submit-ajax-form"><?php esc_html_e( 'Recover', 'couponis' ) ?></a>

					<div class="row">
						<div class="col-sm-6">
							<a href="#" class="small-action" data-toggle="modal" data-target="#login" data-dismiss="modal"><?php esc_html_e( 'Already A Memebr?', 'couponis' ) ?></a>
						</div>
						<div class="col-sm-6 text-right">
							<a href="#" class="small-action" data-toggle="modal" data-target="#register" data-dismiss="modal"><?php esc_html_e( 'Not A Memeber?', 'couponis' ) ?></a>
						</div>
					</div>

					<input type="hidden" name="action" value="lost">

				</form>
			</div>
		</div>
	</div>
</div>
<?php if( !empty( $_GET['recover_hash'] ) ): ?>
<div class="modal fade in" id="recover-password" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4><?php esc_html_e( 'Recover Your Account', 'couponis' ) ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<form class="ajax-form needs-captcha">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="rl_password"><?php esc_html_e( 'New Password', 'couponis' ) ?> *</label>
								<input type="password" name="rl_password" id="rl_password" class="form-control" />
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="rl_password_confirm"><?php esc_html_e( 'Confirm Password', 'couponis' ) ?> *</label>
								<input type="password" name="rl_password_confirm" id="rl_password_confirm" class="form-control" />
							</div>
						</div>
					</div>

					<div class="ajax-form-result"></div>
					<a href="javascript:;" class="btn submit-ajax-form"><?php esc_html_e( 'Recover', 'couponis' ) ?></a>

					<input type="hidden" name="action" value="recover">
					<input type="hidden" name="rl_login" value="<?php echo esc_attr( $_GET['login'] ) ?>">
					<input type="hidden" name="rl_recover_hash" value="<?php echo esc_attr( $_GET['recover_hash'] ) ?>">

				</form>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
<?php endif; ?>