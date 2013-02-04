var app = angular.module("VideoDownload", []);

app.factory("Videos", function() {
	var Videos = [
		{
			parts: [
				{
					image_url_medium: "http://static-cdn.jtvnw.net/jtv.thumbs/archive-350366166-320x240.jpg",
					title: "Scarra's stream. Solo Q.Q. Trying out some new playlists. Playing a few before dinner.",
					created_on: "2012-12-23 02:50:23 UTC",
					file_size: "481327322",
					video_file_url: "http://media25.justin.tv/archives/2012-12-23/live_user_scarra_1356229192.flv"
				},
				{
					image_url_medium: "http://static-cdn.jtvnw.net/jtv.thumbs/archive-350366166-320x240.jpg",
					title: "2 Scarra's stream. Solo Q.Q. Trying out some new playlists. Playing a few before dinner.",
					created_on: "2012-12-23 02:50:23 UTC",
					file_size: "481327322",
					video_file_url: "http://media25.justin.tv/archives/2012-12-23/live_user_scarra_1356229192.flv"
				}
			]
		},
		{
			parts: [
				{
					image_url_medium: "http://static-cdn.jtvnw.net/jtv.thumbs/archive-350366166-320x240.jpg",
					title: "Scarra's stream. Solo Q.Q. Trying out some new playlists. Playing a few before dinner.",
					created_on: "2012-12-23 02:50:23 UTC",
					file_size: "481327322",
					video_file_url: "http://media25.justin.tv/archives/2012-12-23/live_user_scarra_1356229192.flv"
				},
				{
					image_url_medium: "http://static-cdn.jtvnw.net/jtv.thumbs/archive-350366166-320x240.jpg",
					title: "2 Scarra's stream. Solo Q.Q. Trying out some new playlists. Playing a few before dinner.",
					created_on: "2012-12-23 02:50:23 UTC",
					file_size: "481327322",
					video_file_url: "http://media25.justin.tv/archives/2012-12-23/live_user_scarra_1356229192.flv"
				}
			]
		}
	];

	return Videos;
});

app.directive("displayDownloads", function() {
	return function(scope, element) {
		element.bind("click", function() {
			var downloads = $(element).parent().find(".downloads");
			if (downloads.is(":visible")) {
				downloads.fadeOut();
			} else {
				$(".downloads").fadeOut();
				downloads.fadeIn();
			}
		})
	}
});

function VideoCtrl($scope, Videos, $http) {

	console.log($http.defaults.headers);
	//$http.defaults.headers.post["Host"] = "wikipedia.com";
	//$http.defaults.headers.post["Access-Control-Allow-Origin"] = "*";

	$('#main').load('http://google.com');

	$.ajax({
		dataType: "json",
		url: 'http://api.justin.tv/api/channel/archives/scarra.json',
		data: {},
		success: function(data) {
			debugger;
		}
	});

	/*$http.post('http://api.justin.tv/api/channel/archives/scarra.json').success(function(data) {
		debugger;
		$scope.phones = data;
	});*/

	$scope.videos = Videos;

};