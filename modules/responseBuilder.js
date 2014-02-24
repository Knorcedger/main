/**
 * A module that creates the response structure and will aloso send the response at the end
 */
var eventPublisher = require("./eventPublisher");
var nconf = require('nconf');

// initialize the responseBuilder to create the basic structure of the response
exports.init = function(req, res, next) {
	res.set("Content-Type", "application/json");

	req.data.response = {
		data: null,
		meta: {
			statusCode: undefined,
			version: nconf.get('version')
		}
	};
	
	GLOBAL.log('responseBuilder.init.success');

	next();
};

// the function that is called to send the actual response
exports.send = function(req, res) {
	GLOBAL.log('responseBuilder.send');
	// the statusCode is set only if there is an error, otherwise.. OK :D
	if (!req.data.response.meta.statusCode) {
		req.data.response.meta.statusCode = 'OK';
	}

	eventPublisher.publish(req, 'responseBuilder.send.success', req.data.response);
	res.send(req.data.response);
};
