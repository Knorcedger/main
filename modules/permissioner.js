/**
 * Permissioner module
 *
 * It defines if the user that makes the request can access this service
 * It take 2 types or parameters.
 *
 * 1) An array with the userTypes that can access this service e.g.: ['editor', 'client']. null is used for public service
 * 2) An expression that will be evaluated e.g.: "id === 'self' && type === 'client'"
 * The variables that are available for the expression are "type" for the userType and "id" for the request uuid
 *
 * NOTICE: The admin user can execute all services
 */
var loadUser = require('./loadUser');
var errorHandler = require('./errorHandler');
var _ = require('lodash');

module.exports = function(access) {

	return function(req, res, next) {
		GLOBAL.log('permissioner');

		// check which case is, array or string
		if (_.isArray(access)) {
			// access null means the service is public
			// load the user to validate him against the permissions
			req.on('loadUser.success', function(user) {
				if (access[0] === 'null' || access[0] === '!null' && user !== 'null' || user.type === 'admin') {
					next();
				} else if (access.indexOf(user.type) !== -1) {
					next();
				} else {
					errorHandler.error(req, res, 'NO_PERMISSION');
				}
			});

			loadUser(req);
		} else {
			req.on('loadUser.success', function(user) {
				type = user.type;

				// if the expression is true or user is admin
				if (eval(access) || type === 'admin') {
					next();
				} else {
					errorHandler.error(req, res, 'NO_PERMISSION');
				}
			});
			// set the type and id variables
			var id = req.params.id;
			var type;

			loadUser(req);
		}

	};
};