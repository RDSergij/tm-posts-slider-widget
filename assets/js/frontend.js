jQuery( document ).ready( function() {
	// Slider init
	window.swiper = new window.Swiper( '.swiper-container', {
		pagination: '.swiper-pagination',
		nextButton: '.swiper-button-next',
		prevButton: '.swiper-button-prev',
		slidesPerView: 1,
		paginationClickable: true,
		spaceBetween: 30,
		loop: true
	} );
});
