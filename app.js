var app = angular.module("VideoDownload", []);

app.config(function($routeProvider, $locationProvider) {
	$routeProvider
	.when("channel/:channel",
	{
		controller: "VideoCtrl"
	})
	.otherwise({
		template: "Nothing to see here"
	});


	$locationProvider.html5Mode(false).hashPrefix('!');
})

/*app.directive("displayDownloads", function() {
	return function(scope, element) {
		element.bind("click", function() {
			scope.visibleDownloads = false;
			var downloads = $(element).parent().find(".downloads");
			if (downloads.is(":visible")) {
				downloads.fadeOut();
			} else {
				$(".downloads").fadeOut();
				downloads.fadeIn();
			}
		})
	}
});*/

/*app.directive("zoom", function() {
	return function(scope, element, attrs) {
		element.bing("mouseenter", function() {
			debugger;
		})
	}
})*/

/*app.controller("MessageCtrl", function($scope, MessageService) {
	$scope.messageTimeout = 5000;
	$scope.text = "";
	$scope.type = "info";
	//on messageUpdated event, update our model from the service
	$scope.$on("messageUpdated", function() {
		$scope.text = MessageService.getMessage().text;
		$scope.type = MessageService.getMessage().type;
		// remove the message
		if($scope.text) {
			setTimeout(function() {
				MessageService.setMessage({message: "", type: "info"});
			}, $scope.messageTimeout);
		}
	});
});*/