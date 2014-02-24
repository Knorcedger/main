var errorHandler = require('./errorHandler');
var _ = require('lodash');
var Promise = require('es6-promise').Promise;

/**
 * Runs the validations defined in the service
 * Async validations take req and resolve as params, and must resolve true or false
 */
 
// based on the validations result, says next, or calls errorHandler
module.exports = function(req, res, next, validations) {

	GLOBAL.log('validationsRunner');
	
	// here we will save all the asyncValidations errorCodes
	var asyncValidations = [];
	// we use this function to avoid calling the asyncValidations if a sync validation failed
	var errorFound = false;

	// for each field that needs validations
	for (var field in validations) {
		// for each validation (order by possible error)
		for (var error in validations[field]) {
			// if its a function, add it to the asyncValidations list
			if (_.isFunction(validations[field][error])) {
				asyncValidations.push({
					validation: validations[field][error],
					errorCode: field + '.' + error
				});
			} else {
				if (!validations[field][error]) {
					errorHandler.error(req, res, field + '.' + error);
					errorFound = true;
				}
			}
		}
	}
	
	// if no error found yet
	if (!errorFound) {
		// and if asyncValidations found, call them
		if (asyncValidations.length) {
			var promises = [];
			for (var i = 0, length = asyncValidations.length; i < length; i++) {
				var promise = new Promise(function(resolve, reject) {
					asyncValidations[i].validation(req, resolve);
				});
				promises.push(promise);
			}
			// when all promises are resolved, they must return true or false
			Promise.all(promises)
			.then(function(results) {
				for (var i = 0, length = results.length; i < length; i++) {
					if (!results[i]) {
						errorHandler.error(req, res, asyncValidations[i].errorCode);
						errorFound = true;
						break;
					}
				}
				// no async error found, so keep going strong
				if (!errorFound) {
					next();
				}
			});
		} else {
			// no error found, no async, so just go on
			next();
		}
	}
}