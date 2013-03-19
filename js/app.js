var TwitchDownload = angular.module("TwitchDownload", ["ngResource", "SwiftMessenger"]);

TwitchDownload.constant("root", "/Main/");

TwitchDownload.config(function($routeProvider, $locationProvider, root) {
	$routeProvider
	.when("/",
	{
		templateUrl: root + "views/home.html",
		controller: "HomeCtrl"
	})
	.when("/channel/:channel",
	{
		templateUrl: root + "views/channel.html",
		controller: "ChannelCtrl"
	})
	.when("/channel/:channel/page/:page",
	{
		templateUrl: root + "views/channel.html",
		controller: "ChannelCtrl"
	})
	.otherwise({
		templateUrl: "views/404.html"
	});

	$locationProvider.html5Mode(false).hashPrefix('!');
});