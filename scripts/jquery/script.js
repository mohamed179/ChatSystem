$(document).ready(function(){
	
	/* to stop scrolling the page while scrolling elements with
	   class="scrollable" */
	$('.scrollable').on( 'mousewheel DOMMouseScroll', function (e) {
		var e0 = e.originalEvent;
		var delta = e0.wheelDelta || -e0.detail;
		
		this.scrollTop += ( delta < 0 ? 1 : -1 ) * 25;
		e.preventDefault();  
	});
	
});
