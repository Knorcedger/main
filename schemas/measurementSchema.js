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

measurementSchema.methods.create = function(req, save) {
	return schemaExtender.create(req, measurementSchema, 'Measurement', save);
}

measurementSchema.methods.findOneAndUpdate = function(req, query, update) {
	return schemaExtender.findOneAndUpdate(req, measurementSchema, 'Measurement', query, update);
}

measurementSchema.methods.findOne = function(req, query) {
	return schemaExtender.findOne(req, measurementSchema, 'Measurement', query);
}

mongoose.model('Measurement', measurementSchema);