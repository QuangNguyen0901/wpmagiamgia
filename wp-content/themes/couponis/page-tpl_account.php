<?php
/*
	Template Name: My Account
*/
?>
<?php 

if( !is_user_logged_in() ){
	wp_redirect( home_url('/') );
}

$user = wp_get_current_user();

$saved_coupons = get_user_meta( $user->ID, 'saved_coupons', true );
$saved_stores = get_user_meta( $user->ID, 'saved_stores', true );

get_header();

get_template_part( 'includes/title' );

?>
<main>
	<div class="container">
		<div class="row">
			<div class="col-sm-8">

				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active">
						<a href="#coupons" aria-controls="coupons" role="tab" data-toggle="tab">
							<?php esc_html_e( 'Saved Coupons', 'couponis') ?>
						</a>
					</li>
					<li role="presentation">
						<a href="#stores" aria-controls="stores" role="tab" data-toggle="tab">
							<?php esc_html_e( 'Saved Stores', 'couponis' ) ?>
						</a>
					</li>
					<li role="presentation">
						<a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">
							<?php esc_html_e( 'Profile', 'couponis' ) ?>
						</a>
					</li>
				</ul>

				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="coupons">
						<?php
						if( !empty( $saved_coupons ) ){

							$coupons = new WP_Coupons_Query(array(
								'post_status'	=> 'publish',
								'post__in'		=> explode( ',', $saved_coupons ),
								'orderby'		=> 'expire',
								'order'			=> 'ASC'
							));
							if( $coupons->have_posts() ){
								while( $coupons -> have_posts() ){
									$coupons->the_post();
									include( get_theme_file_path( 'includes/coupon-box/coupon-list.php' ) );
								}
							}

							wp_reset_postdata();
						}
						else{
							?>
							<div class="white-block">
								<div class="white-block-content">
									<?php esc_html_e( 'You do not have any coupons saved', 'couponis' ) ?>
								</div>
							</div>
							<?php
						}
						?>
					</div>			
					<div role="tabpanel" class="tab-pane" id="stores">
						<?php
						if( !empty( $saved_stores ) ){
							echo '<div class="row">';
								$stores = get_terms(array( 
									'taxonomy' 		=> 'coupon-store',
									'include' 		=> explode( ',', $saved_stores ),
									'allow_empty'	=> true
								));
								$counter = 0;
								foreach( $stores as $store ){
									if( $counter == 4 ){
										echo '</div><div class="row">';
										$counter = 0;
									}
									$counter++;
									?>
									<div class="col-sm-3">
										<div class="store-block">
											<div class="white-block white-block-small-margin">
												<div class="white-block-content">
													<div class="store-image">
														<a href="<?php echo esc_url( get_term_link( $store ) ) ?>">
															<?php echo couponis_get_coupon_store_logo( $store->term_id ); ?>
														</a>
													</div>

													<?php echo couponis_save_store_link( $store->term_id ) ?>	
												</div>
											</div>
											<div class="white-block store-title">
												<div class="white-block-content">
													<a href="<?php echo esc_url( get_term_link( $store ) ) ?>">
														<?php echo  $store->name ?>
													</a>
												</div>
											</div>
										</div>
									</div>
									<?php
								}
							echo '</div>';
						}	
						else{
							?>
							<div class="white-block">
								<div class="white-block-content">
									<?php esc_html_e( 'You do not have any stores saved', 'couponis' ) ?>
								</div>
							</div>
							<?php
						}
						?>
					</div>
					<div role="tabpanel" class="tab-pane" id="profile">
						<div class="white-block">
							<div class="white-block-content">
								<form class="ajax-form">
									<div class="form-group">
										<label for="email"><?php esc_html_e( 'Email' , 'couponis' ) ?> *</label>
										<input type="text" name="email" id="email" class="form-control" value="<?php echo esc_attr( $user->user_email ) ?>"/>
									</div>
									<div class="form-group">
										<label for="password"><?php esc_html_e( 'Password', 'couponis' ) ?></label>
										<input type="password" name="password" class="form-control" id="password" />
									</div>
									<div class="form-group">
										<label for="password_confirm"><?php esc_html_e( 'Confirm Password', 'couponis' ) ?></label>
										<input type="password" name="password_confirm" class="form-control" id="password_confirm" />
									</div>

									<div class="ajax-form-result"></div>
									<a href="javascript:;" class="btn submit-ajax-form"><?php esc_html_e( 'Update Profile', 'couponis' ) ?></a>

									<input type="hidden" name="action" value="update_profile">
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<?php get_sidebar( 'account' ) ?>
			</div>
		</div>
	</div>
</main>

<?php get_footer();  ?>