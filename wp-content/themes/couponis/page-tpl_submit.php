<?php
/*
	Template Name: Submit Coupon
*/
if( !is_user_logged_in() ){
	wp_redirect( home_url('/#login') );
}
else if( couponis_get_option( 'can_submit' ) == 'no' ){
	wp_redirect( home_url('/') );
}
?>
<?php 
get_header();
the_post();

get_template_part( 'includes/title' );
$coupon_types = couponis_get_option( 'coupon_types' );
$ajax_taxonomy = couponis_get_option( 'ajax_taxonomy' );
?>

<main>
	<div class="container">
		<div class="row">
			<div class="col-sm-8">

				<div class="white-block">
					<div class="white-block-single-content">

						<form class="ajax-form">
							<div class="row">

								<div class="col-sm-6">
									<div class="form-group stores-display">
										<label for="store-2"><?php esc_html_e( 'Store', 'couponis' ) ?> *</label>

										<div class="styled-select <?php echo $ajax_taxonomy == 'yes' ? esc_attr( 'select2-styled' ) : '' ?>">
											<select name="store" id="store-s" class="<?php echo $ajax_taxonomy == 'yes' ? esc_attr( 'launch-select2' ) : '' ?>" data-taxonomy="coupon-store">
												<option value=""><?php esc_html_e( '- Select -', 'couponis' ) ?></option>
												<?php 
												if( $ajax_taxonomy != 'yes' ){
													$stores = couponis_get_hierarchical_terms( 'coupon-store', false );
													couponis_list_terms_select( $stores );
												}
												?>												
											</select>
										</div>
									</div>
									<div class="form-group stores-hidden hidden">
										<div class="row">
											<div class="col-sm-6">
												<label for="new_store_name"><?php esc_html_e( 'Store Name', 'couponis' ) ?> *</label>
												<input type="text" class="form-control" name="new_store_name" id="new_store_name" />
											</div>
											<div class="col-sm-6">
												<label for="new_store_link"><?php esc_html_e( 'Store Link', 'couponis' ) ?> *</label>
												<input type="text" class="form-control" name="new_store_link" id="new_store_link" />
											</div>
										</div>
									</div>

									<div class="styled-checkbox small-action">
										<input type="checkbox" name="no_store" id="no_store" />
										<label for="no_store"><?php esc_html_e( 'Can\'t Find A Store?', 'couponis' ) ?></label>
									</div>

								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label for="category-2"><?php esc_html_e( 'Category', 'couponis' ) ?> *</label>
										<div class="styled-select <?php echo $ajax_taxonomy == 'yes' ? esc_attr( 'select2-styled' ) : '' ?>">
											<select name="category" id="category-s" class="<?php echo $ajax_taxonomy == 'yes' ? esc_attr( 'launch-select2' ) : '' ?>" data-taxonomy="coupon-category">
												<option value=""><?php esc_html_e( '- Select -', 'couponis' ) ?></option>
												<?php 
												if( $ajax_taxonomy != 'yes' ){
													$categories = couponis_get_hierarchical_terms( 'coupon-category', false );
													couponis_list_terms_select( $categories );
												}
												?>
											</select>
										</div>
									</div>
								</div>

							</div>
							<div class="row">

								<div class="col-sm-6">
									<div class="form-group">
										<label for="type"><?php esc_html_e( 'Coupon Type', 'couponis' ) ?> *</label>
										<div class="styled-select">
											<select name="type" id="type">
												<?php if( empty( $coupon_types ) || in_array( '1', $coupon_types ) ): ?>
													<option value="1"><?php esc_html_e( 'Online Code', 'couponis' ) ?></option>
												<?php endif; ?>
												<?php if( empty( $coupon_types ) || in_array( '2', $coupon_types ) ): ?>
													<option value="2"><?php esc_html_e( 'In Store Code', 'couponis' ) ?></option>
												<?php endif; ?>
												<?php if( empty( $coupon_types ) || in_array( '3', $coupon_types ) ): ?>
													<option value="3"><?php esc_html_e( 'Online Sale', 'couponis' ) ?></option>
												<?php endif; ?>
											</select>
										</div>
									</div>
								</div>

								<div class="col-sm-6">
									<?php if( empty( $coupon_types ) || in_array( '1', $coupon_types ) ): ?>
										<div class="form-group type-1 hidden">
											<label for="coupon_code"><?php esc_html_e( 'Coupon Code', 'couponis' ) ?> *</label>
											<input type="text" name="coupon_code" id="coupon_code" class="form-control" />
										</div>
									<?php endif; ?>
									<?php if( empty( $coupon_types ) || in_array( '2', $coupon_types ) ): ?>
										<div class="form-group type-2 hidden">
											<label for="coupon_printable"><?php esc_html_e( 'Coupon Image', 'couponis' ) ?> *</label>
											<input type="file" name="coupon_printable" id="coupon_printable" class="form-control" />
										</div>
									<?php endif; ?>
									<?php if( empty( $coupon_types ) || in_array( '3', $coupon_types ) ): ?>
										<div class="form-group type-3 hidden">
											<label for="coupon_url"><?php esc_html_e( 'Sale Link', 'couponis' ) ?> *</label>
											<input type="text" name="coupon_url" id="coupon_url" class="form-control" />
										</div>
									<?php endif; ?>
								</div>

							</div>
							<div class="row">

								<div class="col-sm-6">
									<div class="form-group">
										<label for="featured_image"><?php esc_html_e( 'Featured Image', 'couponis' ) ?></label>
										<input type="file" name="featured_image" id="featured_image" class="form-control" />
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label for="expire"><?php esc_html_e( 'Expire Date', 'couponis' ) ?> *</label>
										<input type="text" name="expire" id="expire" class="form-control" />
									</div>
									<div class="styled-checkbox small-action">
										<input type="checkbox" name="no_expire" id="no_expire" />
										<label for="no_expire"><?php esc_html_e( 'I do not know expire date', 'couponis' ) ?></label>
									</div>
								</div>

							</div>
							<div class="row">

								<div class="col-sm-6">
									<div class="form-group">
										<label for="title"><?php esc_html_e( 'Coupon Title', 'couponis' ) ?> *</label>
										<input type="text" name="title" id="title" class="form-control" />
									</div>
								</div>

								<div class="col-sm-6">
									<label>&nbsp;</label>
									<div class="styled-checkbox exclusive-check">
										<input type="checkbox" name="exclusive" id="exclusive" />
										<label for="exclusive"><?php esc_html_e( 'Is Exclusive?', 'couponis' ) ?></label>
									</div>
								</div>

							</div>

							<div class="form-group">
								<label for="description"><?php esc_html_e( 'Coupon Description', 'couponis' ) ?> *</label>
								<textarea name="description" id="description" class="form-control"></textarea>
							</div>

							<div class="ajax-form-result"></div>
							<a href="javascript:;" class="btn submit-ajax-form"><?php esc_html_e( 'Submit Coupon', 'couponis' ) ?></a>

							<input type="hidden" name="action" value="submit">

						</form>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<?php get_sidebar( 'submit' ) ?>
			</div>
		</div>
	</div>
</main>

<?php get_footer();  ?>