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
'restangular'
]);

Witer.config(function($routeProvider, $locationProvider, $httpProvider, $logProvider, $translateProvider, eventPublisherProvider, edProvider, cordovaWrapperProvider, RestangularProvider) {
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
	
	RestangularProvider.setBaseUrl('http://localhost:2000/v1');
	
	RestangularProvider.addFullRequestInterceptor(function(element, operation, route, url, headers, params, httpConfig) {
// 		if (!element) {
// 			element = {};
// 		}
// 		element.secret = '1234';
		params = _.extend(params, {secret: '1234'})
		
		var activeUser = angular.fromJson(localStorage.getItem('activeUser'));
		if (activeUser) {
// 			element.token = activeUser.data.token;
			params = _.extend(params, {token: activeUser.data.token})
		}
		
		return {
			element: element,
			params: params,
			headers: headers,
			httpConfig: httpConfig
		};
	});

	$routeProvider.when("/", {
		templateUrl: "views/home.html",
		controller: "home",
		resolve:{
			measurementData: function ($q, measurements) {
				var deferred = $q.defer();
				
				measurements.sync()
				.then(function(result) {
					deferred.resolve(result);
				});
				
				return deferred.promise;
			}
		}
	})
	.when("/input", {
		templateUrl: "views/input.html",
		controller: "input",
		resolve:{
			measurementData: function ($q, measurements) {
				var deferred = $q.defer();
				
				measurements.get()
				.then(function(result) {
					deferred.resolve(result);
				});
				
				return deferred.promise;
			}
		}
	})
	.when("/history", {
		templateUrl: "views/history.html",
		controller: "history",
		resolve:{
			measurementData: function ($q, measurements) {
				var deferred = $q.defer();
				
				measurements.get()
				.then(function(result) {
					deferred.resolve(result);
				});
				
				return deferred.promise;
			}
		}
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