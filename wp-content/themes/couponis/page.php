<?php
get_header();
the_post();
get_template_part( 'includes/title' )
?>

<main>
	<div class="container">
		<div class="row">
			<div class="col-sm-8">
				<div class="white-block">
					<?php 
					if( has_post_thumbnail() ){
						the_post_thumbnail();
					} 
					?>
					<div class="white-block-single-content clearfix">
						<?php the_content(); ?>
					</div>
				</div>

				<?php comments_template( '', true ); ?>
			</div>
			<div class="col-sm-4">
				<?php get_sidebar('right') ?>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>