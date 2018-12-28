<?php

/*Fields array
array(
	array(
		'id' => ''
		'title' => ''
		'type' => ''
		if( type is select )
			'options' => array()
			'multiple' => false / true
		endif
		'default' => ''
	)
)
*/

if( !class_exists('Couponis_Widget') ){
class Couponis_Widget extends WP_Widget {
	
	public $properties;
	public $widget_instance;

	function __construct() {
		parent::__construct( 
			$this->properties['id'], 
			$this->properties['title'], 
			array('description' => $this->properties['description'] )
		);
	}

	function widget($args, $instance) {
		$defaults = array();
		if( !empty( $this->properties['fields'] ) ){
			foreach( $this->properties['fields'] as $field ){
				if( empty( $instance[$field['id']] ) ){
					if( !empty( $field['default'] ) ){
						$instance[$field['id']] = $field['default'];
					}
					else{
						if( $field['type'] == 'text' ){
							$instance[$field['id']] = '';
						}
						else if( $field['type'] == 'select' ){
							$instance[$field['id']] = array();	
						}
					}
				}

				if( !empty( $field['filter'] ) ){
					$instance[$field['id']] == apply_filters( $field['filter'], $instance[$field['id']], $instance, $this->id_base );
				}
			}
		}

		$this->widget_instance = $instance;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		if( !empty( $this->properties['fields'] ) ){
			foreach( $this->properties['fields'] as $field ){
				$instance[$field['id']] = strip_tags( $new_instance[$field['id']] );
			}
		}
		return $instance;
	}

	function form( $instance ) {
		if( !empty( $this->properties['fields'] ) ){
			foreach( $this->properties['fields'] as $field ){
				if( $field['type'] == 'text' ){
					$value = isset( $instance[$field['id']] ) ? $instance[$field['id']] : '';
					?>
					<p><label for="<?php echo esc_attr( $this->get_field_id( $field['id'] ) ); ?>"><?php echo  $field['title']; ?></label>
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $field['id'] ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $field['id'] ) ); ?>" type="text" value="<?php echo esc_attr( $value ); ?>" /></p>
					<?php
				}
				else if( $field['type'] == 'select' ){
					$values = isset( $instance[$field['id']] ) ? (array)$instance[$field['id']] : array();
					?>
					<p><label for="<?php echo esc_attr( $this->get_field_id( $field['id'] ) ); ?>"><?php echo  $field['title']; ?></label>
					<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( $field['id'] ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $field['id'] ) ); ?>" <?php echo !empty( $field['multiple'] ) && $field['multiple'] ? 'multiple="multiple"' : '' ?>>
						<?php
						if( !empty( $field['options'] ) ){
							foreach( $field['options'] as $value => $label ){
								?>
								<option value="<?php echo esc_attr( $value ) ?>" <?php echo in_array( $value, $values ) ? 'selected="selected"' : '' ?>><?php echo  $label ?></option>
								<?php
							}
						}
						?>
					</select></p>
					<?php
				}
			}
		}
	}

	function start_widget( $args, $title = '' ){
		extract( $args );
		echo  $before_widget;
		if ( $title ){
			echo  $before_title . $title . $after_title; 
		}
	}

	function end_widget( $args ){
		extract( $args );
		echo  $after_widget;
	}
}
}

if( !class_exists('Couponis_Posts') ){
class Couponis_Posts extends Couponis_Widget {
	function __construct(){
		$this->properties =	array(
			'id' 			=> 'custom_posts',
			'title' 		=> esc_html__('Couponis Recent Posts','couponis'),
			'description' 	=> esc_html__('Display recent posts','couponis'),
			'fields' 		=> array(
				array(
					'id' 		=> 'title',
					'title' 	=> esc_html__( 'Title', 'couponis' ),
					'type' 		=> 'text',
					'filter' 	=> 'widget_title'
				),
				array(
					'id' 		=> 'number',
					'title' 	=> esc_html__( 'Number', 'couponis' ),
					'type' 		=> 'text'
				),
			)
		);
		parent::__construct();
	}

	function widget( $args, $instance ) {
		parent::widget( $args, $instance );
		extract( $this->widget_instance );

		$this->start_widget( $args, $title );

		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		) ) );

		if ($r->have_posts()):
		?>
			<ul class="list-unstyled">
			<?php 
			while ( $r->have_posts() ) : 
				$r->the_post();
				?>
					<li class="flex-wrap">
						<div class="flex-left">
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( 'couponis-widget' ); ?>
							</a>
						</div>
						<div class="flex-right">
							<a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
							<ul class="list-unstyled list-inline post-meta small-action">
								<li>
									<i class="icon-clock"></i> <?php the_time( 'F j, Y' ) ?>
								</li>
								<li>
									<i class="icon-bubbles"></i> <?php comments_number( esc_html__( '0', 'couponis' ), esc_html__( '1', 'couponis' ), esc_html__( '%', 'couponis' ) ); ?>
								</li>								
							</ul>
						</div>
					</li>
				<?php
			endwhile; ?>
			</ul>
		<?php
		endif;

		wp_reset_postdata();
		$this->end_widget( $args );
	}
}
}

