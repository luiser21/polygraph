/**
 * Index
 * 
 * @package carLub
 * @author Eric Chitan
 * Clase dependientede Cargar Imagenes
 * @copyright 2017
 * @version 0.1
 * @access public
 */

$(document).ready(function() {
  $('.overlay').overlay();
	});
  
	$(".modal").click(function(){
    $(".overlay").trigger('hide');
});

$("form").on('click', 'a[data-overlay-trigger="overlay"]', function () {
	var image = $(this).find("img");	
	var theImage = new Image();
	theImage.src = image.attr("src");
	var width = theImage.width;
	var height = theImage.height;
	var factor = 1;
	var scale = 1;
	if (theImage.width > $(window).width()) {
		factor = 0.9;
		scale = $(window).width() / theImage.width;
		width = $(window).width() * factor;
	}
	
	$("#overlay img").attr('src', image.attr('src'));
	$(".overlay .modal").css('max-width', width + 'px');
	$(".overlay .modal").css('max-height', height * scale * factor + 'px');
});

/* 
 * overlay.js v1.1.0
 * Copyright 2014 Joah Gerstenberg (www.joahg.com)
 */
(function($) { 
  $.fn.overlay = function() {
	overlay = $('.overlay');

	overlay.ready(function() {
	  overlay.on('transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd', function(e) {
		if (!$(this).hasClass('shown')) {
		  $(this).css('visibility', 'hidden');
		}
	  });

	  overlay.on('show', function() {
		$(this).css('visibility', 'visible');
		$(this).addClass('shown');
		return true;
	  });

	  overlay.on('hide', function() {
		$(this).removeClass('shown');
		return true;
	  });

	  overlay.on('click', function(e) {
		if (e.target.className === $(this).attr('class')) {
		  return $(this).trigger('hide');
		} else {
		  return false;
		}
	  })

	  $('a[data-overlay-trigger=""]').on('click', function() {
		overlay.trigger('show');
	  });

	  $('a[data-overlay-trigger]:not([data-overlay-trigger=""])').on('click', function() {
		console.log($('.overlay#' + $(this).attr('data-overlay-trigger')))
		$('.overlay#' + $(this).attr('data-overlay-trigger')).trigger('show');
	  });
	})
  };
})(jQuery);