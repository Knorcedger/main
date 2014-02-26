/*
Retrieves the session declared by the token parameter. Then retrieves the user by the userId
written on session document and attaches it to the req.data.parsedData
 */
require("../schemas/sessionSchema");
var Session = require('mongoose').model('Session');
require("../schemas/userSchema");
var User = require('mongoose').model('User');

var Promise = require('es6-promise').Promise;
var errorHandler = require('./errorHandler');
var validator = require('validator');

module.exports = function(req, res) {
	GLOBAL.log('authenticator');
	
	var session = new Session();
	var user = new User();

	return new Promise(function(resolve, reject) {
		
		// check if the token is a valid id
		if (validator.isId(req.data.requestData.token)) {
			// search for this session id
			session.findById(req, req.data.requestData.token)
			.then(function(result) {
				// if session found
				if (result !== 'notFound') {
					// search for this user
					user.findById(req, result.userId)
					.then(function(result) {
						if (result !== 'notFound') {
							req.data.activeUser = result;
							resolve();
						} else {
							// this error should never happen, since we never delete sessions
							errorHandler.error(req, res, 'USER_NOT_FOUND');
							reject('USER_NOT_FOUND');
						}
					});
				} else {
					errorHandler.error(req, res, 'INVALID_SESSION');
					reject('INVALID_SESSION');
				}
			});
		} else {
			errorHandler.error(req, res, 'INVALID_SESSION');
			reject('INVALID_SESSION');
		}
	});
};