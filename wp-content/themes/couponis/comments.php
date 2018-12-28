<?php if ( comments_open() ) :?>
<div id="comments">
	<?php $comments_count = wp_count_comments();  ?>
	<?php if( $comments_count->total_comments > 0 ): ?>
		<div class="white-block">
			<div class="white-block-single-content">

				<!-- title -->
				<div class="widget-title">
					<h4><?php comments_number( esc_html__( 'No Comments', 'couponis' ), esc_html__( '1 Comment', 'couponis' ), esc_html__( '% Comments', 'couponis' ) ); ?></h4>
				</div>
				<!--.title -->
		
				<!-- comments -->
				<div class="comment-content comments">
					<?php if( have_comments() ): ?>
						<?php wp_list_comments( array(
							'callback' => 'couponis_comments',
							'end-callback' => 'couponis_end_comments',
							'style' => 'div'
						)); ?>
					<?php endif; ?>
				</div>
				<!-- .comments -->
		
				<!-- comments pagination -->
				<?php
					$comment_links = paginate_comments_links( 
						array(
							'echo' => false,
							'type' => 'array',
							'prev_next' => false,
							'separator' => ' ',
						) 
					);
					if( !empty( $comment_links ) ):
				?>
					<div class="comments-pagination-wrap">
						<div class="pagination">
							<?php esc_html_e( 'Comment page: ', 'couponis');  echo couponis_format_pagination( $comment_links ); ?>
						</div>
					</div>
				<?php endif; ?>
				<!-- .comments pagination -->
			</div>
		</div>
	<?php endif; ?>
	<div class="white-block">
		<div class="white-block-single-content">

			<div class="widget-title">
				<h4><?php esc_html_e( 'Leave Comment', 'couponis' ); ?></h4>
			</div>

			<div id="contact_form">
				<?php
					$comments_args = array(
						'label_submit'	=>	esc_html__( 'Send Comment', 'couponis' ),
						'title_reply'	=>	'',
						'fields'		=>	apply_filters( 'comment_form_default_fields', array(
												'author' => '<div class="row"><div class="col-sm-4"><div class="form-group has-feedback">
																<input type="text" class="form-control" id="name" name="author" placeholder="'.esc_html__( 'Name', 'couponis' ).' *">
															</div></div>',
												'email'	 => '<div class="col-sm-4"><div class="form-group has-feedback">
																<input type="text" class="form-control" id="email" name="email" placeholder="'.esc_html__( 'Email', 'couponis' ).' *">
															</div></div>',
												'url'	 => '<div class="col-sm-4"><div class="form-group has-feedback">
																<input type="text" class="form-control" id="url" name="url" placeholder="'.esc_html__( 'Website', 'couponis' ).'">
															</div></div></div>',

											)),
						'comment_field'	=>	'<div class="form-group has-feedback">
												<textarea rows="10" cols="100" class="form-control" id="comment" name="comment" placeholder="'.esc_html__( 'Comment', 'couponis' ).' *"></textarea>															
											</div>',
						'cancel_reply_link' => esc_html__( 'or cancel reply', 'couponis' ),
						'comment_notes_after' => '',
						'comment_notes_before' => ''
					);
					comment_form( $comments_args );	
				?>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>