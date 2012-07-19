jQuery(document).ready(function() {

	//"use strict";

	/*var x = 3;

	function run() {
		debugger;
		var x = 5;
		console.log(x);
	}
	var myvar = run();*/

	$("a.basic-click-event").click(function() {
		alert("Hello world! I was clicked!");
	});

	$("a.correct-click-event:not(.negative)").on("click", function() {
		alert("Hello world! Im inside an on event");
	});

	$(".make-correct-negative").on("click", function() {
		$(".correct-click-event").addClass("negative");
	});

	$("body").on("click", "a.best-click-event:not(.negative)", function() {
		alert("Hello world! Im a live event");
	});

	$(".make-best-negative").on("click", function() {
		$(".best-click-event").addClass("negative");
	});

	$("#scope").on("click", "li", function() {
		debugger;
		$(this).css("color", "red");
	});

	var AppView = Backbone.View.extend({
		el: $("body"),
		initialize: function() {
			this.left = 0;
			this.top = 0;
		},
		//register events
		events: {
			"click .dynamic-typing": "dynamicTypingExample",
			"click .global-variables": "scopeExample1",
			"click .local-variables": "scopeExample2",
			"click .arrays": "arraysExample",
			"click .equality": "equalityExamples",
			"click .false-examples": "falseExamples",
			"click .nan": "nanExample",
			"click .true-examples": "trueExamples",
			"click .sequential": "sequentialExample",
			"click .function-declaration": "functionDeclarationExample",
			"click .create-object": "createObjectExample",
			"click .create-custom-object": "createCustomObject",
			"click .create-better-custom-object": "createBetterCustomObject",
			"click .strict-globals": "strictGlobals",
			"click .strict-wrong-names": "strictWrongNames",
			"click .loosely-typed": "looselyTyped",
			"click .numbers-binary": "numbersBinary",
			"click .selfexecuting-function": "selfexecutingFunction",
			"click .navigate": "navigate",
			"click .attributes": "attributes",
			"click .manipulate": "manipulate",
			"click .css": "css",
			"click .fade-out": "fadeOut",
			"click .fade-in": "fadeIn",
			"click .slide-up": "slideUp",
			"click .slide-down": "slideDown",
			"click .animate": "animate",
			"click .ajaxrequest": "ajaxrequest",
			"click .param": "param"
		},
		dynamicTypingExample: function() {
			debugger;
			var x = 10;
			x = "I prefer being a string ;)";
		},
		scopeExample1: function() {
			debugger;
			var x = 3;

			function run() {
				debugger;
				var x = 5;
				console.log(x);
			}
			var myvar = run();
			console.log(x);
		},
		scopeExample2: function() {
			debugger;
			var x = 3;

			function run() {
				debugger;
				var x = 5;

				function stop() {
					debugger;
					x = 6;
				}
				stop();
				console.log(x);
			}
			run();
			console.log(x);
		},
		arraysExample: function() {
			debugger;
			var animals = ["dog", "cat", "hen"];
			animals.push("frog");
			animals[100] = "fox";
			console.log(animals.length);
			console.log(animals[90]);
		},
		falseExamples: function() {
			debugger;
			var x = 0;
			var y = "";
			var z = 1;
			var t = "Im a t, or E.T.?";
			var k;

			if (x) {
				console.log("Im in");
			}

			if (y) {
				console.log("Im in");
			}

			if (z) {
				console.log("Im in");
			}

			if (t) {
				console.log("Im in");
			}

			if (k) {
				console.log("Im in");
			}
		},
		equalityExamples: function() {
			debugger;

			var x = 1;
			var y = "1";
			console.log(x == y);
			console.log(x === y);
			console.log(typeof x);
			console.log(typeof y);
			//
			console.log(2 == true);
			console.log(1 == true);
			console.log("" == "0");
			console.log("" == 0);
			console.log("0" == 0);
			console.log(false == "false");
			console.log(false == "0");
			console.log(false == undefined);
			console.log(false == null);
			console.log(null == undefined);
			console.log(new Boolean(false) == false);
			//
			console.log(2 === true);
			console.log(1 === true);
			console.log("" === "0");
			console.log("" === 0);
			console.log("0" === 0);
			console.log(false === "false");
			console.log(false === "0");
			console.log(false === undefined);
			console.log(false === null);
			console.log(null === undefined);
			console.log(new Boolean(false) === false);
			//
			var x = "080";
			var y = 80;

			var z = parseInt(x);
			if (z === y) {
				console.log("equal");
			}

			console.log("JavaScript lacks structural equality by default.");
			console.log([1, 2, 3] == [1, 2, 3]);
			console.log([1, 2, 3] === [1, 2, 3]);
		},
		nanExample: function() {
			debugger;
			var x = "me";
			if (isNaN(x)) {
				console.log("Im in");
			}
			console.log(typeof x);

			var x = "10";
			if (isNaN(x)) {
				console.log("Im in");
			}
			console.log(typeof x);

			var y = parseInt("blabla");
			console.log(typeof y);
			console.log(typeof NaN);
		},
		trueExamples: function() {
			debugger;
			if ($("body").length) {
				console.log("Our page has a body tag, and its sexy!");
			}
		},
		sequentialExample: function() {
			debugger;
			var x = 0;
			var y = 7;

			if (x > 3 && x > y) {
				console.log("im in");
			}

			var z = x || y;

			var z;
			if (x) {
				z = x;
			} else if (y) {
				z = y;
			}

			var t = y || x;

		},
		functionDeclarationExample: function() {
			debugger;
			console.log(new String("that") == "that");
			console.log(new String("that") === "that");
			console.log(typeof new String("that"));
		},
		createObjectExample: function() {
			debugger;
			var candidate = {};

			candidate.name = "Μελένιος";
			var name = candidate.name;

			candidate["surname"] = "Κολοκυθόπουλος";
			var surname = candidate["surname"];

			var gift = {
				name: "ντομάτα",
				"from": "βολιώτικη",
				",. :": "είμαι άδειος",
				"for": candidate,
				"details": {
					"color": "ροδοκόκκινη",
					"size": 12,
					"isDelicious": true
				},
				offer: function() {
					console.log("Τον πέτυχα!");
				}
			};
			gift.offer();
			console.log("Hey, if you can create your own gifts, you also know JSON!");
		},
		createCustomObject: function() {
			debugger;

			function Person(name, surname) {
				this.name = name;
				this.surname = surname;
				this.fullName = function() {
					return this.name + ' ' + this.surname;
				};
			}
			var me = new Person("Ακάκιος", "Μίσκου");
			console.log(me.fullName());
		},
		createBetterCustomObject: function() {
			debugger;

			function Person(name, surname) {
				this.initiate(name, surname)
			}

			Person.prototype.name;
			Person.prototype.surname;

			Person.prototype.initiate = function(name, surname) {
				this.name = name;
				this.surname = surname;
			};

			Person.prototype.fullName = function() {
				return this.name + ' ' + this.surname;
			};

			var me = new Person("Ακάκιος", "Μίσκου");
			console.log(me.fullName());

			Person.prototype.height = "2.00";
			console.log(me.height);
		},
		strictGlobals: function() {
			debugger;
			for (i = 0; i < 1; i++) {
				console.log(i);
			};
		},
		strictWrongNames: function() {
			debugger;
			var ramOnlineAuthenticationVerifier = true;

			if (ramOnlineAuthenticationVerfirier) {
				console.log("All good, free to move to result page man");
			}
		},
		looselyTyped: function() {
			debugger;

			function Person(name, surname) {
				this.initiate(name, surname)
			}

			Person.prototype.name;
			Person.prototype.surname;

			Person.prototype.initiate = function(name, surname) {
				this.name = name;
				this.surname = surname;
			};

			Person.prototype.fullName = function() {
				return this.name + ' ' + this.surname;
			};

			var me = new Person("Ακάκιος");

			var you = new Person("Ακάκιος", "Μίσκου", "Περικλέως");
		},
		numbersBinary: function() {
			debugger;
			var x = 0.3;
			var y = 0.1;
			var z = 0.2;
			if (x === y + z) {
				console.log("equal");
			}

			console.log("Solutions? Use math.abs, or make the numbers integers and then divide them again");
		},
		selfexecutingFunction: function() {
			debugger;
			(function() {
				console.log("I will be automatically executed. Please spare my life :(")
			}());
		},
		navigate: function() {
			debugger;
			var element = $("#jquery-selectors ul li:first");
			var parent = element.parent();
			var child = parent.find("li:last");
			var secondChild = parent.find("li:eq(1)");
			var secondChildAgain = $("#jquery-selectors ul li").eq(1);
			var thirdChild = secondChild.next();
		},
		attributes: function() {
			debugger;
			$("#jquery-attributes ul li:first").addClass("George");
			if ($("#jquery-attributes ul li:first").hasClass("George")) {
				alert("Hi, Im George!");
			}

			$("#jquery-attributes ul li:eq(1)").addClass("Petros");

			console.log($("#jquery-attributes ul li.Petros").html());

			console.log($("#jquery-attributes ul li.Petros").prop("class"));

			$("#jquery-attributes ul li.Petros").prop("class", "Nikos");

			$("#jquery-attributes ul li.Petros").removeProp("class");

			$("#jquery-attributes ul li:last").addClass("Kelly");
			console.log($(".Kelly").text());
			$(".Kelly").text("Kelly has a cute little Yaris");

			//also important is the .val()
		},
		manipulate: function() {
			debugger;
			$("#jquery-manipulation ul").prepend("<li>Im first. Horreeeeyy</li>");
			$("#jquery-manipulation li:last").append(", before, after");
		},
		css: function() {
			debugger;
			$("#jquery-css li:first").css("color", "red");
			var height = $("#jquery-css ul").height();
		},
		fadeOut: function() {
			debugger;
			$("#jquery-effects li:last").fadeOut();
		},
		fadeIn: function() {
			debugger;
			$("#jquery-effects li:last").fadeIn(5000);
		},
		slideUp: function() {
			debugger;
			$("#jquery-effects li:last").slideUp(400);
		},
		slideDown: function() {
			debugger;
			$("#jquery-effects li:last").delay(2000).slideDown();
		},
		animate: function() {
			$("#jquery-effects li:last").css("position", "relative").text("I can fly!!! Do you believe me now?");
			
			var moveLeft, moveTop;
			for (var i = 0; i < 20; i++) {
				moveLeft = Math.random() * 200;
				if (Math.random() > 0.5) {
					moveLeft = -moveLeft;
				}
				appview.left = appview.left + moveLeft;
				moveTop = Math.random() * 200;
				if (Math.random() > 0.5) {
					moveTop = -moveTop;
				}
				appview.top = appview.top + moveTop;

				appview.top = appview.checkBorder(appview.top, -350, 310);
				appview.left = appview.checkBorder(appview.left, -100, 310);

				$("#jquery-effects li:last").animate({
					left: appview.left,
					top: appview.top
				}, 150);
			}
		},
		checkBorder: function(position, min, max) {
			// debugger;
			console.log(position);
			if (position < min) {
				position = min;
			} else if (position > max) {
				position = max;
			}

			return position;
		},
		param: function() {
			debugger;
			var element = $("#param");

			addDunk(element.attr("id"));

			function addDunk(id) {
				$("#" + id).addClass("dunk");
			}
		},
		ajaxrequest: function() {
			debugger;
			var a = new AjaxRequest();
			a.success = function(data) {
				console.log(data);
			}
			// a.error = function() {
			// 	console.log("server not responding");
			// }
			a.complete = function() {
				console.log("request completed");
			}
			/*var data = {};
			data.username = "achilleas";
			data.passqword = "sdfd";*/
			a.request("http://we.thinkdesquared.com/rf/server/server.php", {}, "json");

			function fire() {
				var x = 3;

				function inside() {
					console.log(x);
				}
				return inside;
			}
			var t = fire();
			/*var data = {
				"errors": {
					"hasErrors": false,
					"messages": ["sdfsdf", "sfsdfsd"]
				},
				"response": {
					"accounts": [
						{
							"accountNumber": "34242342",
							"restrictions": true
						},
						{
							"accountNumber": "2333223",
							"restrictions": false
						}
					]
				}
			};

			var data = {
				"errors": {
					"hasErrors": false,
					"messages": ["sdfsdf", "sfsdfsd"]
				},
				"response": {
					"accounts": ["34242342", true], ["34242342", true]
						
					]
				}
			};

			if (!data.errors.hasErrors) {
				console.log(data.response.accounts[1].accountNumber);
			}

			for(var i = 0; i < data.response.accounts.length; i++)*/
		}
	});

	var appview = new AppView;

});


/*
Create coding standards document

fix validator
fix main.js
make the redirect function an object, including the event on .javascript-redirect and include in inheritance
event bubbling example?
*/
