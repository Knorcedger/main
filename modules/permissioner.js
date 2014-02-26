/**
 * Permissioner module
 *
 * It defines if the user that makes the request can access this service
 * It take 2 types or parameters.
 *
 * 1) An array with the userTypes that can access this service e.g.: ['editor', 'client']. null is used for public service
 * 2) An expression that will be evaluated e.g.: "id === 'self' && userType === 'client'"
 * The variables that are available for the expression are "userType" for the userType and "id" for the request uuid
 *
 * NOTICE: The admin user can execute all services
 */
var authenticator = require('./authenticator');
var errorHandler = require('./errorHandler');
var _ = require('lodash');

module.exports = function(access) {

	return function(req, res, next) {
		GLOBAL.log('permissioner');

		// check which case is, array or string
		if (_.isArray(access)) {
			// if its public service, just go on
			if (access[0] === 'null') {
				next();
			} else {
				authenticator(req, res)
				.then(function(result) {
					var userType = req.data.activeUser && req.data.activeUser.type;
					if (access[0] === '!null' && userType !== 'null' || userType === 'admin') {
						next();
					} else if (access.indexOf(user.type) !== -1) {
						next();
					} else {
						errorHandler.error(req, res, 'NO_PERMISSION');
					}
				}, function(result) {
					// on reject, we do nothing, 
					// authenticator already called errorHandler
				});
			}
		} else {
			
			// set the type and id variables
			var id = req.params.id;
			var type;
			
			authenticator(req, res)
			.then(function(result) {
				var userType = req.data.activeUser && req.data.activeUser.type;
				// if the expression is true or user is admin
				if (eval(access) || userType === 'admin') {
					next();
				} else {
					errorHandler.error(req, res, 'NO_PERMISSION');
				}
			});
		}

	};
};