"use strict"

TwitchDownload.controller("ChannelSearchCtrl", function($scope, $location, $routeParams, $route, Channel) {
	$scope.channelTitle;

	/**
	 * On form submit, update the channel name
	 */
	$scope.submit = function() {
		Channel.set($scope.channelTitle);
		$location.url("/channel/" + $scope.channelTitle + "/page/1");
	}

});