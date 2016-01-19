/**
 * Events list
 */
jQuery( document ).ready( initWidgetTMPostsSlider );
jQuery( document ).on( 'widget-updated widget-added ready', initWidgetTMPostsSlider );

/**
 * Initialization widget js
 *
 * @returns {undefined}
 */
function initWidgetTMPostsSlider() {

//	jQuery( '.tm-post-slider-form-widget .cherry-switcher-wrap' ).click(
//		function() {
//			var _this = jQuery( this );
//			_this.find( 'input[type=hidden]' ).trigger( 'change' );
//		}
//	);

//	jQuery( '.tm-post-slider-form-widget div#button-show' ).click( function() {
//		var _this = jQuery( this );
//		if ( 'false' === _this.find( 'input[type=hidden]' ).val() ) {
//			_this.find( 'p.tm-post-slider-button-text' ).hide();
//		} else {
//			_this.find( 'p.tm-post-slider-button-text' ).show();
//		}
//	}
//	);
}
