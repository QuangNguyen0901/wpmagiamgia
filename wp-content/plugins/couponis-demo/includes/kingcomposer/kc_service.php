<div class="white-block service <?php echo esc_attr( $atts['style'] ) ?>">
	<div class="white-block-content">
		<?php 
		if( !empty( $atts['icon'] ) ){
			$style = '';
			if( !empty( $atts['icon_bg_color'] ) || !empty( $atts['icon_font_color'] ) ){
				$style = 'style="background: '.esc_attr( $atts['icon_bg_color'] ).'; color: '.esc_attr( $atts['icon_font_color'] ).'"';
			}
			echo '<div class="service-icon" '.$style.'><i class="'.esc_attr( $atts['icon'] ).'"></i></div>';
		}
		?>
		<div class="service-content">
			<?php
			$title = !empty( $atts['link'] ) ? '<a href="'.esc_url( $atts['link'] ).'">'.$atts['title'].'</a>' : $atts['title'];
			?>
			<?php echo !empty( $atts['title'] ) ? '<h4>'.$title.'</h4>' : ''; ?>
			<?php echo !empty( $atts['subtitle'] ) ? '<p>'.$atts['subtitle'].'</p>' : ''; ?>
		</div>
	</div>
</div>