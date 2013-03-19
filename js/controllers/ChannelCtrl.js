"use strict";

TwitchDownload.controller("ChannelCtrl", function($scope, $rootScope, $routeParams, $location, Channel) {

	if ($routeParams.channel) {
		Channel.set($routeParams.channel);
	}

	$scope.channelTitle = Channel.get();

	$rootScope.$on("channel.archives.success", function(event, args) {
		$scope.videos = args.data;
	});

});