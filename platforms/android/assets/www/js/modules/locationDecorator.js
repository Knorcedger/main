/**
 * This is a decorator that modifies the $location service. It modifies 
 * the method path. This method displays on debug the user redirection
 * for debugging reasons.
 */
var locationDecorator = angular.module('locationDecorator', []);

locationDecorator.config(function($provide) {
	$provide.decorator("$location", function($delegate, $log) {
		var originalPath = $delegate.path;
		$delegate.path = function(value) {
			if (value) {
				$log.debug('Redirect', value);
			}
			var path = originalPath.apply(this, arguments);
			if (path) {
				return path;
			} else {
				return this;
			}
		};
		
		return $delegate;
	});
});