jQuery(document).ready(function($){
	"use strict";

	var isRTL = $('body').hasClass('rtl') ? true : false;

	/* TO TOP */
	$(window).on('scroll', function(){		
		if( $(window).scrollTop() > 200 ){
			$('.to_top').fadeIn(100);
		}
		else{
			$('.to_top').fadeOut(100);
		}
	});	

	$(document).on('click', '.to_top, .store-letter-top', function(e){
		e.preventDefault();
		$("html, body").stop().animate(
			{
				scrollTop: 0
			}, 
			{
				duration: 800
			}
		);
	});

	$('.needs-captcha').append( '<input type="hidden" name="captcha" value="1">' );

	/* NAVIGATION */
	$('.nav-paste').append( $('.nav-copy').html() );
	$(document).on('click', '.navigation a', function(e){
		if( $(window).width() < 768 && e.target.nodeName == 'I' ){
			return false;
		}
		else if( $(this).attr( 'href' ).indexOf( 'http' ) > -1 && !$(this).attr('target') && !e.ctrlKey ){
			window.location.href = $(this).attr('href');
		}
	});
	
	function handle_navigation(){
		if ($(window).width() > 768) {
			$('ul.nav li.dropdown, ul.nav li.dropdown-submenu').hover(function () {
				$(this).addClass('open').find(' > .dropdown-menu').stop(true, true).hide().slideDown(200);
			}, function () {
				$(this).removeClass('open').find(' > .dropdown-menu').stop(true, true).show().slideUp(200);
	
			});
		}
		else{
			$('.dropdown-toggle').removeAttr('data-toggle');
			$(document).on( 'click', 'li.dropdown a', function(e){
				e.preventDefault();
				if( !$(this).parent().hasClass('open') ){
					$(this).parent().addClass('open').find(' > .dropdown-menu').show();
					$(this).parents('.dropdown').addClass('open').find(' > .dropdown-menu').show();
				}
				else{
					$(this).parent().removeClass('open').find(' > .dropdown-menu').hide();
					$(this).parent().find('.dropdown').removeClass('open').find(' > .dropdown-menu').hide();
				}
			});	
		}
	}

	if( couponis_overall_data.enable_sticky == 'yes' ){
		var $nav = $('.navigation');
		$('body').append($nav.clone().addClass('sticky-nav'));
		$(window).scroll(function(){
			if( $(window).width() > 768 && $(window).scrollTop() > 200 ){
				var top;
				$('#wpadminbar').length > 0 ? top = $('#wpadminbar').height() : top = 0;
				$('.sticky-nav').css('top', top+'px');
			}
			else{
				$('.sticky-nav').css('top', '-300px');	
			}
		});
	}

	handle_navigation();
	
	$(window).resize(function(){
		setTimeout(function(){
			handle_navigation();
		}, 200);
	});		


	/* SUBMIT FORMS */
	$('.submit_form').click(function(){
		$(this).parents('form').submit();
	});
	
		
	/* contact script */
	var $map = $('.contact-map');
	if( $map.length > 0 ){
		var markers = JSON.parse( $map.html().trim() );
		$map.html('');
		$map.removeClass('hidden');
		var markersArray = [];
		var bounds = new google.maps.LatLngBounds();
		var mapOptions = { mapTypeId: google.maps.MapTypeId.ROADMAP };
		var map =  new google.maps.Map($map[0], mapOptions);
		if( markers.length > 0 ){
			for( var i=0; i<markers.length; i++ ){
				var temp = markers[i].split(',');
				var location = new google.maps.LatLng( temp[0], temp[1] );
				bounds.extend( location );

				var marker = new google.maps.Marker({
				    position: location,
				    map: map,
				    icon: couponis_overall_data.marker_icon
				});				
			}

			map.fitBounds( bounds );

			var listener = google.maps.event.addListener(map, "idle", function() { 
				if( couponis_overall_data.markers_max_zoom != '' ){
			  		map.setZoom(parseInt( couponis_overall_data.markers_max_zoom ));
			  		google.maps.event.removeListener(listener); 
			  	}
			});
			
		}
	}
	
	/* MAGNIFIC POPUP FOR THE GALLERY */
	$('a[class^="gallery-"]').each(function(){
		var $this = $(this);
		$this.addClass( 'gallery-item' );
		$('a[class^="gallery-"]').magnificPopup({
			type:'image',
			gallery:{enabled:true},
		});
	});


	/* FEATURED SLIDER */
	function calcNavPosition( $slider, substract ){
		$slider.find('.owl-nav > div').css({
			top: $slider.find('.owl-item.active img').height() / 2 - substract
		});
	}

	var $featured_coupons = $('.featured-coupons');
	if( $featured_coupons.length > 0 ){
		$featured_coupons.each(function(){
			var $this = $(this);
			$this.owlCarousel({
				onInitialized: function(){
					$(window).load(function(){
						calcNavPosition( $this, 17 );
					});
				},
				onResized: function(){
					calcNavPosition( $this, 17 );
				},
				items: 1,
				rtl: isRTL,
				loop: $this.find('.featured-item').length > 1 ? true : false,
				autoplay: true,
				nav: $this.find('.featured-item').length > 1 ? true : false,
				navText: ['<i class="fa fa-caret-left"></i>','<i class="fa fa-caret-right"></i>'],
				dots: false
			});
		});
	}

	/* CAROUSEL STORES */
	var $carousel_stores = $('.stores-carousel-list');
	if( $carousel_stores.length > 0 ){
		$carousel_stores.each(function(){
			var $this = $(this);
			$this.owlCarousel({
				responsive: {
					0:{
						items: 1
					},
					414: {
						items: 2
					},
					768:{
						items: 4,
					},
					800:{
						items: parseInt( $this.attr( 'data-visible' ) ? $this.attr( 'data-visible' ) : 1 ),
					}
				},
				rtl: isRTL,
				autoplay: true,
				margin: 30,
				nav: true,
				navText: ['<i class="icon-arrow-left"></i>','<i class="icon-arrow-right"></i>'],
				dots: false
			});
		});
	}

	/* CAROUSEL CATEGORIES */
	var $carousel_categories = $('.categories-carousel-list');
	if( $carousel_categories.length > 0 ){
		$carousel_categories.each(function(){
			var $this = $(this);
			$this.owlCarousel({
				responsive: {
					0:{
						items: 1
					},
					414: {
						items: 2
					},
					768:{
						items: 4,
					},
					800:{
						items: parseInt( $this.attr( 'data-visible' ) ? $this.attr( 'data-visible' ) : 1 ),
					}
				},
				rtl: isRTL,
				autoplay: true,
				margin: 30,
				nav: true,
				navText: ['<i class="icon-arrow-left"></i>','<i class="icon-arrow-right"></i>'],
				dots: false
			});
		});
	}

	/* BOOTSTRAP 3 TO 2 */
	function bootstrap_3_to_2(){
		if( $('.home-categories').length > 0 ){
			var $html = [];
			var pointer = 0;
			var counter = 0;
			var max_number = 1;
			var $window_width = $(window).width();
			if( $window_width > 400 ){
				max_number = 2;
			}
			if( $window_width > 768 ){
				max_number = 3;
			}
			$('.home-categories .cat-box').each(function(){
				counter++;
				var $this = $(this);
				if( !$html[pointer] ){
					$html[pointer] = '';
				}
				$html[pointer] += '<div class="cat-box col-xs-'+( 12 / max_number )+'">'+$this.html()+'</div>';
				if( max_number == counter ){
					counter = 0;
					$html[pointer] = '<div class="row">'+$html[pointer]+'</div>';
					pointer++;
				}
			});

			if( $html.length > 0 ){
				if( $html[$html.length - 1].indexOf( 'row' ) == -1 ){
					$html[$html.length - 1] = '<div class="row">'+$html[$html.length - 1]+'</div>';
				}

				$('.home-categories').html( '<div class="container">'+$html.join('')+'</div>' );
			}

		}
	}
	bootstrap_3_to_2();
	$(window).resize(function(){
		bootstrap_3_to_2();
	});
	window.addEventListener("orientationchange", bootstrap_3_to_2); 


	/* OFFER SHARE TOGGLE */
	$(document).on( 'click', '.toggle-coupon-share', function(){
		$('.'+$(this).data('target')).toggleClass('open');
	});

	/* OPEN COUPON MODAL */
	var fetchingCode = false;
	function show_code_modal( $this, coupon_id ){
		if( !fetchingCode ){
			fetchingCode = true;
			if( $this ){
				$this.find( '.code-text-full' ).append('<i class="fa fa-circle-o-notch fa-spin"></i>');
				$this.find( '.code-text' ).append('<i class="fa fa-circle-o-notch fa-spin"></i>');
			}
			$.ajax({
				url: couponis_overall_data.ajaxurl,
				method: 'POST',
				data: {
					action: 'show_code',
					coupon_id: coupon_id,
				},
				dataType: "HTML",
				success: function(response){
					$('#showCode .coupon_modal_content').html( response );
					$('#showCode').modal('show');
					if( !/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
					    $('.coupon-code-manual').hide();
					}
					else{
						$('.coupon-code-modal.print').attr( 'href', $('.coupon-print-image').attr('src') );
						$('.coupon-code-copied').hide();
					}

					if( $this ){
						$this.find('i').remove();
					}
				},
				complete: function(){
					fetchingCode = false;
				}
			});			
		}
	}

	if( window.location.hash && window.location.hash.indexOf('o-') > 0 ){
		show_code_modal( false, window.location.hash.split('o-')[1] );
	}

	$(document).on( 'click', '.coupon-action-button', function(e){
		var $this = $(this);
		if( $this.data('affiliate') ){
			setTimeout(function(){
				window.location.href = $this.data('affiliate');
			}, 30);
		}
		else{
			e.preventDefault();
			var href = $this.attr( 'href' );
			show_code_modal( $this, href.split('o-')[1] );
		}
	});


	/* AUTOCOPY FOR NO PHONES */
	if( !/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ){
		$(document).on('click', 'input.coupon-code-modal', function(e) {
			e.preventDefault();
			$(this).select();

			try {
				var success = document.execCommand('copy');
				if( success ){
					$('.coupon-code-copied').hide();
					$('.coupon-code-copied.after-copy').show();
				}
			} catch (err) {
				console.log('Oops, unable to copy');
			}

		});
	}

	if( /OS 11_(\d{1,2})(_{0,1})(\d{1,2})/.test(navigator.userAgent) ){
		$("body").addClass("iosBugFixCaret");
	}

	/* ADD SEARCH TYPES */
	$(document).on( 'click', '.search-type', function(){
		var $this = $(this);
		$this.toggleClass('type-added');
		var $parent = $this.parent();
		var list = [];

		$parent.find('.type-added').each(function(){
			if( $(this).hasClass('type-added') ){
				list.push( $(this).data('value') );
			}
		});
		$this.parent().find('input').val( list.join(',') );
	});

	/* SUBMIT FORM */
	$(document).on( 'click', '.submit-form, .submit-ajax-form', function(){
		$(this).parents('form').submit();
	});

	$('.ajax-form').keypress(function(e){
    	if(e.which == 13 && e.target.nodeName !== 'TEXTAREA' ) {
    		$(this).submit();
    	}
    });

	var ajaxing = false;
	$(document).on( 'submit', '.ajax-form', function(e){
		e.preventDefault();
		if( !ajaxing ){
			ajaxing = true;
			var $this = $(this);
			var $result = $this.find('.ajax-form-result');
			var $submitButton = $this.find( '.submit-ajax-form' );
			var formData = new FormData($(this)[0]);
			var spin = '<i class="fa fa-fw fa-circle-o-notch fa-spin"></i>';
			var isIcon = false;
			var oldIcon = '';

			if( $submitButton.find('i').length == 0 ){
				$submitButton.append( spin );
			}
			else{
				isIcon = true;
				oldIcon = $submitButton.html();
				$submitButton.html( spin );
			}
			
			$.ajax({
				url: couponis_overall_data.ajaxurl,
				method: 'POST',
				processData: false,
				contentType: false,
				data: formData,
				dataType: "JSON",
				success: function(response){
					$result.html( response.message );
					if( response.reload ){
						window.location.reload();
					}
					if( !isIcon ){
						$submitButton.find('i').remove();
					}
					else{
						$submitButton.html( oldIcon );
					}
					ajaxing = false;
				}
			});
		}
	});

	/* OPEN RECOVER MODAL IS PRESENT */
	var $recover = $('#recover-password');
	if( $recover ){
		$recover.modal('show');
	}

	/* OPEN LOGIN IF IT IS PRESENT IN HASH */
	if( window.location.hash == '#login' ){
		$('#login').modal('show');
	}

	/* SAVE OR REMOVE COUPON */
	$(document).on( 'click', '.save-coupon-action', function(){
		var $this = $(this);
		$.ajax({
			url: couponis_overall_data.ajaxurl,
			method: 'POST',
			data: {
				action: 'save_coupon',
				post_id: $this.data('post_id')
			},
			success: function(){
				$this.toggleClass( 'added' );
				if( $('.page-template-page-tpl_account').length > 0 ){
					$this.parents('.white-block').addClass('hidden');
				}
			}
		})
	});

	/* SAVE OR REMOVE STORE */
	$(document).on( 'click', '.save-store-action', function(){
		var $this = $(this);
		$.ajax({
			url: couponis_overall_data.ajaxurl,
			method: 'POST',
			data: {
				action: 'save_store',
				store_id: $this.data('store_id')
			},
			success: function(){
				$this.toggleClass( 'added' );
				if( $('.page-template-page-tpl_account').length > 0 ){
					$this.parents('.store-block').addClass('hidden');
				}
			}
		})
	});

	/* TOGGLE NEW STORE FORM */
	$(document).on( 'change', '#no_store', function(){
		$('.stores-display').toggleClass('hidden');
		$('.stores-hidden').toggleClass('hidden');
	});

	/* TOGGLE COUPON TYPE INPUT */
	$(document).on( 'change', '#type', function(){
		$('div[class*="type-"]').addClass('hidden');
		$('.type-'+$(this).val()).removeClass('hidden');
	});

	/* ASSIGN DATEPICKER ON SUBMIT PAGE */
	if( $('#expire').length > 0 ){
		$('.type-'+$('#type').val()).removeClass('hidden');
        $('#expire').datetimepicker({
        	dateFormat: 'mm/dd/yy',
        	timeFormat: 'HH:mm:ss',
        	hour: 23,
        	minute: 59,
        	second: 59,
        	currentText: couponis_overall_data.locale_now,
        	closeText: couponis_overall_data.locale_done
        });
	}

	/* COUPON FEEDBACK */
	var feedbackFlag = false;
	$(document).on( 'click', '.feedback-record-action', function(){
		var $this = $(this);
		if( !feedbackFlag ){
			feedbackFlag = true;
			$.ajax({
				url: couponis_overall_data.ajaxurl,
				method: 'POST',
				data: {
					action: 'feedback',
					feedback: $this.data('value'),
					coupon_id: $this.data('coupon_id')
				},
				success: function(response){
					$this.parent().html( response );
				},
				complete: function(){
					feedbackFlag = false;
				}
			});			
		}
	});

	/* COUNTDOWN */
	var $countdown = $('.countdown');
	if( $countdown.length > 0 ){
		$('.countdown').kkcountdown({
			dayText				: $countdown.data('single'),
			daysText 			: $countdown.data('multiple'),
			displayZeroDays 	: true,
			rusNumbers  		: false
		});
	}

 	var $progress = $('#progress');
	if( $progress.length > 0 ){
		var can = $progress[0];
		var context = can.getContext('2d');


		var percentage = $progress.data('value');
		var degrees = percentage * 3.6;
		var radians = degrees * (Math.PI / 180);

		var s = 1.5 * Math.PI;

		context.beginPath();
		context.strokeStyle = $progress.data('color');
		context.lineWidth = 2;
		context.arc(40, 40, 39, s, radians+s);
		context.stroke();
	}

	/* TOGGLE CONTENT IN MODAL */
	$(document).on( 'click', '.modal-content-action', function(){
		$('#showCode .modal-coupon-content').toggleClass( 'hidden' );
	});

	/* REMEMBER COOKIE */
	var $orderby = $('.search-header .orderby');
	if( $orderby.length > 0 ){
		$orderby.on('change', function(){
			Cookies.set('couponis-orderby', $(this).val(), { expires: 1, path: '/' });
			window.location.reload();
		});
	}

	var $styleListing = $('.listing-style');
	if( $styleListing.length > 0 ){
		$styleListing.on('click', function(){
			Cookies.set('couponis-listing-style', $(this).data('value'), { expires: 1, path: '/' });
			window.location.reload();
		});
	}

	/* SIMPLE SLIDER */
	$('.simple-slider').each(function(){
		var $this = $(this);
		var isMultiple = $this.find('img').length > 1 ? true : false;
		$this.owlCarousel({
			items: 1,
			onInitialized: function(){
				$(window).load(function(){
					calcNavPosition($this, 25);
				});
			},
			onResized: function(){
				calcNavPosition($this, 25);
			},
			rtl: isRTL,
			responsive: {
				0: {
					nav: false,
					dots: true
				},
				768: {
					nav: isMultiple,
					dots: false
				}
			},
			loop: isMultiple,
			autoplay: isMultiple,
			nav: isMultiple,
			navText: ['<i class="fa fa-caret-left"></i>','<i class="fa fa-caret-right"></i>'],
			dots: false
		});
	});

	/* STORE SEARCHING */
	$('.letter-search').on( 'click', function(e){
		e.preventDefault();
		var $this = $(this);
		var target = $($this.attr('href')).offset().top;

		$("html, body").stop().animate(
			{
				scrollTop: target - $('#wpadminbar').height() - $('.sticky-nav').height() - 15
			}, 
			{
				duration: 800
			}
		);
	});

	$('.search-store-toggle').on('click', function(e){
		e.preventDefault();
		$('.search-store').toggle();
		var $stresResults = $('.stores-search-results');
		if( $stresResults.is(':visible') ){
			$('.stores-search-results').hide();
		}
		else if( $stresResults.find('.stores-list').html() ){
			$('.stores-search-results').show();	
		}
	})

	var $storeInput = $('#store_name');
	if( $storeInput.length > 0 ){
		var typingTimer; 
		var $loader = $('.search-store i');

		$storeInput.on('keyup', function() {
			clearTimeout(typingTimer);
			typingTimer = setTimeout(doneTyping, 500);
		});

		$storeInput.on('keydown', function() {
			clearTimeout(typingTimer);
		});		
	}

	function doneTyping(){
		if( $storeInput.val().length > 3 ){
			$loader.show();
			$.ajax({
				url: couponis_overall_data.ajaxurl,
				method: 'POST',
				data: {
					action: 'search_stores',
					keyword: $storeInput.val(),
				},
				dataType: "HTML",
				success: function(response){
					$('.stores-list').html( response );
					$('.stores-search-results').show();
				},
				complete: function(){
					$loader.hide();
				}
			})
		}
	}	

	/* LOAD ALL STORES FOR A GIVEN LETTER */
	$(document).on('click', '.stores-alt-load-all', function(e){
		e.preventDefault();
		var $this = $(this);
		$this.html('<i class="fa fa-fw fa-circle-o-notch fa-spin"></i>');
		var $parent = $this.parent();
		$.ajax({
			url: couponis_overall_data.ajaxurl,
			method: 'POST',
			data: {
				action: 'load_all_stores_letter',
				letter: $this.data('letter')
			},
			success: function(response){
				$parent.before( response );
				$parent.remove();
			}
		})
	});

	/*Start select2*/
	if( $('.launch-select2').length > 0 ){
		$('.launch-select2').each(function(){
			var $this = $(this);
			$this.select2({
				ajax:{
			    	url: couponis_overall_data.ajaxurl,
			    	dataType: 'json',
					data: function (params) {
						var queryParameters = {
							s: params.term,
							action: 'taxonomy_ajax',
							taxonomy: $this.data('taxonomy')
						}
						return queryParameters;
					}
				},
				minimumInputLength: 3,
			});
		})
	}

	/* Toggle more */
	$(document).on('click', '.toggle-more', function(){
		var $couponBox = $(this).parent().parent();
		$couponBox.find('.small-description').toggleClass('hidden');
		$couponBox.find('.full-description').toggleClass('hidden');
	});
});