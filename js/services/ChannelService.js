"use strict";

TwitchDownload.service("ChannelService", function($rootScope, $http) {

	var service = {
		url: "http://fashionway.gr/t/fetch.php"
	}

	/*function _setCache(response) {
		service.cache.videos = response.data;
		service.cache.streamUrl = response.config.streamUrl;
		$rootScope.$broadcast("videosUpdated");
	}*/

	return {
		channel: function(title){
			return {
				videos: {
					post: function(filter) {
						// adds a new video
					},
					/**
					 * Reads videos, based on the given filter
					 * @param  {Object} data Includes the params and the filters
					 * @return {Object} The videos found
					 */
					get: function(data) {
						return $http.post(service.url, {
							"url": data.params.url,
							"limit": data.params.limit,
							"offset": data.params.offset
						}).then(function(response) {
							return response.data;
						});
					},
					put: function() {
						//updates all videos
						//or updates the video found if an object is given
					},
					delete: function() {
						//deletes all videos
						//or deletes the video found if an object is given
					}
				
				}
			}
		}
		/*getUrl: function() {
			return service.url;
		},*/
		/*setVideos: function(videos) {
			_setVideos(videos);
		},*/
		/*getVideos: function() {
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
		}*/
	};
});