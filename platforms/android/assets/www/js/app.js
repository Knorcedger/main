var Witer = angular.module('Witer', [
'ngRoute',
'ngAnimate',
'ngTouch',
'eventPublisher',
'browserStorage',
'eventDriven',
'pascalprecht.translate',
'locationDecorator',
'logDecorator',
'actionbar',
'preferences',
'modal',
'cordovaWrapper',
'toast',
'firebase'
]);

Witer.constant('firebaseUrl', 'https://flickering-fire-1863.firebaseio.com/witer');

Witer.config(function($routeProvider, $locationProvider, $httpProvider, $logProvider, $translateProvider, eventPublisherProvider, edProvider, cordovaWrapperProvider) {
	$logProvider.debug = true;
	
	eventPublisherProvider.config({
		mode: 'debug',
		logSize: 0,
		publishProgress: true
	});
	
	$locationProvider.html5Mode(false).hashPrefix('!');

	$translateProvider.useUrlLoader('js/l10n/en_US.json');
	$translateProvider.preferredLanguage('en_US');

	cordovaWrapperProvider.init();
	
	$routeProvider.when("/", {
		templateUrl: "views/home.html",
		controller: "home"
	})
	.when("/input", {
		templateUrl: "views/input.html",
		controller: "input"
	})
	.when("/history", {
		templateUrl: "views/history.html",
		controller: "history"
	})
	.when("/settings", {
		templateUrl: "views/settings.html",
		controller: "settings"
	})
	.when("/sync", {
		templateUrl: "views/sync.html",
		controller: "sync"
	});
});