var mongoose = require('mongoose');
var db = require('../modules/db');
var Promise = require('es6-promise').Promise;
var Schema   = mongoose.Schema;

var mainSchema = mongoose.Schema();



mainSchema.methods.add = function(req, saveParams) {
	GLOBAL.log('Session.add');

	var promise = new Promise(function(resolve, reject) {
		var Session = mongoose.model('Session', mainSchema);
		var session = new Session(saveParams);
		
		db.save(req, session)
		.then(function(result) {
			resolve(result);
		});
	});
	
	return promise;
}

mainSchema.methods.findOne = function(req, queryParams) {
	GLOBAL.log('Session.findOne', queryParams);
	
	var promise = new Promise(function(resolve, reject) {
		var Session = mongoose.model('Session', mainSchema);
		var query = Session.findOne(queryParams);
		
		db.exec(req, query)
		.then(function(result) {
			debugger;
			resolve(result);
		})
	});
	
	return promise;
}

mainSchema.methods.findById = function(req, id) {
	GLOBAL.log('Session.findById', id);
	
	var promise = new Promise(function(resolve, reject) {
		var Session = mongoose.model('Session', mainSchema);
		var query = Session.findById(id);
		
		db.exec(req, query).then(function(result) {
			resolve(result);
		})
	});
	
	return promise;
}

mongoose.model('Session', mainSchema);