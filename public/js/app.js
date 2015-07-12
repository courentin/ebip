/**
* Clique menu mobile
*/
$(".header-mobile-menu").click(function() {
	$(".header .nav").toggleClass("open");
});

/**
* Effet parallax large-image
*/
$( window ).scroll(function() {
	$(".large-parallax").css({'transform':'translateY('+(-37+$(window).scrollTop()*0.2)+'px)'});
});

/**
* Gestion couleur menu
*/
var page = document.location.href.replace("http://","").replace("www.","").split("/");

$('#'+page[2]).addClass('active');


$(document).ready(function() {
	/**
	* Disparition black on over
	*/
	$(".black-hover").hoverIntent(
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
});