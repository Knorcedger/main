/**
 * This is a decorator that modifies the $log service. It adds the debug
 * method that it is displayed a group with logs.
 * This group contains an object with the data & meta and the error stack
 * from the Error object. The error stack provides a trace of which functions
 * were called, in what order, from which line and file.
 */
var logDecorator = angular.module('logDecorator', []);

logDecorator.config(function($provide, $logProvider) {
	
	$provide.decorator("$log", function($delegate) {
		var originalDebug = $delegate.debug;

		$delegate.debug = function(title, logs) {
			if ($logProvider.debug) {
				var error = new Error();
				var stack = error.stack;
				
				if (!(logs instanceof Array)) {
					logs = [logs];
				}
				
				console.groupCollapsed(title + ':', logs[0]);
				for (var i = 1, length = logs.length; i < length; i++) {
					console.debug(logs[i]);
				}
				console.debug(stack);
				console.groupEnd();
				// originalDebug.apply(this, arguments);
			}
		};
		
		return $delegate;
	});
});