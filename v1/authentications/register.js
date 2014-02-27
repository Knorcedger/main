/**
 * Adds a new user in the database.
 */

require("../../schemas/userSchema");
var User = require('mongoose').model('User');
var responseBuilder = require('../../modules/responseBuilder');
var crypto = require("crypto");
var validator = require('validator');
var validationsRunner = require('../../modules/validationsRunner');
var permissioner = require("../../modules/permissioner");
var errorHandler = require('../../modules/errorHandler');

exports.init = function(app) {
	app.post('/v1/authentications/register', [
		permissioner(['null']),
		this.sanitize,
		this.validate
	], this.index);
};

exports.sanitize = function(req, res, next) {
	req.data.requestData.username = validator.trim(validator.toString(req.data.requestData.username));
	req.data.requestData.password = validator.trim(validator.toString(req.data.requestData.password));
	
	next();
}

exports.validate = function(req, res, next) {
	var requestData = req.data.requestData;
	
	var validations = {
		username: {
			INVALID_LENGTH: validator.isLength(requestData.username, 1),
			INVALID_CHARACTER: validator.matches(requestData.username, /^[a-z0-9_-]*$/i),
			ALREADY_EXISTS: function(req, resolve) {
				var user = new User();

				user.findOne(req, {
					username: requestData.username
				}).then(function(result) {
					if (result === 'notFound') {
						resolve(true);
					} else {
						resolve(false);
					}
				});
			}
		},
		password: {
			INVALID_LENGTH: validator.isLength(requestData.password, 64, 64)
		}
	}
	
	validationsRunner(req, res, next, validations);
};

exports.index = function(req, res) {
	GLOBAL.log('authentications.register');
	var requestData = req.data.requestData;
	var user = new User();
	
	// add the new user
// 	user.add(req, {
// 		username: requestData.username,
// 		password: crypto.createHash('sha256').update(requestData.password).digest("hex")
// 	}).then(function(result) {
// 		req.data.response.data = result;
// 		responseBuilder.send(req, res);
// 	});
	
	user.create(req, {
		username: requestData.username,
		password: crypto.createHash('sha256').update(requestData.password).digest("hex")
	}).then(function(result) {
		req.data.response.data = result;
		responseBuilder.send(req, res);
	})
};