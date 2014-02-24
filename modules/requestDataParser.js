/**
 * A module that reads the request data and saves them on res.data.requestData
 */

var _ = require('lodash');

module.exports = function(req, res, next) {

	if(req.route.method === "post" || req.route.method === 'put') {
		req.data.requestData = _.extend(req.body, req.query);
	} else if(req.route.method === "get") {
		req.data.requestData = req.query;
	}

	GLOBAL.log('requestDataParser.dataFound.success', req.data.requestData);
	next();
};