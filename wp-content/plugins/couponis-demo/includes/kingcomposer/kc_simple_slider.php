<?php if( !empty( $atts['slides'] ) ): ?>
	<div class="simple-slider">
		<?php
		foreach( $atts['slides'] as $slide ){
			echo '<div class="simple-slider-item">';
				echo wp_get_attachment_image( $slide->image, $atts['image_size'] );
				if( !empty( $slide->title ) || !empty( $slide->subtitle ) ){
					echo '<div class="simple-slider-caption flex-wrap">';
						echo '<div class="flex-left">';
							if( !empty( $slide->title ) ){
								echo '<h2>'.$slide->title.'</h2>';
							}
							if( !empty( $slide->subtitle ) ){
								echo '<p>'.$slide->subtitle.'</p>';
							}
						echo '</div>';
						echo '<div class="flex-right">';
							if( !empty( $slide->link ) ){
								echo '<a href="'.esc_url( $slide->link ).'" target="_blank" rel="nofollow" class="btn">'.$slide->link_text.'</a>';
							}
						echo '</div>';
					echo '</div>';
				}
			echo '</div>';
		}
		?>
	</div>
<?php endif ?>