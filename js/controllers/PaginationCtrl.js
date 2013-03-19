"use strict";

TwitchDownload.controller("PaginationCtrl", function($scope, $routeParams, $rootScope, root, API, SwiftMessengerService) {
	//Define the model
	$routeParams.page = parseInt($routeParams.page, 10);
	$scope.root = root;
	$scope.page = $routeParams.page || 1;
	$scope.limit = 20;
	$scope.offset = ($routeParams.page - 1) * $scope.limit;
	$scope.channel = $routeParams.channel;
	
	$scope.nextPage = function() {
		return "/page/" + ($scope.page + 1);
	}
	$scope.previousPage = function() {
		if ($scope.page > 2) {
			return "/page/" + ($scope.page - 1);
		} else {
			return "";
		}
	}

	//Calls the ChannelService to fetch new videos
	$scope.fetch = function() {
		var data = {
			limit: $scope.limit,
			offset: $scope.offset
		}

		var channelPromise = API.channel.archives.get(data);
		channelPromise.then(function(response) {
			if (response.error) {
				SwiftMessengerService.setMessage({
					text: response.error,
					type: "warning"
				});
				//also restore the previous values
				$scope.page = $scope.copy.page;
				$scope.offset = $scope.copy.offset;
			} else {
			}
		});
	}

	$scope.fetch();


	
});