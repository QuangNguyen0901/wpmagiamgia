<form method="get" class="searchform" action="<?php echo esc_url( home_url('/') ); ?>">
	<div class="couponis-form">
		<input type="text" value="" name="s" class="form-control" placeholder="<?php esc_attr_e( 'Search for...', 'couponis' ); ?>">
		<input type="hidden" name="post_type" value="post" />
		<a class="btn submit_form"><i class="fa fa-search"></i></a>
	</div>
</form>