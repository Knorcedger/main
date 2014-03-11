var toast = angular.module('toast', ['eventPublisher']);

toast.directive('toast', function($timeout, toast) {
	return {
		restrict: 'E',
		replace: true,
		template: '<span id="toast" ng-show="message">{{message}}</span>',
		link: function(scope, element, attrs) {
			
			scope.$on('toast.display', function(event, message, timeout) {
				var self = this;
				
				// clear any previous messages
				setMessage('');
				
				// first find the timeout, because on message set, the timeout will start
				timeout = timeout || 3000;
				setMessage(message);

				// remove the message after the specified timeout
				// we use self to save the timeout, since timeouts are executed on global scope
				function setTimeout() {
					// cancel the previous timeout, if it exists
					self.timeoutPromise && $timeout.cancel(self.timeoutPromise);
					// create new timeout
					self.timeoutPromise = $timeout(function() {
						setMessage.call(self, '');
					}, timeout);
				}

				// Removes the message
				function setMessage(message) {
					// if we set a message, also set the timeout
					if (message) {
						setTimeout();
					}
					scope.message = message;
// 					scope.$apply();
				};
			});
		}
	};
});

toast.service('toast', function($timeout, $rootScope) {
	return {
		display: function(message, timeout) {
			$rootScope.$broadcast('toast.display', message, timeout);
		}
	}
});