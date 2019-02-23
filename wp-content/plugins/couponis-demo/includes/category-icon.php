<?php

/* Custom Meta For Taxonomies */
/* Adding New */
if( !function_exists('couponis_category_icon_add') ){
function couponis_category_icon_add() {
	echo '
	<div class="form-field">
		<label for="category_image">'.esc_html__( 'Icon:', 'couponis' ).'</label>
		<select name="category_icon">
			'.couponis_category_icon_list().'
		</select>
		<p class="description">'.esc_html__( 'Select icon for the category','couponis' ).'</p>
	</div>
	<div class="form-field">
		<input type="checkbox" name="category_hide" id="category_hide" />
		<label for="category_hide">'.esc_html__( 'Hide From All Categories', 'couponis' ).'</label>
		<p class="description">'.esc_html__( 'Hide this categry from showing on all categories page','couponis' ).'</p>
	</div>
	';
}
add_action( 'coupon-category_add_form_fields', 'couponis_category_icon_add', 10, 2 );
}

/*
Create options for category icon selection
*/
if( !function_exists( 'couponis_category_icon_list' )){
function couponis_category_icon_list( $selected = '' ){
	$icons = couponis_awesome_icons_list();
	$list = '';
	foreach( $icons as $icon ){
		$list .= '<option value="'.esc_attr( $icon ).'" '.( $selected == $icon ? 'selected="selected"' : '' ).'>'.$icon.'</option>';
	}

	return $list;
}
}

/* Editing */
if( !function_exists('couponis_category_icon_edit') ){
function couponis_category_icon_edit( $term ) {
	$category_icon = get_term_meta( $term->term_id, 'category_icon', true );
	$category_hide = get_term_meta( $term->term_id, 'category_hide', true );
	?>
	<table class="form-table">
		<tbody>
			<tr class="form-field form-required">
				<th scope="row"><label for="category_icon"><?php esc_html_e( 'Image', 'couponis' ); ?></label></th>
				<td>
					<select name="category_icon">
						<?php echo couponis_category_icon_list( $category_icon ) ?>
					</select>
					<p class="description"><?php esc_html_e( 'Select icon for the category', 'couponis' ); ?></p>
				</td>
			</tr>
			<tr class="form-field form-required">
				<th scope="row"><label for="category_hide"><?php esc_html_e( 'Hide From All Categories', 'couponis' ); ?></label></th>
				<td>
					<input type="checkbox" name="category_hide" id="category_hide" <?php checked( 1, $category_hide ) ?>> 
					<p class="description"><?php esc_html_e( 'Hide this categry from showing on all categories page', 'couponis' ); ?></p>
				</td>
			</tr>
		</tbody>
	</table>
	<?php
}
add_action( 'coupon-category_edit_form_fields', 'couponis_category_icon_edit', 10, 2 );
}

/* Save It */
if( !function_exists('couponis_category_icon_save') ){
function couponis_category_icon_save( $term_id ) {
	if ( isset( $_POST['category_icon'] ) ) {
		update_term_meta( $term_id, 'category_icon', $_POST['category_icon'] );
	}
	else if( $_POST['action'] !== 'inline-save-tax' ){
		delete_term_meta( $term_id, 'category_icon' );
	}
	if ( isset( $_POST['category_hide'] ) ) {
		update_term_meta( $term_id, 'category_hide', '1' );
	}
	else if( $_POST['action'] !== 'inline-save-tax' ){
		delete_term_meta( $term_id, 'category_hide' );
	}
}  
add_action( 'edited_coupon-category', 'couponis_category_icon_save', 10, 2 );  
add_action( 'create_coupon-category', 'couponis_category_icon_save', 10, 2 );
}


/* Add icon column */
if( !function_exists('couponis_category_column') ){
function couponis_category_column( $columns ) {
    $new_columns = array(
        'cb' 			=> '<input type="checkbox" />',
        'name' 			=> esc_html__('Name', 'couponis'),
		'description' 	=> esc_html__('Description', 'couponis'),
        'slug' 			=> esc_html__( 'Slug', 'couponis' ),
        'posts' 		=> esc_html__( 'Posts', 'couponis' ),
		'category_icon' => esc_html__( 'Icon', 'couponis' )
        );
    return $new_columns;
}
add_filter("manage_edit-coupon-category_columns", 'couponis_category_column'); 
}

if( !function_exists('couponis_populate_category_column') ){
function couponis_populate_category_column( $out, $column_name, $term_id ){
    switch ( $column_name ) {  	
 		case 'category_icon':
			$category_icon = get_term_meta( $term_id, 'category_icon', true );
            $out .= '<i class="fa fa-'.esc_attr( $category_icon ).'"></i>';
            break;
        default:
            break;
    }

    return $out; 
}
add_filter("manage_coupon-category_custom_column", 'couponis_populate_category_column', 10, 3);
}
?>