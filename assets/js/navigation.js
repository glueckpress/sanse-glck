/**
 * Toggle menu button on scroll.
 *
 * Scroll direction detection:
 * @link https://codepen.io/lehollandaisvolant/pen/ryrrGx
 *
 */
(function() {

	var scrollPos = 0,
	    button = document.querySelector( '.menu-toggle' );

	window.addEventListener('scroll', function(){

		if ( (document.body.getBoundingClientRect()).top > scrollPos ) {
			button.classList.add( 'menu-toggle--show' );
			button.classList.remove( 'menu-toggle--hide' );
		} else {
			button.classList.add( 'menu-toggle--hide' );
			button.classList.remove( 'menu-toggle--show' );
		}

		scrollPos = (document.body.getBoundingClientRect()).top;
	});
})();