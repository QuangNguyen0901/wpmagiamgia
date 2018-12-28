<?php
/*=============================
	DEFAULT SINGLE
=============================*/
get_header();
the_post();

$post_pages = wp_link_pages( 
	array(
		'before' => '',
		'after' => '',
		'link_before'      => '<span>',
		'link_after'       => '</span>',
		'next_or_number'   => 'number',
		'nextpagelink'     => esc_html__( '&raquo;', 'couponis' ),
		'previouspagelink' => esc_html__( '&laquo;', 'couponis' ),			
		'separator'        => ' ',
		'echo'			   => 0
	) 
);

$blog_single_sidebar = couponis_get_option( 'blog_single_sidebar' );

?>

<main>
	<div class="container">
		<div class="row">
			<div class="col-sm-8">
				<div class="white-block">

					<?php if( has_post_thumbnail() ): ?>
						<div class="text-center">
							<?php the_post_thumbnail( 'post-thumbnail' ) ?>
						</div>
					<?php endif; ?>

					<div class="white-block-single-content">

						<h1 class="blog-item-title h2-size">
							<a href="<?php the_permalink() ?>">
								<?php the_title(); ?>
							</a>
						</h1>

						<div class="blog-item-meta">
							<?php
							if( is_sticky() ){
								echo '<i class="fa fa-thumb-tack"></i>';
							}
							?>
							<?php 
								esc_html_e( 'Written on ', 'couponis' );
								the_time( get_option( 'date_format' ) );
								esc_html_e( ' in ', 'couponis' );
								echo couponis_get_category();
								esc_html_e( ' by ', 'couponis' );
							?>
								<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"> 
									<?php echo get_the_author_meta('display_name'); ?>
								</a>
						</div>	

						<div class="post-content clearfix">
							<?php the_content(); ?>	
						</div>

						<?php if( !empty( $post_pages ) ): ?>	
							<div class="pagination">
								<?php echo $post_pages; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>

				<?php
				$tags = couponis_the_tags();
				if( !empty( $tags ) ):
				?>
					<div class="white-block">
						<div class="white-block-single-content">
							<div class="tag-section">
								<i class="icon-tag"></i> <?php echo  $tags; ?>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<?php comments_template( '', true ) ?>

			</div>
			<div class="col-sm-4">
				<?php get_sidebar() ?>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>