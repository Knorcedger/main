"use strict";

var SwiftMessenger = angular.module("SwiftMessenger", []);

SwiftMessenger.directive("message", function(SwiftMessengerService) {
	return {
		restrict: "E",
		replace: true,
		template: '<span class="message-panel {{message.type}}" ng-class="{hidden: !message.text}">{{message.text}}</span>',
		scope: {
		},
		controller: function($scope, $timeout, SwiftMessengerService) {
			$scope.message = {};
			$scope.message = SwiftMessengerService.getMessage();
			$scope.timeout = 5000;

			/**
			 * Removes the message
			 */
			$scope.remove = function() {
				$scope.message.text = "";
				$scope.message.type = "info";
			};
			
			/**
			 * On SwiftMessagerUpdated, get the message by the service
			 */
			$scope.$on("SwiftMessagerUpdated", function(value) {
				$scope.message = SwiftMessengerService.getMessage();
				if($scope.message.text) {
					$timeout(function() {
						$scope.remove();
					}, $scope.timeout);
				}
			}, true);
		}
	};
});

SwiftMessenger.service("SwiftMessengerService", function($rootScope) {

	var service = {
		text: "",
		type: "info"
	};

	return {
		getMessage: function() {
			return service;
		},
		setMessage: function(message) {
			service.text = message.text;
			service.type = message.type;
			$rootScope.$broadcast("SwiftMessagerUpdated");
		}
	};

});