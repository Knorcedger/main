var actionbar = angular.module('actionbar', ['eventPublisher', 'cordovaWrapper']);

actionbar.directive('actionbar', function($rootScope, $location, $timeout, $window, eventPublisher, cordovaWrapper) {
	return {
		templateUrl: 'views/actionbar.html',
		replace: false,
		restrict: 'E',
		scope: {
			menu: '='
		},
		link: function(scope, element, attrs) {

			scope.$watch('open', function(newValue, oldValue) {
				var html = document.querySelector('html');
				if (newValue === true) {
					//html.classList.add('open-menu');
// 					$window.scrollTo(0, 0);
					eventPublisher.publish('actionbar.open.success');
				} else {
					//html.classList.remove('open-menu');
					eventPublisher.publish('actionbar.close.success');
				}
			});
			
			scope.$on('actionbar.open', function() {
				scope.open = true;
			});
			
			scope.$on('actionbar.close', function() {
				scope.open = false;
			});

			scope.$on('actionbar.showButtons', function() {
				scope.showButtons = true;
				var listener = $rootScope.$on('$routeChangeSuccess', function() {
					scope.showButtons = false;
					listener();
				});
				eventPublisher.publish('actionbar.showButtons.success');
			});
			
			// devices below 4.4 dont support css transitions
			// so, we remove the redirect timeout
			scope.$on('cordovaWrapper.device.success', function(event, data) {
				if (data && parseFloat(data.version) < 4.4) {
					timeout = 0;
				}
			});

			scope.isSelected = function(item) {
				return scope.page === item.title;
			};
			
			scope.currentRoute = function(item) {
				return item.url === $location.$$path;
			};

			scope.done = function() {
				scope.showButtons = false;
				eventPublisher.publish('done.click.success');
			};

			scope.cancel = function() {
				scope.showButtons = false;
				eventPublisher.publish('cancel.click.success');
			};
			
			scope.redirect = function(url) {
				// timeout exists to allow the actionbar-close animation to complete
				$timeout(function() {
					$location.path(url);
				}, timeout);
			};
			
			// set the default timeout and check the device
			var timeout = 500;
			cordovaWrapper.device();
		}
	};
});