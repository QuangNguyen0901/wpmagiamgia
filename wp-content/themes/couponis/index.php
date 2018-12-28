<?php
/*=============================
	DEFAULT BLOG LISTING PAGE
=============================*/
get_header();
global $wp_query;

$cur_page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; //get curent page
$page_links_total =  $wp_query->max_num_pages;
$pagination = paginate_links( 
	array(
		'prev_next' => true,
		'end_size' => 2,
		'mid_size' => 2,
		'total' => $page_links_total,
		'current' => $cur_page,	
		'prev_next' => false
	)
);	

get_template_part( 'includes/title' );
?>

<main>	
	<div class="container">	
		<div class="row">
			<div class="col-sm-8">
				<?php 
				if( have_posts() ){
					while( have_posts() ){
						the_post();
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'white-block' ); ?>>

							<?php if( has_post_thumbnail() ): ?>
								<a href="<?php the_permalink() ?>" class="blog-item-media">
									<?php the_post_thumbnail( 'post-thumbnail' ) ?>
								</a>
							<?php endif; ?>

							<div class="white-block-content">

								<h3 class="blog-item-title">
									<a href="<?php the_permalink() ?>">
										<?php the_title(); ?>
									</a>
								</h3>

								<div class="blog-item-meta">
									<?php
									if( is_sticky() ){
										echo '<i class="fa fa-thumb-tack"></i>';
									}
									?>
									<?php esc_html_e( 'Written on', 'couponis' ) ?> <?php the_time( get_option( 'date_format' ) ) ?> <?php esc_html_e( 'in', 'couponis' ) ?> <?php echo couponis_get_category() ?>
								</div>	

								<?php the_excerpt(); ?>

								<a href="<?php the_permalink() ?>" class="continue-read">
									<?php esc_html_e( 'Continue reading', 'couponis' ) ?>
									<i class="fa fa-angle-right"></i>
								</a>
							</div>

						</article>
						<?php
					}
				}
				else{
					?>
					<div class="white-block">
						<div class="white-block-content">
							<h4 class="no-margin"><?php esc_html_e( 'No posts found matching your search criteria', 'couponis' ) ?></h4>
						</div>
					</div>
					<?php
				}
				?>
				<?php
				if( !empty( $pagination ) ){
					echo '<div class="pagination header-alike">'.$pagination.'</div>';
				}
				?>
			</div>
			<div class="col-sm-4">
				<?php get_sidebar() ?>
			</div>
		</div>
	</div>
</main>

<?php wp_reset_postdata(); ?>
<?php get_footer(); ?>