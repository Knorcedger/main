var mongoose = require('mongoose');
var nconf = require('nconf');
var db = require('../modules/db');
var Promise = require('es6-promise').Promise;

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
	GLOBAL.log('User.add');

	var promise = new Promise(function(resolve, reject) {
		var User = mongoose.model('User', userSchema);
		var user = new User(saveParams);
		
		db.save(req, user)
		.then(function(result) {
			resolve(result);
		});
	});
	
	return promise;
}

userSchema.methods.findOne = function(req, queryParams) {
	GLOBAL.log('User.findOne', queryParams);
	
	var promise = new Promise(function(resolve, reject) {
		var User = mongoose.model('User', userSchema);
		var query = User.findOne(queryParams);
		
		db.exec(req, query)
		.then(function(result) {
			resolve(result);
		})
	});
	
	return promise;
}

userSchema.methods.findById = function(req, id) {
	GLOBAL.log('User.findById', id);
	
	var promise = new Promise(function(resolve, reject) {
		var User = mongoose.model('User', userSchema);
		var query = User.findById(id);
		
		db.exec(req, query).then(function(result) {
			resolve(result);
		})
	});
	
	return promise;
}

mongoose.model('User', userSchema);