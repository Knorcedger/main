/**
 * A logging module
 */

var colors = require('colors');
var nconf = require('nconf');

// consoleLogs a variable that holds all the logs for each request
// currentRes is a reference to the current res
var consoleLogs, currentRes;

exports.init = function() {
	GLOBAL.log = function(label, data) {
		if (data) {
			console.log(label.green, data);
		} else {
			console.log(label.green);
		}
	};
};

// on each request start, we create the data attribute on req and start the profiling
exports.start = function(req, res, next) {
	req.data = {
		profiling: {
			start: (new Date()).getTime()
		}
	};
	GLOBAL.log('');
	GLOBAL.log(req.method, req.originalUrl);
	res.on("finish", function() {
		req.data.profiling.end = (new Date()).getTime();
		req.data.profiling.time = req.data.profiling.end - req.data.profiling.start;
		GLOBAL.log('END', req.data.profiling.time);
	});

	next();
};