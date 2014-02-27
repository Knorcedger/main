/**
 * Adds a new user in the database.
 */

require("../../schemas/measurementSchema");
var Measurement = require('mongoose').model('Measurement');

var responseBuilder = require('../../modules/responseBuilder');
var permissioner = require("../../modules/permissioner");
var errorHandler = require('../../modules/errorHandler');

exports.init = function(app) {
	app.post('/v1/measurements/update', [
		permissioner(['!null'])
	], this.index);
};

exports.index = function(req, res) {
	GLOBAL.log('measurements.update');
	var requestData = req.data.requestData;
	var measurement = new Measurement();

	measurement.findOneAndUpdate(req, {
		userId: req.data.activeUser._id
	}, {
		data: requestData.data
	}).then(function(result) {
		req.data.response.data = result;
		responseBuilder.send(req, res);
	});
};