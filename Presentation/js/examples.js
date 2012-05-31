jQuery(document).ready(function() {

	"use strict";

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

	var AppView = Backbone.View.extend({
		el: $("body"),
		initialize: function() {},
		//register events
		events: {
			"click .dynamic-typing": "dynamicTypingExample",
			"click .global-variables": "scopeExample1",
			"click .local-variables": "scopeExample2",
			"click .arrays": "arraysExample",
			"click .equality": "equalityExample",
			"click .strict-equality": "strictEqualityExample",
			"click .equality-examples": "equalityComparisonExamples",
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
			"click .numbers-floats": "numbersFloats",
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
			"click .ajaxrequest": "ajaxrequest"
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
				var x = 5;
			}
			run();
			console.log(x);
		},
		scopeExample2: function() {
			debugger;
			var x = 3;

			function run() {
				var x = 5;

				function stop() {
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
			animals[100] = "fox";
			console.log(animals.length);
			console.log(animals[90]);
		},
		equalityExample: function() {
			debugger;
			var x = 1;
			var y = "1";
			console.log(x == y);
			console.log(x === y);
			console.log(typeof x);
			console.log(typeof y);
		},
		strictEqualityExample: function() {
			debugger;
			var animals = ["dog", "cat", "hen"];
			animals[100] = "fox";
			console.log(animals.length);
			console.log(animals[90]);
		},
		equalityComparisonExamples: function() {
			debugger;
			console.log("" == "0");
			console.log(0 == "");
			console.log(0 == "0");
			console.log(false == "false");
			console.log(false == "0");
			console.log(false == undefined);
			console.log(false == null);
			console.log(null == undefined);
			console.log(2 == true);
			console.log(1 == true);
			console.log(new Boolean(false) == false);
			//
			console.log("" === "0");
			console.log(0 === "");
			console.log(0 === "0");
			console.log(false === "false");
			console.log(false === "0");
			console.log(false === undefined);
			console.log(false === null);
			console.log(null === undefined);
			console.log(2 === true);
			console.log(1 === true);
			console.log(new Boolean(false) === false);
			//
			console.log("JavaScript lacks structural equality by default.");
			console.log([1, 2, 3] == [1, 2, 3]);
			console.log([1, 2, 3] === [1, 2, 3]);
		},
		nanExample: function() {
			debugger;
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
			var Person = function() {
					this.name = "";
				};
			var me = new Person();
			me.name = "Achilleas";
			var candidate = me && me.name;
			//
			var x = 0;
			var y = 7;
			var z = x || y;
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
				"for": candidate,
				",. :": "im empty",
				"details": {
					"color": "red",
					"size": 12,
					"isDelicious": true
				},
				offer: function() {
					console.log("Τον πέτυχα!");
				}
			};
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
		},
		createBetterCustomObject: function() {
			debugger;
			function Person() {

			}

			Person.prototype.baptize = function(name, surname) {
				this.name = name;
				this.surname = surname;
			};

			Person.prototype.fullName = function() {
				return this.name + ' ' + this.surname;
			};

			var me = new Person();
			me.baptize("Ακάκιος", "Μίσκου");

			Person.prototype.height = "2.00";
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
			function Person() {

			}

			Person.prototype.baptize = function(name, surname) {
				this.name = name;
				this.surname = surname;
			};

			Person.prototype.fullName = function() {
				return this.name + ' ' + this.surname;
			};

			var me = new Person();
			me.baptize("Ακάκιος");

			var you = new Person();
			you.baptize("Ακάκιος", "Μίσκου", "Περικλέως");
		},
		numbersFloats: function() {
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
			$("#jquery-selectors ul li:first").addClass("George");
			if ($("#jquery-selectors ul li:first").hasClass("George")) {
				alert("Hi, Im George!");
			}

			$("#jquery-selectors ul li:eq(1)").addClass("Petros");

			console.log($("#jquery-selectors ul li.Petros").html());

			console.log($("#jquery-selectors ul li.Petros").prop("class"));

			$("#jquery-selectors ul li.Petros").prop("class", "Nikos");

			$("#jquery-selectors ul li.Petros").removeProp("class");

			$("#jquery-selectors ul li:last").addClass("class", "Kelly");
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
			$("#jquery-css ul").height();
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
			debugger;
			//$("#jquery-effects li:last").delay(2000).slideDown();
			$("#jquery-effects li:last").css("position", "relative").animate({
				opacity: 0.05,
				left: '+=500'
			}, 5000, function() {
				alert("Animation done");
				$("#jquery-effects li:last").css("position", "relative").animate({
					opacity: 0.05,
					left: '+=500'
				}, 5000, function() {
					alert("Animation done");
				});
			});
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
				function inside(){
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
