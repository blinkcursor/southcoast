// custom JS written for southcoast site

jQuery(document).ready(function($) {

	// cache some vars
	var $body = $(document.body);

	// Remove cover over google maps on small screens when clicked 
	if ( $body.hasClass('page-contacto') || $body.hasClass('page-como-llegar') ) {
		$('.cover-map').on('click', function(e) {
			$('.contact-map').addClass('active');
		})
	};



	// Toggle for "Por qué South Coast"
	var maxHeight = ( document.documentElement.clientWidth < 768 ) ? "89px" : "97px";
	window.onresize = function() {
		maxHeight = ( document.documentElement.clientWidth < 768 ) ? "89px" : "97px";
	}


	if ( !document.body.className.match(/home|page-surf|page-alquiler-material|page-surf-cursos|page-surfcamps|page-equipo/) ) {
		$(".footer__porque").css("maxHeight", maxHeight);
	} 

	$("#js-porque").on('click', function(e){
		var currentMaxHeight = $(".footer__porque").css("maxHeight");
		currentMaxHeight = ( currentMaxHeight == maxHeight ) ? "500px" : maxHeight;
		$(".footer__porque").css("maxHeight", currentMaxHeight);
	})


});