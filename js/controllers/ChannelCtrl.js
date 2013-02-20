"use strict";

app.controller("ChannelCtrl", function($scope, $http, $log, $location, $route, $routeParams, ChannelService) {
	console.log($routeParams);
	console.log($route);
	console.log("channel url: " + $routeParams.channel);

	/**
	 * Define the model
	 */
	$scope.newChannelName;
	$scope.newPage;
	$scope.messageText = "Welcome man, type the channel you want in the searchbox";
	$scope.messageType = "info";

	$scope.channel = {
		name: "",
		streamUrl: "",
		videos: {},
		pagination: {
			page: 1,
			limit: 20,
			offset: 0
		}
	};

	/**
	 * Watches for channel name changes and then it updates the streamUrl and initiates a video update
	 */
	$scope.$watch("channel.name", function(value) {
		$scope.channel.streamUrl = "http://api.justin.tv/api/channel/archives/" + value + ".json";
		$log.info($scope.channel);

		if (value !== "") {
			$scope.fetch();
		}
		$scope.parent = $scope.channel.name;
	});

	/**
	 * On form submit, update the channel name
	 */
	$scope.submit = function() {
		$scope.channel.name = $scope.newChannelName;
	}

	/**
	 * Calls the ChannelService to fetch new videos
	 */
	$scope.fetch = function() {
		var params = {
			streamUrl: $scope.channel.streamUrl,
			limit: $scope.channel.pagination.limit,
			offset: $scope.channel.pagination.offset
		}

		var channelPromise = ChannelService.channel($scope.channel.name).videos.get({params:params, filter:{}});
		channelPromise.then(function(response) {
			if (response.error) {
				$scope.messageText = response.error;
				$scope.messageType = "warning";
			} else {
				// update the model
				$scope.channel.videos = response;
				$location.path("/channel/" + $scope.channel.name);
			}
		});
	}

	$scope.changePage = function(action) {
		if (action === "next") {
			$scope.channel.pagination.page++;
		} else if (action === "previous" && $scope.channel.pagination.page !== 1) {
			$scope.channel.pagination.page--;
		}
		$scope.channel.pagination.offset = $scope.channel.pagination.limit * ($scope.channel.pagination.page - 1);
		$scope.fetch();
		$scope.$broadcast("pageChanged");
	}

});