if( !class_exists('Couponis_Social') ){
class Couponis_Social extends Couponis_Widget{
	function __construct(){
		$this->properties =	array(
			'id' 			=> 'widget_social',
			'title' 		=> esc_html__('Couponis Social Follow','couponis'),
			'description' 	=> esc_html__('Adds list of the social icons','couponis'),
			'fields' 		=> array(
				array(
					'id' 		=> 'title',
					'title' 	=> esc_html__( 'Title', 'couponis' ),
					'type' 		=> 'text',
					'filter' 	=> 'widget_title'
				),
				array(
					'id' 		=> 'facebook',
					'title' 	=> esc_html__( 'Facebook', 'couponis' ),
					'type' 		=> 'text'
				),
				array(
					'id' 		=> 'twitter',
					'title' 	=> esc_html__( 'Twitter', 'couponis' ),
					'type' 	=> 'text'
				),
				array(
					'id' 		=> 'google',
					'title' 	=> esc_html__( 'Google+', 'couponis' ),
					'type' 		=> 'text'
				),
				array(
					'id' 		=> 'linkedin',
					'title' 	=> esc_html__( 'Linkedin', 'couponis' ),
					'type' 		=> 'text'
				),
				array(
					'id' 		=> 'pinterest',
					'title' 	=> esc_html__( 'Pinterest', 'couponis' ),
					'type' 		=> 'text'
				),
				array(
					'id' 		=> 'youtube',
					'title' 	=> esc_html__( 'YouTube', 'couponis' ),
					'type' 		=> 'text'
				),
				array(
					'id' 		=> 'instagram',
					'title' 	=> esc_html__( 'Instagram', 'couponis' ),
					'type' 		=> 'text'
				),
			)
		);
		parent::__construct();
	}

	function widget($args, $instance) {
		parent::widget( $args, $instance );
		extract( $this->widget_instance );

		$this->start_widget( $args, $title );

		$facebook = !empty( $facebook ) ? '<a href="'.esc_url( $facebook ).'" target="_blank" class="btn"><span class="icon-social-facebook"></span></a>' : '';
		$twitter = !empty( $twitter ) ? '<a href="'.esc_url( $twitter ).'" target="_blank" class="btn"><span class="icon-social-twitter"></span></a>' : '';
		$google = !empty( $google ) ? '<a href="'.esc_url( $google ).'" target="_blank" class="btn"><span class="icon-social-google"></span></a>' : '';
		$linkedin = !empty( $linkedin ) ? '<a href="'.esc_url( $linkedin ).'" target="_blank" class="btn"><span class="icon-social-linkedin"></span></a>' : '';
		$pinterest = !empty( $pinterest ) ? '<a href="'.esc_url( $pinterest ).'" target="_blank" class="btn"><span class="icon-social-pinterest"></span></a>' : '';
		$youtube = !empty( $youtube ) ? '<a href="'.esc_url( $youtube ).'" target="_blank" class="btn"><span class="icon-social-youtube"></span></a>' : '';
		$instagram = !empty( $instagram ) ? '<a href="'.esc_url( $instagram ).'" target="_blank" class="btn"><span class="icon-social-instagram"></span></a>' : '';

		echo '<div class="widget-social">';
			echo  $facebook.$twitter.$google.$linkedin.$pinterest.$youtube.$instagram;
		echo '</div>';
		
		$this->end_widget( $args );
	}
}
}

