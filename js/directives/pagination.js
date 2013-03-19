"use strict";

TwitchDownload.directive("pagination", function() {
	return {
		priority: 1,
		restrict: "E",
		replace: true,
		transclude: true,
		scope: {},
		templateUrl: 'views/pagination.html',
		/*scope: {

		},*/
		/*compile: function(tElement, tAttrs) {
		},*/
		/*link: function(scope, element, attr) {
			debugger;
		}*//*,
		controller: function($scope, $element, $attrs, $timeout, $rootScope, $routeParams) {
			
			this.add = function() {
				$scope.items = 1;
				console.log($scope.items);
			}

			//Define the model
			$scope.page = $routeParams.page || 1;
			$scope.offset = 0;
			$scope.limit = 20;
			$scope.position = $attrs.position;
			$scope.paginate = $attrs.paginate;
			$scope.channelName = "";

			$scope.$watch("channelName", function(value) {
				$scope.url = "http://api.justin.tv/api/channel/archives/" + $scope.channelName + "." + $scope.type;
			});

			$scope.changePage = function(action) {
				if(action === "next") {
					$scope.page++;
				} else if(action === "previous" && $scope.page !== 1) {
					$scope.page--;
				}
				$scope.offset = $scope.limit * ($scope.page - 1);
				$rootScope.$broadcast("pageChanged", {
					page: $scope.page,
					offset: $scope.offset,
					limit: $scope.limit
				});
			}

			
			//Calls the ChannelService to fetch new videos
			$scope.fetch = function() {
				var params = {
					url: $scope.channel.streamUrl,
					limit: $scope.channel.pagination.limit,
					offset: $scope.channel.pagination.offset
				}

				var channelPromise = ChannelService.channel($scope.channel.name).videos.get({
					params: params,
					filter: {}
				});
				channelPromise.then(function(response) {
					if(response.error) {
						$scope.messageText = response.error;
						$scope.messageType = "warning";
					} else {
						// update the model
						$scope.channel.videos = response;
						$location.path("/channel/" + $scope.channel.name);
					}
				});
			}
		}*/
	}
})