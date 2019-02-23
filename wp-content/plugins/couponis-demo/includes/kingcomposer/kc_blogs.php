<?php
extract( shortcode_atts( array(
	'source' 				=> '',
	'post_ids' 				=> '',
	'post_categories' 		=> '',
	'post_tags' 			=> '',
	'number' 				=> 5,
	'orderby' 				=> 'date',
	'order' 				=> 'ASC',
	'number_in_row' 		=> 3,
), $atts ) );	

$args = array(
	'post_status'	=> 'publish',
	'post_type'		=> 'post'
);

if( $source == 'post_ids' ){
	$args['post__in'] = explode( ',', $post_ids );
	$args['order_by'] = 'post__in';
}
else if( $source == 'categories' ){
	$args['category__in'] = explode( ',', $post_categories );
}
else if( $source == 'tags' ){
	$args['tag__in'] = explode( ',', $post_tags );
}

if( $source == 'categories' || $source == 'tags' || $source == 'latest' ){
	$args['posts_per_page']	= $number;
	$args['orderby'] = $orderby;
	$args['order'] = $order;
}

$posts = new WP_Query( $args );
if( $posts->have_posts() ){
	?>
	<div class="row">
		<?php
		while( $posts->have_posts() ){
			$posts->the_post();
			?>
			<div class="col-sm-<?php echo esc_attr( 12 / $number_in_row ) ?>">
				<div class="white-block blog-shortcode">
					<?php if( has_post_thumbnail() ): ?>
						<div class="blog-media">
							<?php the_post_thumbnail( 'couponis-grid' ) ?>
						</div>
					<?php endif; ?>
					<div class="white-block-content">
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

						<h4>
							<a href="<?php the_permalink() ?>">
								<?php the_title(); ?>
							</a>
						</h4>

						<?php 
						$excerpt = get_the_excerpt();
						if( strlen( $excerpt ) > 110 ){
							$excerpt = substr( $excerpt, 0, 110 );
							$temp = explode( ' ', $excerpt );
							unset( $temp[sizeof($temp) - 1] );
							$excerpt = join( ' ', $temp ).'...';
						}

						echo esc_html( $excerpt );
						?>
					</div>
				</div>
			</div>
			<?php
		}
		?>
	</div>
	<?php
}
wp_reset_postdata();
?>