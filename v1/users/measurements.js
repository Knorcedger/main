/**
 * Gets a users measurements
 */

require("../../schemas/measurementSchema");
var Measurement = require('mongoose').model('Measurement');

var responseBuilder = require('../../modules/responseBuilder');
var permissioner = require("../../modules/permissioner");
var errorHandler = require('../../modules/errorHandler');

exports.init = function(app) {
	app.get('/v1/users/:id/measurements', [
		permissioner("id === 'self'"),
	], this.index);
};

exports.index = function(req, res) {
	GLOBAL.log('users.measurements');
	var requestData = req.data.requestData;
	var measurement = new Measurement();
	
	measurement.findOne(req, {
		userId: req.data.activeUser._id
	}).then(function(result) {
		req.data.response.data = result;
		responseBuilder.send(req, res);
	});
};