/**
* Analytics.js
*
* Javascript which is used in the A/B Split campaign admin panel.
*/
;(function($){
	$(document).ready(function() {  
	 	$('.chart').graphs( {
	 		data: '#data-table',
	 		container: '.chart'
	 	})
	 	$('.charttwo').graphs( {
	 		data: '#data-table-two',
	 		container: '.charttwo'
	 	})
	 });
})(jQuery);