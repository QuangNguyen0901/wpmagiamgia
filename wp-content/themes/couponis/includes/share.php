<?php 
if( couponis_get_option( 'enable_share' ) == 'yes' ):
	if( !empty( $coupon_id ) ){
		$share_post_id = $coupon_id;
	}
	else{
		$share_post_id = get_the_ID();
	}
	?>
	<div class="post-share">
		<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode( get_permalink( $share_post_id ) ); ?>" class="share facebook" target="_blank" title="<?php esc_attr_e( 'Share on Facebook', 'couponis' ); ?>"><i class="fa fa-facebook fa-fw"></i></a>
		<a href="http://twitter.com/intent/tweet?source=<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>&amp;text=<?php echo rawurlencode( get_permalink( $share_post_id ) ); ?>" class="share twitter" target="_blank" title="<?php esc_attr_e( 'Share on Twitter', 'couponis' ); ?>"><i class="fa fa-twitter fa-fw"></i></a>
		<a href="https://plus.google.com/share?url=<?php echo rawurlencode( get_permalink( $share_post_id ) ); ?>" class="share google" target="_blank" title="<?php esc_attr_e( 'Share on Google+', 'couponis' ); ?>"><i class="fa fa-google fa-fw"></i></a>
		<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo rawurlencode( get_permalink( $share_post_id ) ); ?>&amp;title=<?php echo rawurlencode( get_the_title( $share_post_id ) ); ?>&amp;source=<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="share linkedin" target="_blank" title="<?php esc_attr_e( 'Share on LinkedIn', 'couponis' ); ?>"><i class="fa fa-linkedin fa-fw"></i></a>
		<a href="http://www.tumblr.com/share/link?url=<?php echo rawurlencode( get_permalink( $share_post_id ) ); ?>&amp;name=<?php echo rawurlencode( get_the_title( $share_post_id ) ); ?>" class="share tumblr" target="_blank" title="<?php esc_attr_e( 'Share on Tumblr', 'couponis' ); ?>"><i class="fa fa-tumblr fa-fw"></i></a>
	</div>
<?php endif; ?>