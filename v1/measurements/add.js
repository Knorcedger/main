/**
 * Adds a new user in the database.
 */

require("../../schemas/userSchema");
var User = require('mongoose').model('User');
require("../../schemas/measurementSchema");
var Measurement = require('mongoose').model('Measurement');

var responseBuilder = require('../../modules/responseBuilder');
var validator = require('validator');
var validationsRunner = require('../../modules/validationsRunner');
var permissioner = require("../../modules/permissioner");
var errorHandler = require('../../modules/errorHandler');

exports.init = function(app) {
	app.post('/v1/measurements/add', [
		permissioner(['!null']),
		this.sanitize,
		this.validate
	], this.index);
};

exports.sanitize = function(req, res, next) {	
	next();
}

exports.validate = function(req, res, next) {
	var requestData = req.data.requestData;
	
	var validations = {
		userId: {
			INVALID_ID: validator.isId(requestData.userId),
			NOT_EXIST: function(req, resolve) {
				var user = new User();

				user.findById(req, requestData.userId)
				.then(function(result) {
					if (result === 'notFound') {
						resolve(false);
					} else {
						resolve(true);
					}
				});
			}
		}
	}
	
	validationsRunner(req, res, next, validations);
};

exports.index = function(req, res) {
	GLOBAL.log('measurements.add');
	var requestData = req.data.requestData;
	var measurement = new Measurement();
	
	measurement.add(req, {
		userId: requestData.userId,
		data: requestData.data
	}).then(function(result) {
		req.data.response.data = result;
		responseBuilder.send(req, res);
	});
};