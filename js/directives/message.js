TwitchDownload.directive("message", function() {
	return {
		restrict: "E",
		replace: true,
		template: '<span class="message-panel {{messageType}}" ng-class="{hidden: !messageText}">{{messageText}}</span>',
		scope: {
			messageText: "=messageText",
			messageType: "=messageType",
		},
		controller: function($scope, $timeout) {
			$scope.messageTimeout = 5000;
			
			$scope.$watch("messageText", function(value) {
				if($scope.messageText) {
					$timeout(function() {
						$scope.messageText = "";
						$scope.messageType = "info";
					}, $scope.messageTimeout);
				}
			}, true);
		}
	}
})