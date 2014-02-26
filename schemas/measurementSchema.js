var mongoose = require('mongoose');
var db = require('../modules/db');
var Schema   = mongoose.Schema;
var schemaExtender = require('../modules/schemaExtender');

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
	return schemaExtender.add(req, measurementSchema, 'Measurement', saveParams);
}

measurementSchema.methods.update = function(req, instance) {
	return schemaExtender.update(req, measurementSchema, 'Measurement', instance);
}

measurementSchema.methods.findOne = function(req, queryParams) {
	return schemaExtender.findOne(req, measurementSchema, 'Measurement', queryParams);
}

mongoose.model('Measurement', measurementSchema);