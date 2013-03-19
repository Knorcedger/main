"use strict"

TwitchDownload.directive("videolist", function() {
	return {
		priority: 0,
		restrict: "E",
		//require: "pagination",
		replace: true,
		transclude: true,
		templateUrl: 'views/videolist.html',
		/*scope: {

		},*/
		/*compile: function(tElement, tAttrs) {
			debugger;
		},*/
		/*link: function(scope, element, attr) {
			//paginationCtrl.add();
		},
		controller: function($scope, $http, $log, $location, $route, $routeParams, $rootScope, ChannelService) {
			
			//Define the model
			$scope.newChannelName;
			$scope.messageText = "Welcome man, type the channel you want in the searchbox and press Enter";
			$scope.messageType = "info";
			$scope.channel = {
				name: "",
				//streamUrl: "",
				videos: {}
			};

			
			//Read the url channel
			if($routeParams.channel) {
				$scope.channel.name = $routeParams.channel;
			}

			$rootScope.$on("channelChanged", function(event, args) {
				$scope.channel.name = args.channelName;
			});

			$rootScope.$on("pageChanged", function(event, args) {
				//$scope.fetch();
			});

			//Watches for channel name changes and then it updates the streamUrl and initiates a video update
			$scope.$watch("channel.name", function(value) {
				$log.info($scope.channel);

				if(value !== "") {
					//$scope.fetch();
				}
				$scope.parent = $scope.channel.name;
			});
		}*/
	}
});