<?php
/*
	Template Name: All Stores Alt
*/
?>

<?php 
get_header();

$letter_keyed_shops = array();
$shops_lettered = array();
$shop_letter_links = '';

$letters = couponis_fetch_store_letters();
if( !empty( $letters ) ){
	foreach( $letters as $letter ){
		if( !isset( $shops_lettered[$letter] ) ){
			$shop_letter_links .= '<li><a href="#id_'.$letter.'" class="letter-search">'.$letter.'</a></li>';
			$shops_lettered[$letter] = array();
		}
		$stores = couponis_fetch_stores_by_letter( $letter );
		$found_posts = couponis_fetch_found_stores_by_letter();
		if( !empty( $stores ) ){
			foreach( $stores as $store ){
				ob_start();
				include( get_theme_file_path( 'includes/stores/store-box.php' ) );
				$shops_lettered[$letter]['content'][] = ob_get_contents();
				ob_end_clean();
			}
			if( $found_posts > 6 ){
				$shops_lettered[$letter]['pagination'] = '<a href="#" data-letter="'.esc_attr( $letter ).'" class="stores-alt-load-all">'.esc_html__( 'LOAD ALL', 'couponis' ).'</a>';
			}
		}
	}
}

get_template_part( 'includes/title' );
?>
<main>
	<div class="container">
		<div class="store-search">
			<div class="white-block">
				<ul class="list-unstyled list-inline store-letter-filter">
					<?php echo $shop_letter_links; ?>
					<li class="pull-right">
						<a href="#" class="search-store-toggle">
							<i class="icon-magnifier"></i>
						</a>
					</li>
				</ul>
				<div class="form-group search-store">
					<input type="text" id="store_name" class="form-control" placeholder="<?php esc_attr_e( 'Search for store...', 'couponis' ) ?>"/>
					<i class="fa fa-circle-o-notch fa-spin"></i>
				</div>
			</div>	

			<div class="stores-search-results">
				<div class="letter-title">
					<h3><?php esc_html_e( 'Search resuls', 'couponis' ) ?></h3>
				</div>				
				<div class="stores-list"></div>	
			</div>
		</div>

		<?php
		if( !empty( $shops_lettered ) ){
			foreach( $shops_lettered as $letter => $stores ){
				?>
				<div class="letter-title" id="id_<?php echo esc_attr( $letter ) ?>">
					<h3><?php echo $letter ?></h3>
					<a href="#" class="store-letter-top">
						<i class="icon-arrow-up"></i>
					</a>
				</div>
				<?php
				couponis_print_alt_stores( $stores['content'] );
				if( !empty( $stores['pagination'] ) ){
					?>
					<div class="pagination header-alike stores-alt-pagination">
						<?php echo $stores['pagination']; ?>
					</div>
					<?php
				}
			}
		}
		?>

	</div>
</main>

<?php get_footer();  ?>