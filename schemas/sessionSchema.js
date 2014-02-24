var mongoose = require('mongoose');
var nconf = require('nconf');
var db = require('../modules/db');
var Promise = require('es6-promise').Promise;
var Schema   = mongoose.Schema;
require("../models/User");

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

sessionSchema.methods.add = function(req, saveParams) {
	GLOBAL.log('Session.add');

	var promise = new Promise(function(resolve, reject) {
		var Session = mongoose.model('Session', sessionSchema);
		var session = new Session(saveParams);
		
		db.save(req, session)
		.then(function(result) {
			resolve(result);
		});
	});
	
	return promise;
}

sessionSchema.methods.findOne = function(req, queryParams) {
	GLOBAL.log('Session.findOne', queryParams);
	
	var promise = new Promise(function(resolve, reject) {
		var Session = mongoose.model('Session', sessionSchema);
		var query = Session.findOne(queryParams);
		
		db.exec(req, query)
		.then(function(result) {
			debugger;
			resolve(result);
		})
	});
	
	return promise;
}

sessionSchema.methods.findById = function(req, id) {
	GLOBAL.log('Session.findById', id);
	
	var promise = new Promise(function(resolve, reject) {
		var Session = mongoose.model('Session', sessionSchema);
		var query = Session.findById(id);
		
		db.exec(req, query).then(function(result) {
			resolve(result);
		})
	});
	
	return promise;
}

mongoose.model('Session', sessionSchema);