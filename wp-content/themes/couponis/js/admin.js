jQuery(document).ready(function($){
	$(document).on( 'click', '.google-api-dismiss .notice-dismiss', function(){
		$.ajax({
			url: ajaxurl,
			data: {
				action: 'google_api_dismiss'
			}
		})
	});

	/* upgrading times of coupons */
	function upgradeCompleted( action, $response_div ){
		$.ajax({
			url: ajaxurl,
			data: {
				action: action
			},
			success: function(){
				if( $response_div ){
					$response_div.append( '<br /><p>Upgrade completed</p>' );
				}
			}
		});		
	}

	$(document).on( 'click', '.time-upgrade-dismiss .notice-dismiss', function(){
		upgradeCompleted( 'couponis_time_upgrade_completed' );
	});	

	$(document).on( 'click', '.image-upgrade-dismiss .notice-dismiss', function(){
		upgradeCompleted( 'couponis_image_upgrade_completed' );
	});

	$(document).on( 'click', '.image-upgrade-dismiss .notice-dismiss', function(){
		upgradeCompleted( 'couponis_wpai_del_completed' );
	});

	function upgradeNextBatch( offset, total, action, $response_div, callback ){
		$.ajax({
			url: ajaxurl,
			data: {
				offset: offset,
				action: action
			},
			method: 'POST',
			dataType: 'json',
			success: function( response ){
				offset += response.upgraded;
				$response_div.append( response.message );
				if( offset < total && response.error === false ){
					upgradeNextBatch( offset, total, action, $response_div, callback );
				}
				else{
					if( callback ){
						callback();
					}
				}
			}
		})
	}

	$(document).on( 'click', '.couponis-start-time-upgrade', function(){
		var $response_div = $('.upgrade-results');
		
		$response_div.append( '<br /><p>Upgrading ( Do not close this window )...</p>' );
		
		upgradeNextBatch( 0, $(this).data('total'), $(this).data('action'), $response_div, function(){
			upgradeCompleted( 'couponis_time_upgrade_completed', $response_div );
		});
	});

	$(document).on( 'click', '.couponis-start-image-upgrade', function(){
		var $response_div = $('.upgrade-image-results');

		$response_div .append( '<br /><p>Deleting ( Do not close this window )...</p>' );
		
		upgradeNextBatch( 0, $(this).data('total'), $(this).data('action'), $response_div, function(){
			upgradeCompleted( 'couponis_image_upgrade_completed', $response_div );
		});
	});

	$(document).on( 'click', '.couponis-start-wpai-upgrade', function(){
		var $response_div = $('.upgrade-wpai-results');

		$response_div .append( '<br /><p>Deleting ( Do not close this window )...</p>' );
		
		upgradeNextBatch( 0, $(this).data('total'), $(this).data('action'), $response_div, function(){
			upgradeCompleted( 'couponis_wpai_del_completed', $response_div );
		});
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