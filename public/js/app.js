
/**
* Effet parallax large-image
*/
$( window ).scroll(function() {
	$(".large-parallax").css({'transform':'translateY('+(-37+$(window).scrollTop()*0.2)+'px)'});
});


$(document).ready(function() {
	/**
	* Clique menu mobile
	*/
	$(".header-mobile-menu").click(function() {
		$(".header .nav").toggleClass("open");
	});

	/**
	* Disparition black on over
	*/
	$(".large-hover").hoverIntent(
		// enter
		function() {
			$(this).find(".large-content-middle").fadeOut(200);
			$(this).find(".large-black").fadeOut(200);
		},
		//leave
		function() {
			$(this).find(".large-content-middle").fadeIn(200);
			$(this).find(".large-black").fadeIn(200);
	});

		
	/**
	* Gestion couleur menu
	*/
	var page = document.location.href.replace("http://","").replace("www.","").split("/");
	if(page[1]=="") page[1]="index";

	$('.nav').find('#'+page[1]).addClass('active');
});