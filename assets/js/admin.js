/**
 * Events list
 */
jQuery( document ).ready( initWidget );
jQuery( document ).on( 'widget-updated widget-added ready', initWidget );

/**
 * Initialization widget js
 *
 * @returns {undefined}
 */
function initWidget() {
	window.CHERRY_API.ui_elements.switcher.init( jQuery( 'body' ) );

	jQuery( '.tm-post-slider-form-widget .cherry-switcher-wrap' ).click(
		function() {
			var _this = jQuery( this );
			_this.find( 'input[type=hidden]' ).trigger( 'change' );
		}
	);

	jQuery( '.tm-post-slider-form-widget div#button-show' ).click( function() {
		var _this = jQuery( this );
		console.log( _this.find( 'input[type=hidden]' ).val() );
		if ( 'false' === _this.find( 'input[type=hidden]' ).val() ) {
			_this.find( 'p.tm-post-slider-button-text' ).hide();
		} else {
			_this.find( 'p.tm-post-slider-button-text' ).show();
		}
	}
	);
}
