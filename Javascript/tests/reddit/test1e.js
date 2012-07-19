$(document).ready(function() {

	"use strict";

	var name, age, redditUsername;
	if (supportsLocalStorage()) {
		name = localStorage.name;
		age = localStorage.age;
		redditUsername = localStorage.redditUsername;
	}

	if (!name) {
		name = prompt("Your name plz");
		localStorage.name = name;
	}

	if (!age) {
		age = prompt("Your age plz");
		localStorage.age = age;
	}

	if (!redditUsername) {
		redditUsername = prompt("Your reddit username plz");
		localStorage.redditUsername = redditUsername;
	}

	alert("your name is " + name + ", you are " + age + " years old, and your username is " + redditUsername);

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

});