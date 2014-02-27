var mongoose = require('mongoose');
var db = require('../modules/db');
var Promise = require('es6-promise').Promise;

/**
 * Same as the mongoose create, expect that it supports 1 document creation only
 */
exports.create = function(req, customSchema, schemaName, save) {
	GLOBAL.log(schemaName + '.create', save);
	
	return new Promise(function(resolve, reject) {
		var Model = mongoose.model(schemaName, customSchema);
		
		Model.create(save, function (error, result) {
			var finalResult = callback(req, error, result)
			GLOBAL.log(schemaName + '.create.success', finalResult);
			resolve(finalResult);
		});
	});
}

exports.findOne = function(req, customSchema, schemaName, query) {
	GLOBAL.log(schemaName + '.findOne', query);
	
	return new Promise(function(resolve, reject) {
		var Model = mongoose.model(schemaName, customSchema);
		
		Model.findOne(query, function (error, result) {
			var finalResult = callback(req, error, result)
			GLOBAL.log(schemaName + '.findOne.success', finalResult);
			resolve(finalResult);
		});
	});
}

exports.findById = function(req, customSchema, schemaName, id) {
	GLOBAL.log(schemaName + '.findById', id);
	
	return new Promise(function(resolve, reject) {
		var Model = mongoose.model(schemaName, customSchema);
		
		Model.findById(id, function (error, result) {
			var finalResult = callback(req, error, result)
			GLOBAL.log(schemaName + '.findById.success', finalResult);
			resolve(finalResult);
		});
	});
}

/**
 * Updates a document ignoring mongoose validations 
 * http://mongoosejs.com/docs/api.html#model_Model.update
 * Returns nothing
 */
exports.update = function(req, customSchema, schemaName, query, update) {
	GLOBAL.log(schemaName + '.update');
	
	return new Promise(function(resolve, reject) {
		var Model = mongoose.model(schemaName, customSchema);
		
		Model.update(query, update, function(err, numberAffected, rawResponse) {
			if (numberAffected === 0) {
				resolve('notFound');
			} else {
				resolve();
			}
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
}

exports.findOneAndUpdate = function(req, customSchema, schemaName, query, update, options) {
	GLOBAL.log(schemaName + '.findOneAndUpdate', query, update);
	debugger;
	
	return new Promise(function(resolve, reject) {
		var Model = mongoose.model(schemaName, customSchema);
		
		Model.findOneAndUpdate(query, update, options, function(error, result) {
			var finalResult = callback(req, error, result)
			GLOBAL.log(schemaName + '.findOneAndUpdate.success', finalResult);
			resolve(finalResult);
		});
	})
}

function callback(req, error, result) {
	if (error) {
		return error;
	} else if (!result) {
		return 'notFound';
	} else {
		// filter the result attributes to send only those that this userType can see
		var filters = result.getFilters();
		var userType = req.data.activeUser && req.data.activeUser.type || 'null';
		// for unknown reason, the log of result, exists in result._doc
		for (var attribute in result._doc) {
			if (result._doc.hasOwnProperty(attribute)) {
				if (
					!filters[attribute] // if this attribute is not defined in filters
					|| filters[attribute][0] !== 'null' // this attribute is not set as public
					&& filters[attribute].indexOf(userType) === -1 // this attribute is not available to this userType
					&& userType !== 'admin' // the user is not admin
				) {
					// dont return this attribute
					delete result._doc[attribute];
				}
			}
		}
		
		return result;
	}
}