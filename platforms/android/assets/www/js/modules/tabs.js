var toast = angular.module('tabs', ['eventPublisher']);

toast.directive('tabs', function($timeout) {
	return {
		restrict: 'E',
		replace: true,
		template: '<div id="tabs"><span ng-repeat="tab in tabs">{{tab}}</span></div>',
		link: function(scope, element, attrs) {
			
		}
	};
});