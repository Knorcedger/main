var mongoose = require('mongoose');
var db = require('../modules/db');
var Promise = require('es6-promise').Promise;

exports.add = function(req, customSchema, schemaName, saveParams) {
	GLOBAL.log(schemaName + '.add', saveParams);

	var promise = new Promise(function(resolve, reject) {
		var Model = mongoose.model(schemaName, customSchema);
		var instance = new Model(saveParams);
		
		db.save(req, instance)
		.then(function(result) {
			resolve(result);
		});
	});
	
	return promise;
}

exports.findOne = function(req, customSchema, schemaName, queryParams) {
	GLOBAL.log(schemaName + '.findOne', queryParams);
	
	var promise = new Promise(function(resolve, reject) {
		var Model = mongoose.model(schemaName, customSchema);
		var query = Model.findOne(queryParams);
		
		db.exec(req, query)
		.then(function(result) {
			resolve(result);
		})
	});
	
	return promise;
}

exports.findById = function(req, customSchema, schemaName, id) {
	GLOBAL.log(schemaName + '.findById', id);
	
	var promise = new Promise(function(resolve, reject) {
		var Model = mongoose.model(schemaName, customSchema);
		var query = Model.findById(id);
		
		db.exec(req, query).then(function(result) {
			resolve(result);
		})
	});
	
	return promise;
}