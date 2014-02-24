var cordovaWrapper = angular.module('cordovaWrapper', []);

cordovaWrapper.ready = false;

cordovaWrapper.provider('cordovaWrapper', {
	init: function() {
		document.addEventListener('deviceready', function () {
			cordovaWrapper.ready = true;
		});
	},
	$get: function($window, eventPublisher) {
		return {
			device: function() {
				var result = undefined;
				
				if (cordovaWrapper.ready) {
					eventPublisher.publish('cordovaWrapper.device.success', $window.device);
				} else {
					document.addEventListener('deviceready', function () {
						eventPublisher.publish('cordovaWrapper.device.success', $window.device);
					});
				}				
			}
		}
	}
});