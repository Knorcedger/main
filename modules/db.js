var mongoose = require('mongoose');
var eventPublisher = require('./eventPublisher');
var Promise = require('es6-promise').Promise;

// initializes the db connection
exports.init = function(app, mongoUrl) {
	mongoose.connect(mongoUrl);
	var db = mongoose.connection;
	db.on('error', console.error.bind(console, 'connection error:'));
	db.once('open', function callback () {
		GLOBAL.log('db.connect.success');
	});
};

// executes a query
exports.exec = function(req, query, schema) {
	GLOBAL.log('db.exec');
// 	var Model = require('mongoose').model(schema);

	query.select('-__v');
	
// 	if (Model.populations) {
// 		for (var i = 0, length = Model.populations.length; i < length; i++) {
// 			query.populate(Model.populations[i].attribute, Model.populations[i].fields);
// 		}
// 	}

	var promise = new Promise(function(resolve, reject) {
		query.exec(function (error, result) {
			resolve(callback(req, error, result));
		});
	});
	
	return promise;
};

// saves a Model instance
exports.save = function(req, instance) {
	GLOBAL.log('db.save');

	var promise = new Promise(function(resolve, reject) {
		instance.save(function (error, result) {
			resolve(callback(req, error, result));
		});
	});
	
	return promise;
}

// gets the correct model based on the passed event
// function getModel(event) {
// 	var temp = event.split('.');
// 	require("../schemas/" + temp[0].toLowerCase() + "Schema");
// 	var Model = require('mongoose').model(temp[0]);
// 	return Model;
// }

// the callback for both query and save methods that fires the appropriate event
function callback(req, error, result) {
	if (error) {
// 		eventPublisher.publish(req, event + '.error', error);
		GLOBAL.log('db.result', error);
		return error;
	} else if (!result) {
// 		eventPublisher.publish(req, event + '.error.notFound');
		GLOBAL.log('db.result', 'notFound');
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
		
// 		eventPublisher.publish(req, event + '.success', result);
		GLOBAL.log('db.result', result);
		return result;
	}
}