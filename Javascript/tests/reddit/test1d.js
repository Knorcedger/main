$(document).ready(function() {

	"use strict";

	var upperLimit = 100;
	var lowerLimit = 1;
	var guesses = 0;
	var number;
	guess();

	function guess(action) {
		if (action === "bigger") {
			lowerLimit = number + 1;
		} else if (action === "smaller") {
			upperLimit = number - 1;
		}
		number = Math.floor(Math.random() * (upperLimit - lowerLimit + 1)) + lowerLimit;
		$("body").html("Is that your number? " + number + " <br /><br />(y) Yes <br /> (b) My number is bigger <br /> (s) My number is smaller");
		guesses++;
	}

	function cheater() {
		$("body").html("Fucking cheater, get out of here");
	}

	$(document).on("keypress", function(event) {

		if (event.keyCode === 98) {
			if (number === upperLimit) {
				cheater();
			} else {
				guess("bigger");
			}
		} else if (event.keyCode === 115) {
			if (number === lowerLimit) {
				cheater();
			} else {
				guess("smaller");
			}
		} else if (event.keyCode === 121) {
			$("body").text("Found your number in " + guesses + " guesses");
		}
	});

});