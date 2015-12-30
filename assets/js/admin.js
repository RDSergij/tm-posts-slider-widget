jQuery( document ).ready( function() {
	jQuery( document ).on( 'widget-updated', function() {
		window.CHERRY_API.ui_elements.switcher.init( jQuery( 'body' ) );
	});

	jQuery( document ).on( 'widget-updated ready', function() {
		jQuery( 'div#button-show' ).click( function() {
			var _this = jQuery( this );
			var Button_is = _this.find( 'input#' + window.TMWidgetParam.button_is ).val();
			if ( 'false' === Button_is ) {
				_this.find( 'p.tm-post-slider-button-text' ).hide();
			} else {
				_this.find( 'p.tm-post-slider-button-text' ).show();
			}
		}
		);
	}
	);
}
		);
