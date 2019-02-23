jQuery(document).ready(function($){
	"use strict";
	/* handle image */
	function handle_images( frameArgs, callback ){
		var SM_Frame = wp.media( frameArgs );

		SM_Frame.on( 'select', function() {

			callback( SM_Frame.state().get('selection') );
			SM_Frame.close();
		});

		SM_Frame.open();	
	}		

	function imageExists(url, callback) {
		var img = new Image();
		img.onload = function() { callback(true); };
		img.onerror = function() { callback(false); };
		img.src = url;
	}	

	$(document).on( 'click', '.add_store_image', function(e) {
		e.preventDefault();
		var $this=  $(this);

		var frameArgs = {
			multiple: false,
			title: 'Select Image'
		};

		handle_images( frameArgs, function( selection ){
			var model = selection.first();
			$this.parent().find('input').val( model.id );
			var img = model.attributes.url;
			var ext = img.substring(img.lastIndexOf('.'));
			img = img.replace( ext, '-150x150'+ext );
			imageExists( img, function(exists){
				if( exists ){
					$('.image-holder').html( '<img src="'+img+'"><a href="javascript:;" class="button remove_store_image">X</a>' );
				}
				else{
					$('.image-holder').html( '<img src="'+model.attributes.url+'"><a href="javascript:;" class="button remove_store_image">X</a>' );
				}

			} );			
			
		});
	});	

	$(document).on( 'click', '.remove_store_image', function(){
		$(this).parents('td').find('input').val( '' );
		$('.image-holder').html('');
	} );
});