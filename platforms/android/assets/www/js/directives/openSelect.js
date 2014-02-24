Witer.directive('openSelect', function() {
	return {
		restrict: 'A',
		link: function(scope, element, attrs) {
			element.bind('click', function(event) {
				var element = document.getElementById(attrs.openSelect);
				if (document.createEvent) {
					var e = document.createEvent("MouseEvents");
					e.initMouseEvent("mousedown", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
					element.dispatchEvent(e);
				}
			});
		}
	};
});