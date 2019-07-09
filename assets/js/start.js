/**
 * Start.js
 *
 * Listens to DOMContentLoaded, replaces class attribute for <html> when ready.
 */
var callback = (function(html){html.className=html.className.replace(/\bcontent-hidden\b/,'content-visible')})(document.documentElement);

if (
	document.readyState === 'complete' ||
	(document.readyState !== 'loading' && !document.documentElement.doScroll)
) {
	callback(html);
} else {
	document.addEventListener( 'DOMContentLoaded', function (event) {
		var html = document.documentElement;
		html.className = html.className.replace(/\bcontent-hidden\b/,'content-visible');
	});
}