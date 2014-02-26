var mongoose = require('mongoose');
var db = require('../modules/db');
var Promise = require('es6-promise').Promise;

exports.add = function(req, customSchema, schemaName, saveParams) {
	GLOBAL.log(schemaName + '.add', saveParams);

	return new Promise(function(resolve, reject) {
		var Model = mongoose.model(schemaName, customSchema);
		var instance = new Model(saveParams);
		
		db.save(req, instance)
		.then(function(result) {
			resolve(result);
		});
	});
}

exports.findOne = function(req, customSchema, schemaName, queryParams) {
	GLOBAL.log(schemaName + '.findOne', queryParams);
	
	return new Promise(function(resolve, reject) {
		var Model = mongoose.model(schemaName, customSchema);
		var query = Model.findOne(queryParams);
		
		db.exec(req, query)
		.then(function(result) {
			resolve(result);
		});
	});
}

exports.findById = function(req, customSchema, schemaName, id) {
	GLOBAL.log(schemaName + '.findById', id);
	
	return new Promise(function(resolve, reject) {
		var Model = mongoose.model(schemaName, customSchema);
		var query = Model.findById(id);
		
		db.exec(req, query)
		.then(function(result) {
			resolve(result);
		});
	});
}

exports.update = function(req, customSchema, schemaName, instance, updateParams) {
	GLOBAL.log(schemaName + '.update', updateParams);
	
	var promise = new Promise(function(resolve, reject) {
		
		db.save(req, instance)
		.then(function(result) {
			resolve(result);
		});
		
		
// 		User.findOne({username: oldUsername}, function (err, user) {
// 			user.username = newUser.username;
// 			user.password = newUser.password;
// 			user.rights = newUser.rights;

// 			user.save(function (err) {
// 				if(err) {
// 					console.error('ERROR!');
// 				}
// 			});
// 		});
		
		
	});
	
	return promise;
}