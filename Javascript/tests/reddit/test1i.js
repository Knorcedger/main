$(document).ready(function() {

	"use strict";

	$("body").append("<div class='info'></div><br />");
	$("body").append("<div class='actions'></div>");
	var userPosition = "bed";

	//intro
	updateScene();

	/**
	 * Checks if localStorage is supported
	 * @return {Bollean}
	 */
	function supportsLocalStorage() {
		try {
			return 'localStorage' in window && window.localStorage !== null;
		} catch (e) {
			return false;
		}
	}

	/**
	 * updates the available user actions
	 * @return {String} 
	 */
	function availableActions() {
		if (userPosition === "bed") {
			return "S - Stand up in fear <br /> I - Ignore him, I need more sleep";
		} else if (userPosition === "room") {
			return "L - Look from the window <br /> J - Jump through the window";
		} else if (userPosition === "injured") {
			return "S - You cant even move...";
		} else if (userPosition === "terrified") {
			return "P - Pray to a merciful god that will save you";
		} else if (userPosition === "praying") {
			return "K - Are you kidding me?";
		} else if (userPosition === "dead") {
			return "R - Restart <br />";
		}
	}

	/**
	 * Moves the userPosition to the next one depending on user action (but not always ;)
	 * @param  {Event} event 
	 */
	function move(event) {
		if (userPosition === "bed") {
			if (event.keyCode === 115) {
				userPosition = "room";
			} else {
				userPosition = "dead";
			}
		} else if (userPosition === "room") {
			if (event.keyCode === 106) {
				userPosition = "injured";
			} else {
				userPosition = "terrified";
			}
		} else if (userPosition === "injured") {
			userPosition = "dead";
		} else if (userPosition === "terrified") {
			userPosition = "praying";
		} else if (userPosition === "praying") {
			userPosition = "dead";
		} else if (userPosition === "dead") {
			if (event.keyCode === 114) {
				userPosition = "bed";
			}
		}
		//also update the scene
		updateScene();
	}

	/**
	 * Update the scene
	 */
	function updateScene() {
		if (userPosition === "bed") {
			$(".info").text("Wake up " + localStorage.name + ". Zombies are around your house, you have to act quick.");
		} else if (userPosition === "room") {
			$(".info").text("Can you hear their voices from hell? Oh.. it stinks too");
		} else if (userPosition === "injured") {
			$(".info").text("Are you crazy? You are on the third floor. You broke both your legs");
		} else if (userPosition === "terrified") {
			$(".info").text("Damn, we are on the third floor. Zombies try to take down the door. Think fast.");
		} else if (userPosition === "praying") {
			$(".info").text("This is just a game, there is no god here, sorry :(");
		} else if (userPosition === "dead") {
			$(".info").text("The zombies are eating your brains. Mmmm, so delicious...");
		}
		// update the available Actions too
		$(".actions").html(availableActions());
	}

	// on keypress, move to the next scene
	$(document).on("keypress", function(event) {
		move(event);
	});

});