<div class="wrap">

	<h2><?php esc_html_e( 'Import / Export Custom Data From Theme', 'couponis' ) ?> </h2>


	<p><?php esc_html_e( 'Click button bellow to get JSON export of your created fields which you can later import back using form bellow', 'couponis' ) ?></p>
	<a href="<?php echo esc_url( add_query_arg( array( 'action' => 'export' ) ) ) ?>" class="button"><?php esc_html_e( 'Export', 'couponis' ) ?></a>
	<?php
	if( isset( $_GET['action'] ) && $_GET['action'] == 'export' ){
		couponis_export_cd_values();
	}
	?>

	<br /><br />
	<hr />

	<p><?php esc_html_e( 'Paste JSON of your custom data and click on import button', 'couponis' ) ?></p>
	<?php couponis_import_cd_values() ?>
	<form method="post" action="<?php echo esc_url( add_query_arg( array( 'action' => 'cd_import' ) ) ) ?>">
		<textarea name="couponis_custom_data" class="cd-import"></textarea>
		<input type="submit" class="button" value="<?php esc_attr_e( 'Import', 'couponis' ) ?>">
	</form>

</div>