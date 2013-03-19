"use strict"

TwitchDownload.directive("list", function() {
	return {
		priority: 0,
		restrict: "E",
		replace: true,
		transclude: true,
		template: '<div ng-transclude></div>',
	}
});