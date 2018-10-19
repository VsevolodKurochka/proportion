$(document).ready(function(){

	function scroll(scrollLink, speed){
		$('html, body').animate({
			scrollTop: scrollLink.offset().top
		}, speed);
		return false;
	}
	$('.anchor').click(function(e){
		e.preventDefault();
		scroll($( $(this).attr('href') ), 1500);
	});

	$("#pride-carousel").owlCarousel({
		items: 1,
		nav: true,
		navText: ['', ''],
		dots: false,
		loop: true
	});
});	