if( !class_exists('Couponis_Subscribe') ){
class Couponis_Subscribe extends Couponis_Widget{
	function __construct(){
		$this->properties =	array(
			'id' 			=> 'widget_subscribe',
			'title' 		=> esc_html__('Couponis Subscribe','couponis'),
			'description' 	=> esc_html__('Adds subscribe form in the sidebar','couponis'),
			'fields' 		=> array(
				array(
					'id' 		=> 'title',
					'title' 	=> esc_html__( 'Title', 'couponis' ),
					'type' 		=> 'text',
					'filter' 	=> 'widget_title'
				)
			)
		);
		parent::__construct();
	}

	function widget($args, $instance) {
		parent::widget( $args, $instance );
		extract( $this->widget_instance );

		$this->start_widget( $args, $title );

		echo '<div class="subscribe-form">
				<div class="couponis-form text-center">
					<h5>'.esc_html__( 'Receive best valued coupons on your mailbox', 'couponis' ).'</h5>
					<form class="ajax-form">
						<div class="couponis-form">
							<input type="text" class="form-control" name="email" placeholder="'.esc_attr__( 'Input email here...', 'couponis' ).'">
							<a href="javascript:;" class="btn submit-ajax-form"><i class="fa fa-rss"></i></a>
						</div>
						<div class="ajax-form-result"></div>
						<input type="hidden" name="action" value="subscribe" />
					</form>
				</div>
				<div class="sub_result"></div>
			  </div>';
		
		$this->end_widget( $args );
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title:', 'couponis') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $title ); ?>" />
		</p>	
		<?php
	}
}
}

if( !class_exists('Couponis_Image_Banner') ){
class Couponis_Image_Banner extends Couponis_Widget{
	function __construct(){
		$this->properties =	array(
			'id' 			=> 'widget_image_banner',
			'title' 		=> esc_html__('Couponis Image Banner','couponis'),
			'description' 	=> esc_html__('Add image with link','couponis'),
			'fields' 		=> array(
				array(
					'id' 		=> 'title',
					'title' 	=> esc_html__( 'Title', 'couponis' ),
					'type' 		=> 'text',
					'filter' 	=> 'widget_title'
				),
				array(
					'id' 		=> 'link',
					'title' 	=> esc_html__( 'Link', 'couponis' ),
					'type' 		=> 'text',
				),
				array(
					'id' 		=> 'image',
					'title' 	=> esc_html__( 'Image ID', 'couponis' ),
					'type' 		=> 'text',
				)
			)
		);
		parent::__construct();
	}

	function widget( $args, $instance ) {
		parent::widget( $args, $instance );
		extract( $this->widget_instance );

		$this->start_widget( $args, $title );

		echo '<div class="widget-content">';
			echo '<a href="'.esc_url( $link ).'" target="_blank" rel="nofollow">';
			echo wp_get_attachment_image( $image, 'full' );
			echo '</a>';
		echo '</div>';
		
		$this->end_widget( $args );
	}
}
}

if( !class_exists('Couponis_Coupons') ){
class Couponis_Coupons extends Couponis_Widget{
	function __construct(){
		$this->properties =	array(
			'id' 			=> 'widget_coupons',
			'title' 		=> esc_html__('Couponis Coupons By ID','couponis'),
			'description' 	=> esc_html__('List of coupons by ID','couponis'),
			'fields' 		=> array(
				array(
					'id' 		=> 'title',
					'title' 	=> esc_html__( 'Title', 'couponis' ),
					'type' 		=> 'text',
					'filter' 	=> 'widget_title'
				),
				array(
					'id' 		=> 'ids',
					'title' 	=> esc_html__( 'Coupon IDs', 'couponis' ),
					'type' 		=> 'text',
				)
			)
		);
		parent::__construct();
	}

	function widget( $args, $instance ) {
		parent::widget( $args, $instance );
		extract( $this->widget_instance );

		$this->start_widget( $args, $title );

		echo '<div class="widget-content"><ul class="list-unstyled">';
			if( !empty( $ids ) ){
				$coupons = new WP_Coupons_Query(array(
					'post_status'		=> 'publish',
					'posts_per_page'	=> -1,
					'post__in'			=> explode( ',', $ids )
				));
				if( $coupons->have_posts() ){
					while( $coupons->have_posts() ){
						$coupons->the_post();
						echo '<li>';
							couponis_get_coupon_image( 'couponis-grid' );
							echo '<a href="'.couponis_get_coupon_link().'" class="continue-read">'.get_the_title().'</a>';
						echo '</li>';
					}
				}
				wp_reset_postdata();
			}
		echo '</ul></div>';
		
		$this->end_widget( $args );
	}
}
}


