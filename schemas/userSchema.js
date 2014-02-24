var mongoose = require('mongoose');
var nconf = require('nconf');
var db = require('../modules/db');
var Promise = require('es6-promise').Promise;
var schemaExtender = require('../modules/schemaExtender');

var typeEnums = nconf.get('userTypes');

var userSchema = mongoose.Schema({
	username: { type: String, trim: true, unique: true },
	password: { type: String, required: true },
	created: { type: Number, required: true, default: Date.now() },
	type: { type: String, trim: true, required: true, enum: typeEnums, default: nconf.get("defaultUserType") }
}, {
	collection: 'users'
}, {
	versionKey: false 
});

// says which attributes each user role can see
userSchema.methods.getFilters = function() {
	return {
		_id: ['null'],
		username: ['null'],
		password: [],
		created: [],
		type: ['null']
	};
};

userSchema.methods.add = function(req, saveParams) {
	return schemaExtender.add(req, userSchema, 'User', saveParams);
}

userSchema.methods.findOne = function(req, queryParams) {
	return schemaExtender.findOne(req, userSchema, 'User', queryParams);
}

userSchema.methods.findById = function(req, id) {
	return schemaExtender.findById(req, userSchema, 'User', id);
}

mongoose.model('User', userSchema);