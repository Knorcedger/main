var app = angular.module("VideoDownload", []);

app.service("VideoService", function($rootScope, $http) {

	var service = {
		url: "http://fashionway.gr/t/fetch.php",
		videos: {},
	}

	function _setVideos(videos) {
		service.videos = videos;
		$rootScope.$broadcast("videosUpdated");
	}

	return {
		getUrl: function() {
			return service.url;
		},
		setVideos: function(videos) {
			_setVideos(videos);
		},
		getVideos: function() {
			return service.videos;
		},
		fetchVideos: function(params) {
			var req = $http.post(service.url, {
				"stream": params.stream,
				"limit": params.limit,
				"offset": params.offset
			});

			req.success(function(data, status, headers, config) {
				_setVideos(data);
				params.success(data, status, headers, config);
			});
		}
	};
});

app.service("MessageService", function($rootScope) {

	var service = {
		text: "",
		type: "info"
	}

	/*_setType function(type) {
		service.type = type;
	}*/

	return {
		getMessage: function() {
			return service;
		},
		setMessage: function(message) {
			service.text = message.text;
			service.type = message.type;
			$rootScope.$broadcast("messageUpdated");
		}
	};
});

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

app.controller("MessageCtrl", function($scope, MessageService) {
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
});

app.controller("VideoCtrl", function($scope, $http, VideoService) {
	// on videosUpdated, update the model
	$scope.$on("videosUpdated", function() {
		$scope.videos = VideoService.getVideos();
	});

});

app.controller("PaginationCtrl", function($scope, $http, VideoService, MessageService) {
	$scope.page = 1;
	$scope.channel = "";
	$scope.stream = "";
	$scope.limit = 20;
	$scope.offset = 0;

	setTimeout(function(){console.log($scope.stream)},5000);

	$scope.fetch = function() {
		$scope.stream = "http://api.justin.tv/api/channel/archives/" + $scope.channel + ".json";
		var params = {
			stream: $scope.stream,
			limit: $scope.limit,
			offset: $scope.offset,
			success: function(data, status, headers, config) {
				// if (data.error) {
				var message = {
					text: "Take it slow dude. You now have to wait a few seconds",
					type: "warning"
				}
				MessageService.setMessage(message);
				// }
			}
		}
		VideoService.fetchVideos(params);
	}

	$scope.previousPage = function() {
		if($scope.page !== 1) {
			$scope.page--;
			$scope.$broadcast("pageChanged");
		}
	}

	$scope.nextPage = function() {
		$scope.page++;
		$scope.$broadcast("pageChanged");
	}

	$scope.$on("pageChanged", function() {
		$scope.offset = $scope.limit * ($scope.page - 1);
		$scope.fetch();
	});

	$scope.$on("pageChanged", function() {
		$scope.offset = $scope.limit * ($scope.page - 1);
		$scope.fetch();
	});

});