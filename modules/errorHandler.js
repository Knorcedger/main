var responseBuilder = require('./responseBuilder');

exports.error = function(req, res, errorCode) {
	GLOBAL.log('errorHandler.errorFound', errorCode);

	req.data.response.meta.statusCode = errorCode;
	responseBuilder.send(req, res);
}