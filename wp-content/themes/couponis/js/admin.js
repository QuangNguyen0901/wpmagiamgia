jQuery(document).ready(function($){
	"use strict";
	$(document).on( 'click', '.google-api-dismiss .notice-dismiss', function(){
		$.ajax({
			url: ajaxurl,
			data: {
				action: 'google_api_dismiss'
			}
		})
	});

	function show_type_fields( type ){
		if( type == 1 ){
			$('#coupon_code').show();
		}
		else if( type == 2 ){
			$('#coupon_printable').show();
		}
		else{
			$('#coupon_url').show();
		}
	}

	if( $('#ctype') ){
		show_type_fields( $('#ctype select').val() );

		$(document).on( 'change', '#ctype select', function(){
			$('#coupon_code, #coupon_url, #coupon_printable').hide();
			show_type_fields( $(this).val() );
		});
	}

	/* MARKER MANAGMENT */
	$(document).on( 'click', '.add-store-marker', function(e){
		e.preventDefault()
		var $last = $('.store-marker-wrap:last');
		var $clone = $last.clone();
		$clone.find('input').val('');
		$last.after( $clone );
	});

	$(document).on( 'click', '.remove-store-marker', function(e){
		e.preventDefault()
		var $parent = $(this).parent('.store-marker-wrap');
		if( $('.store-marker-wrap').length > 1 ){
			$parent.remove();
		}
		else{
			$parent.find('input').val('');
		}
	});
});