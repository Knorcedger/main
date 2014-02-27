var mongoose = require('mongoose');
var nconf = require('nconf');
var db = require('../modules/db');
var Promise = require('es6-promise').Promise;
var Schema = mongoose.Schema;
var schemaExtender = require('../modules/schemaExtender');

var sessionSchema = mongoose.Schema({
	expires: { type: Date, default: Date.now() + nconf.get('session').timeout },
	userId: { type: Schema.Types.ObjectId, ref: 'User', required: true }
}, {
	collection: 'sessions'
});

// says which attributes each user role can see
sessionSchema.methods.getFilters = function() {
	return {
		_id: ['null'],
		expires: ['null'],
		userId: ['null']
	};
};

sessionSchema.methods.create = function(req, save) {
	return schemaExtender.create(req, sessionSchema, 'Session', save);
}

sessionSchema.methods.findOne = function(req, query) {
	return schemaExtender.findOne(req, sessionSchema, 'Session', query);
}

sessionSchema.methods.findById = function(req, id) {
	return schemaExtender.findById(req, sessionSchema, 'Session', id);
}

mongoose.model('Session', sessionSchema);