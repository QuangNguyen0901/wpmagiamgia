<?php
/*
	Template Name: All Stores
*/
?>

<?php 
get_header();

$list_empt_cats_stores = couponis_get_option( 'list_empt_cats_stores' );
$page = (get_query_var('paged')) ? get_query_var('paged') : 1;

$per_page = 36;
$stores = get_terms(array( 
	'taxonomy'		=> 'coupon-store',
	'orderby'		=> 'name',
	'hide_empty' 	=> $list_empt_cats_stores == 'yes' ? true : false,
	'number'		=> $per_page,
	'offset'		=> ( $page - 1 ) * $per_page
));

$max_num = wp_count_terms( 'coupon-store', array(
'hide_empty' => $list_empt_cats_stores == 'yes' ? true : false,
) );
$max_pages = ceil( $max_num / $per_page );

$pagination = paginate_links( 
	array(
		'prev_next' 	=> false,
		'end_size' 		=> 2,
		'mid_size' 		=> 2,
		'total' 		=> $max_pages,
		'current' 		=> $page,	
		'prev_next' 	=> false
	)
);

get_template_part( 'includes/title' );
?>
<main>
	<div class="container">
		<div class="row">
			<?php
			if( !empty( $stores ) ){
				$counter = 0;
				foreach( $stores as $store ){
					if( $counter == 6 ){
						echo '</div><div class="row">';
						$counter = 0;
					}
					$counter++;
					
					include( get_theme_file_path( 'includes/stores/store-box.php' ) );
				}
			}
			?>
		</div>
		<?php if( !empty( $pagination ) ): ?>
			<div class="pagination">
				<?php echo $pagination; ?>
			</div>
		<?php endif; ?>
	</div>
</main>

<?php get_footer();  ?>