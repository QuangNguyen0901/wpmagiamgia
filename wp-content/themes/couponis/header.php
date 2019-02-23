<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php 
if( function_exists('couponis_activate_account') ){
	couponis_activate_account();	
}
?>

<!-- ==================================================================================================================================
TOP BAR
======================================================================================================================================= -->
<header>
	<div class="top-header">
		<div class="container">
			<div class="flex-wrap flex-always">
				<div class="flex-left">
					<a href="<?php echo esc_url( home_url( '/' ) ) ?>" class="logo">
					<?php
						$logo = couponis_get_option( 'site_logo' );
						if( !empty( $logo['url'] ) ):
							echo wp_get_attachment_image( $logo['id'], 'full' );
						else:
							?>
							<h2><?php echo get_bloginfo( 'name' ) ?></h2>
							<?php
						endif;
					?>
					</a>
				</div>
				<?php if( function_exists( 'couponis_register_types' ) ): ?>
				<div class="flex-right">
					<form class="main-search" method="GET" action="<?php echo esc_url( couponis_get_permalink_by_tpl( 'page-tpl_search' ) ) ?>">
						<input type="text" name="keyword" class="form-control" placeholder="<?php esc_html_e( 'I want coupons for...', 'couponis' ) ?>">
						<a href="javascript:;" class="submit-form"><?php esc_html_e( 'Search', 'couponis' ) ?></a>
					</form>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="navigation">
		<div class="container">
			<div class="flex-wrap flex-always">
				<div class="flex-left">
					<a class="navbar-toggle button-white menu" data-toggle="collapse" data-target=".navbar-collapse">
						<i class="icon-menu"></i>
					</a>
					<div class="nav-copy">
						<div class="navbar navbar-default" role="navigation">
							<div class="collapse navbar-collapse">
								<ul class="nav navbar-nav">
									<?php
									if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'main-navigation' ] ) ) {
										wp_nav_menu( array(
											'theme_location'  	=> 'main-navigation',
											'container'			=> false,
											'echo'          	=> true,
											'items_wrap'        => '%3$s',
											'walker' 			=> new couponis_walker
										) );
									}
									?>

								</ul>
							</div>
						</div>
					</div>
				</div>
				<?php if( function_exists( 'couponis_register_types' ) && get_option( 'users_can_register' ) ): ?>
					<div class="flex-right">
						<ul class="list-unstyled list-inline special-action">
							<?php
							$special_actions = '';
							if( is_user_logged_in() ){
								if( couponis_get_option( 'can_submit' ) == 'yes' ){
									$special_actions = 	'
									<li>
										<a href="'.esc_url( couponis_get_permalink_by_tpl('page-tpl_submit') ).'" title="'.esc_html__( 'Submit Coupon', 'couponis' ).'">
											<span class="icon-tag"></span>
										</a>
									</li>
									';
								}
								$special_actions .= '
								<li>
									<a href="'.esc_url( couponis_get_permalink_by_tpl('page-tpl_account') ).'" title="'.esc_html__( 'My Account', 'couponis' ).'">
										<span class="icon-user"></span>
									</a>
								</li>
								<li>
									<a href="'.esc_url( wp_logout_url( home_url('/') ) ).'" title="'.esc_html__( 'Logout', 'couponis' ).'">
										<span class="icon-power"></span>
									</a>
								</li>';
							}
							else{
								if( couponis_get_option( 'can_submit' ) == 'yes' ){
									$special_actions = 	'
									<li>
										<a href="#" data-toggle="modal" data-target="#login" title="'.esc_html__( 'Submit Coupon', 'couponis' ).'">
											<span class="icon-tag"></span>
										</a>
									</li>
									';
								}								
								$special_actions .= '
								<li>
									<a href="#" data-toggle="modal" data-target="#login" title="'.esc_html__( 'My Account', 'couponis' ).'">
										<span class="icon-user"></span>
									</a>
								</li>';
							}

							echo wp_kses_post( $special_actions );
							?>
						</ul>
					</div>
				<?php endif; ?>
			</div>
			<div class="nav-paste">
			</div>
		</div>
	</div>
</header>
<?php do_action( 'couponis_advertise_print' ); ?>