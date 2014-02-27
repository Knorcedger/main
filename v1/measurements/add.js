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
		permissioner(['!null'])
	], this.index);
};

exports.index = function(req, res) {
	GLOBAL.log('measurements.add');
	
	var requestData = req.data.requestData;
	var measurement = new Measurement();
	
	measurement.create(req, {
		userId: req.data.activeUser._id,
		data: requestData.data
	}).then(function(result) {
		req.data.response.data = result;
		responseBuilder.send(req, res);
	});
};