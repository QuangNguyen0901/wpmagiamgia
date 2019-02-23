<?php
/*
	Template Name: Page Contact
*/
get_header();
the_post();

get_template_part( 'includes/title' ); 

$agreement_text = couponis_get_option( 'agreement_text' );
?>

<main>
	<div class="container">
		<div class="white-block">

			<?php
			$markers = couponis_get_option( 'markers' );
			if( !empty( $markers ) ):
			?>
			<div class="contact-map hidden">
				<?php
				echo json_encode( $markers );
				?>
			</div>
			<?php endif; ?>

			<div class="white-block-single-content">
				<div class="post-content clearfix">
					<?php the_content(); ?>
				</div>

				<div class="row">
					<div class="col-sm-8 col-sm-push-2">
						<form class="ajax-form needs-captcha">
							<div class="form-group has-feedback">
								<label for="name"><?php esc_html_e( 'Your Name', 'couponis' ) ?> *</label>
								<input type="text" class="form-control name" id="name" name="name" />
							</div>
							<div class="form-group has-feedback">
								<label for="name"><?php esc_html_e( 'Your Email', 'couponis' ) ?> *</label>
								<input type="text" class="form-control email" id="email" name="email" />
							</div>
							<div class="form-group has-feedback">
								<label for="name"><?php esc_html_e( 'Message Subject', 'couponis' ) ?> *</label>
								<input type="text" class="form-control subject" id="subject" name="subject" />
							</div>
							<div class="form-group has-feedback">
								<label for="name"><?php esc_html_e( 'Message', 'couponis' ) ?> *</label>
								<textarea rows="10" cols="100" class="form-control message" id="message" name="message"></textarea>
							</div>
							<?php if( !empty( $agreement_text ) ): ?>
								<div class="form-group has-feedback agreement-box">
									<input type="checkbox" name="agree" id="agree" value="1">
									<div class="flex-right">
										<?php echo apply_filters( 'the_content', $agreement_text ) ?>
									</div>
								</div>								
							<?php endif; ?>
							
							<div class="ajax-form-result"></div>
							<a href="javascript:;" class="btn submit-ajax-form"><?php esc_html_e( 'Send Message', 'couponis' ) ?> </a>

							<input type="hidden" name="action" value="contact">

						</form>	
					</div>
				</div>

			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>