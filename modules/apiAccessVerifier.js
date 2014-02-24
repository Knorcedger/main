var errorHandler = require('./errorHandler');
var nconf = require('nconf');

module.exports = function(req, res, next) {
	var key = nconf.get('apikey');

	if (!req.data.requestData || !req.data.requestData.secret) {
		errorHandler.error(req, res, 'NO_APIKEY');
	} else if (key !== req.data.requestData.secret.toString()) {
		errorHandler.error(req, res, 'INVALID_APIKEY');
	} else {
		GLOBAL.log('apiAccessVerifier.verify.success');
		next();
	}
};