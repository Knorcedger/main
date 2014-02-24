/**
 * Adds a new user in the database.
 */

require("../../schemas/userSchema");
var User = require('mongoose').model('User');
require("../../schemas/sessionSchema");
var Session = require('mongoose').model('Session');

var responseBuilder = require('../../modules/responseBuilder');
var crypto = require("crypto");
var validator = require('validator');
var validationsRunner = require('../../modules/validationsRunner');
var permissioner = require("../../modules/permissioner");
var errorHandler = require('../../modules/errorHandler');

exports.init = function(app) {
	app.post('/v1/authentications/login', [
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
			INVALID_CHARACTER: validator.matches(requestData.username, /^[a-z0-9_-]*$/i)
		},
		password: {
			INVALID_LENGTH: validator.isLength(requestData.password, 64, 64)
		}
	}
	
	validationsRunner(req, res, next, validations);
};

exports.index = function(req, res) {
	GLOBAL.log('authentications.login');
	var requestData = req.data.requestData;
	var session = new Session();
	var user = new User();
	
	// check if the user exists in db
	user.findOne(req, {
		username: requestData.username,
		password: crypto.createHash('sha256').update(requestData.password).digest("hex")
	}).then(function(result) {
		if (result !== 'notFound') {
			// we found the user, save him and lets find if a session already exists
			req.data.response.data = result.toObject();
			var user = req.data.response.data;
			session.findOne(req, {
				userId: user._id
			}).then(function(result) {
				if (result === 'notFound') {
					// session notFOund, so lets create a new one
					session.add(req, {
						userId: user._id
					}).then(function(result) {
						sendResponse(result._id);
					});
				} else {
					// session found, send token
					sendResponse(result._id);
				}
			});
		} else {
			errorHandler.error(req, res, 'WRONG_DATA');
		}
	});
	
	function sendResponse(token) {
		req.data.response.data.token = token;
		responseBuilder.send(req, res);
	}
};