
/**
 * Date & Time Fields
 */

CMB.addCallbackForClonedField( ['CMB_Date_Field', 'CMB_Time_Field', 'CMB_Date_Timestamp_Field', 'CMB_Datetime_Timestamp_Field' ], function( newT ) {

	// Reinitialize all the datepickers
	newT.find( '.cmb_datepicker' ).each(function () {
		jQuery(this).attr( 'id', '' ).removeClass( 'hasDatepicker' ).removeData( 'datepicker' ).unbind().datepicker();
	});

	// Reinitialize all the timepickers.
	newT.find('.cmb_datetimepicker' ).each(function () {
        jQuery(this).datetimepicker({
        	dateFormat: 'mm/dd/yy',
        	timeFormat: 'HH:mm:ss'
        });
	});

} );

CMB.addCallbackForInit( function() {

	// Datepicker
	jQuery('.cmb_datepicker').each(function () {
		jQuery(this).datepicker({ dateFormat: 'mm/dd/yy' });
	});
	
	// Wrap date picker in class to narrow the scope of jQuery UI CSS and prevent conflicts
	jQuery("#ui-datepicker-div").wrap('<div class="cmb_element" />');

	// Timepicker
	jQuery('.cmb_datetimepicker').each(function () {
        jQuery(this).datetimepicker({
        	dateFormat: 'mm/dd/yy',
        	timeFormat: 'HH:mm:ss',
        	hour: 23,
        	minute: 59,
        	second: 59
        });
	} );

});