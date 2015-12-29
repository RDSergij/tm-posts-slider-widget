jQuery(document).on('widget-updated', function(e, widget){
    CHERRY_API.ui_elements.switcher.init( jQuery('body') );
});

console.log(window.TMWidgetParam.button_is);
jQuery('#' + window.TMWidgetParam.button_is).on('change', 'ready', function() {
	console.log('debug');
	_this = jQuery(this);
	if ( 'false' === _this.val() ) {
		_this.parent('form').children('.tm-post-slider-button-text').hide();
	} else {
		_this.parent('form').children('.tm-post-slider-button-text').show();
	}
});