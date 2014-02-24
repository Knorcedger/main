var toast = angular.module('toast', ['eventPublisher']);

toast.directive('toast', function($timeout) {
	return {
		restrict: 'E',
		replace: true,
		template: '<span id="toast" ng-show="message">{{message}}</span>',
		link: function(scope, element, attrs) {
			scope.timeout = attrs.timeout || 3000;
			
			scope.$on('toast.display', function(event, data) {
				scope.message = data.message;
				$timeout(function() {
					scope.reset();
				}, data.timeout || scope.timeout);
			});
			
			/**
			 * Removes the message
			 */
			scope.reset = function() {
				scope.message = '';
			};
			
			scope.reset();
		}
	};
});