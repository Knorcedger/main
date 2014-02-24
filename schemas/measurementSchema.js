var mongoose = require('mongoose');
var db = require('../modules/db');
var Schema   = mongoose.Schema;
require("../models/User");

var measurementSchema = mongoose.Schema({
	data: {},
	userId: { type: Schema.Types.ObjectId, ref: 'User', required: true }
}, {
	collection: 'measurements'
}, {
	versionKey: false 
});

// says which attributes each user role can see
measurementSchema.methods.getFilters = function() {
	return {
		_id: ['user'],
		data: ['user'],
		userId: []
	};
};

measurementSchema.methods.add = function(req, saveParams) {
	GLOBAL.log('Measurement.add');
	
	var Measurement = mongoose.model('Measurement', measurementSchema);
	var measurement = new Measurement(saveParams);

	db.save(req, measurement, 'Measurement.add');
}

measurementSchema.methods.findOne = function(req, queryParams) {
	GLOBAL.log('Measurement.findOne', queryParams);
	
	var Measurement = mongoose.model('Measurement', userSchema);
	var query = Measurement.findOne(queryParams);
	db.exec(req, query, 'Measurement.findOne');
}

mongoose.model('Measurement', measurementSchema);