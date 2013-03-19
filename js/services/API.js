"use strict";

TwitchDownload.service("API", function($rootScope, $http, Channel) {

	// var url = "http://api.justin.tv/api/channel/archives/"/* + $scope.channel + ".json"*/;
	var serviceUrl = "http://fashionway.gr/t/fetch.php",
		baseUrl = "http://api.justin.tv/api/channel/archives/",
		//secret = "f3fd358bb6a7e15fb70d14c242644a3b05dc68d0e7f749bb583fece98bd178b8",
		timeout = 5000;

	function request(config, event) {
		return $http(config).then(function(response) {
			return successCallback(response, event);
		},function(response){
			return failCallback(response, event);
		});
	}

	function addSettings(url, method, data, params) {
		var config = {};
		if (method === "GET") {
			config.params = params;
			config.params.url = baseUrl + url + ".json";		
		} else {
			config.data = data;
			config.data.url = baseUrl + url + ".json";		
		}

		config.url = serviceUrl;
		config.method = method;
		config.timeout = timeout;

		return config;
	}

	function successCallback(response, event) {
		if (!response.error) {
			$rootScope.$broadcast(event + ".success", response);
			console.log(event + ".success");
		} else {
			$rootScope.$broadcast(event + ".error", response);
			console.log(event + ".error");
		}
		console.log(response);
		console.groupEnd();
		return response;
	}

	function failCallback(response, event) {
		$rootScope.$broadcast(event + ".fail", response);
		console.log(event + ".fail");
		console.log(response);
		console.groupEnd();
		return response;		
	}

	return {
		channel: {
			archives: {
				get: function(data) {
					console.groupCollapsed("Getting videos for channel '%s'", Channel.get());
					var config = addSettings(Channel.get(), "POST", data, undefined);
					return request(config, "channel.archives");
				}
			}
		}
	}

});