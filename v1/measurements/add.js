/**
 * Adds a new measurement in the database.
 */

require("../../schemas/measurementSchema");
var Measurement = require('mongoose').model('Measurement');
var responseBuilder = require('../../modules/responseBuilder');
var validator = require('validator');
var validationsRunner = require('../../modules/validationsRunner');
var permissioner = require("../../modules/permissioner");

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
	next();
};

exports.index = function(req, res) {
	GLOBAL.log('measurements.add');
	var requestData = req.data.requestData;
	var measurement = new Measurement();
	
	req.on('Measurement.add.success', function(data) {		
		req.data.response.data = data;
		responseBuilder.send(req, res);
	});
	
	measurement.add(req, {
		data: requestData.data,
		userId: req.data.activeUser._id
	});
};