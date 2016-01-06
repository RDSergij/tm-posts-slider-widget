jQuery( document ).ready( function() {

	// Slider init
	window.swiper_slider = new window.Swiper( '.tm-post-slider-widget', {
		pagination: '.tm-post-slider-widget .swiper-pagination',
		nextButton: '.tm-post-slider-widget .swiper-button-next',
		prevButton: '.tm-post-slider-widget .swiper-button-prev',
		slidesPerView: 1,
		paginationClickable: true,
		spaceBetween: 30,
		loop: true,
		direction: 'horizontal',
		speed: 1000,
		autoplay: parseInt(window.TMSliderWidgetParam.autoplay)
	} );
});
