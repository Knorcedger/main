$(document).ready(function() {

	$("#video-list").on("click", ".show-downloads", function() {
		if ($(".downloads").is(":visible")) {
			$(".downloads").fadeOut();
		} else {
			$(".downloads").fadeIn();
		}
	});

});