if( !class_exists('Couponis_Latest_Coupons') ){
class Couponis_Latest_Coupons extends Couponis_Widget{
	function __construct(){
		$this->properties =	array(
			'id' 			=> 'widget_latest_coupons',
			'title' 		=> esc_html__('Couponis Latest Coupons','couponis'),
			'description' 	=> esc_html__('List of latest coupons','couponis'),
			'fields' 		=> array(
				array(
					'id' 		=> 'title',
					'title' 	=> esc_html__( 'Title', 'couponis' ),
					'type' 		=> 'text',
					'filter' 	=> 'widget_title'
				),
				array(
					'id' 		=> 'type',
					'title' 	=> esc_html__( 'Coupon Type', 'couponis' ),
					'type' 		=> 'select',
					'options'	=> array(
						''	=> esc_html__( 'All', 'couponis' ),
						'1'	=> esc_html__( 'Online Code', 'couponis' ),
						'2'	=> esc_html__( 'In Store Code', 'couponis' ),
						'3'	=> esc_html__( 'Online Sale', 'couponis' ),
					)
				),
				array(
					'id' 		=> 'number',
					'title' 	=> esc_html__( 'Coupons Number', 'couponis' ),
					'type' 		=> 'text',
				)
			)
		);
		parent::__construct();
	}

	function widget( $args, $instance ) {
		parent::widget( $args, $instance );
		extract( $this->widget_instance );

		$this->start_widget( $args, $title );

		echo '<div class="widget-content"><ul class="list-unstyled">';
			if( !empty( $number ) ){
				$coupons = new WP_Coupons_Query(array(
					'post_status'		=> 'publish',
					'posts_per_page'	=> $number,
					'orderby'			=> 'date',
					'order'				=> 'DESC',
					'type'				=> !empty( $type ) ? $type : ''
				));
				if( $coupons->have_posts() ){
					while( $coupons->have_posts() ){
						$coupons->the_post();
						echo '<li>';
							couponis_get_coupon_image( 'couponis-grid' );
							echo '<a href="'.couponis_get_coupon_link().'" class="continue-read">'.get_the_title().'</a>';
						echo '</li>';
					}
				}
				wp_reset_postdata();
			}
		echo '</ul></div>';
		
		$this->end_widget( $args );
	}
}
}

if( !class_exists('Couponis_Stores') ){
class Couponis_Stores extends Couponis_Widget{
	function __construct(){
		$this->properties =	array(
			'id' 			=> 'widget_stores',
			'title' 		=> esc_html__('Couponis Store','couponis'),
			'description' 	=> esc_html__('List of coupon stores','couponis'),
			'fields' 		=> array(
				array(
					'id' 		=> 'title',
					'title' 	=> esc_html__( 'Title', 'couponis' ),
					'type' 		=> 'text',
					'filter' 	=> 'widget_title'
				),
				array(
					'id' 			=> 'ids',
					'title' 		=> esc_html__( 'Store IDs', 'couponis' ),
					'type' 			=> 'text',
					'desscription'	=> esc_html__( 'Input comma separated list of store IDs', 'couponis' ),
				)
			)
		);
		parent::__construct();
	}

	function widget( $args, $instance ) {
		parent::widget( $args, $instance );
		extract( $this->widget_instance );

		$this->start_widget( $args, $title );

		echo '<div class="widget-content clearfix">';
			if( !empty( $ids ) ){
				$stores = get_terms( 'coupon-store', array( 'include' => $ids ) );
				if( !empty( $stores ) ){
					foreach( $stores as $store ){
						?>
						<a href="<?php echo esc_url( get_term_link( $store ) ) ?>">
							<?php echo couponis_get_coupon_store_logo( $store->term_id ) ?>
						</a>
						<?php
					}
				}
			}
		echo '</div>';
		
		$this->end_widget( $args );
	}
}
}

