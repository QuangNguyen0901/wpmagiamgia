<?php if ( is_category() || is_tag() || is_author() || is_archive() || is_search() ): ?>
	<div class="main-title">
		<div class="container">
			<div class="flex-wrap">
				<div class="flex-left">
					<h1 class="h3-size">
						<?php 
							if ( is_category() ){
								echo esc_html__('Category: ', 'couponis');
								single_cat_title();
							}
							else if( is_tag() ){
								echo esc_html__('Search by tag: ', 'couponis'). get_query_var('tag'); 
							}
							else if( is_author() ){
								echo esc_html__('Posts by: ', 'couponis'). get_the_author_meta( 'display_name' ); 
							}
							else if( is_archive() ){
								echo esc_html__('Archive for: ', 'couponis'). single_month_title(' ',false); 
							}
							else if( is_search() ){ 
								echo esc_html__('Search results for: ', 'couponis').' '. get_search_query();
							}
						?>
					</h1>
				</div>
				<div class="flex-right">
					<?php echo couponis_breadcrumbs() ?>
				</div>
			</div>
		</div>
	</div>
<?php elseif( !is_home() ): ?>
	<div class="main-title">
		<div class="container">
			<div class="flex-wrap">
				<div class="flex-left">
					<h1 class="h3-size"><?php the_title(); ?></h1>
				</div>
				<div class="flex-right">
					<?php echo couponis_breadcrumbs() ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>	
<?php include( get_theme_file_path( 'includes/advertise.php' ) ); ?>