if( !class_exists('Couponis_Categories') ){
class Couponis_Categories extends Couponis_Widget{
	function __construct(){
		$this->properties =	array(
			'id' 			=> 'widget_categories',
			'title' 		=> esc_html__('Couponis Categories','couponis'),
			'description' 	=> esc_html__('List of coupon categories','couponis'),
			'fields' 		=> array(
				array(
					'id' 		=> 'title',
					'title' 	=> esc_html__( 'Title', 'couponis' ),
					'type' 		=> 'text',
					'filter' 	=> 'widget_title'
				),
				array(
					'id' 			=> 'ids',
					'title' 		=> esc_html__( 'Category IDs', 'couponis' ),
					'type' 			=> 'text',
					'desscription'	=> esc_html__( 'Input comma separated list of category IDs or leave empty to display all', 'couponis' ),
				)
			)
		);
		parent::__construct();
	}

	function widget( $args, $instance ) {
		parent::widget( $args, $instance );
		extract( $this->widget_instance );

		$this->start_widget( $args, $title );

		echo '<div class="widget-content"><ul class="list-unstyled">';
			if( !empty( $ids ) ){
				$arg = array( 'include' => $ids );
			}
			else{
				$arg = array( 'parent' => 0 );
			}

			$categories = get_terms( 'coupon-category', $arg );
			if( !empty( $categories ) ){
				foreach( $categories as $category ){
					$category_icon = get_term_meta( $category->term_id, 'category_icon', true );
					?>
					<li>
						<i class="fa fa-fw fa-<?php echo esc_attr( $category_icon ) ?>"></i>
						<a href="<?php echo esc_url( get_term_link( $category ) ) ?>">
							<?php echo  $category->name ?>
						</a>
						<span><?php echo  $category->count ?></span>
					</li>
					<?php
				}
			}
		echo '</ul></div>';
		
		$this->end_widget( $args );
	}
}
}

if( !class_exists('Couponis_Search_Coupon') ){
class Couponis_Search_Coupon extends Couponis_Widget{
	function __construct(){
		$this->properties =	array(
			'id' 			=> 'search_coupons',
			'title' 		=> esc_html__('Couponis Search','couponis'),
			'description' 	=> esc_html__('Search for coupons','couponis'),
			'fields' 		=> array(
				array(
					'id' 		=> 'title',
					'title' 	=> esc_html__( 'Title', 'couponis' ),
					'type' 		=> 'text',
					'filter' 	=> 'widget_title'
				)
			)
		);
		parent::__construct();
	}

	function widget( $args, $instance ) {
		parent::widget( $args, $instance );
		extract( $this->widget_instance );

		$this->start_widget( $args, $title );

		echo '<div class="widget-content">';
			include( get_theme_file_path( 'includes/coupons-search-box.php' ) );
		echo '</div>';
		
		$this->end_widget( $args );
	}
}
}

if( !class_exists('Couponis_Google_Ads') ){
class Couponis_Google_Ads extends Couponis_Widget{
	function __construct(){
		$this->properties =	array(
			'id' 			=> 'google_ads',
			'title' 		=> esc_html__('Couponis Google Ads','couponis'),
			'description' 	=> esc_html__('Print code set in Couponis WP -> Overall -> Google Ads Code ( For different Google Ad code use Custom HTML widget instead )','couponis'),
			'fields' 		=> array(
				array(
					'id' 		=> 'title',
					'title' 	=> esc_html__( 'Title', 'couponis' ),
					'type' 		=> 'text',
					'filter' 	=> 'widget_title'
				)
			)
		);
		parent::__construct();
	}

	function widget( $args, $instance ) {
		parent::widget( $args, $instance );
		extract( $this->widget_instance );

		$this->start_widget( $args, $title );

		echo '<div class="widget-content">';
			echo couponis_get_option( 'google_ads' );
		echo '</div>';
		
		$this->end_widget( $args );
	}
}
}

if( !function_exists('couponis_widgets_register') ){
function couponis_widgets_register() {
	if ( !is_blog_installed() ){
		return;
	}	
	/* register new ones */
	register_widget('Couponis_Posts');
	register_widget('Couponis_Social');
	register_widget('Couponis_Subscribe');
	register_widget('Couponis_Image_Banner');
	register_widget('Couponis_Coupons');
	register_widget('Couponis_Latest_Coupons');
	register_widget('Couponis_Stores');
	register_widget('Couponis_Categories');
	register_widget('Couponis_Search_Coupon');
	register_widget('Couponis_Google_Ads');
}

add_action('widgets_init', 'couponis_widgets_register', 20);
}
?>