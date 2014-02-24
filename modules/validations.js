var Validator = require('validator').Validator,
	_ = require('lodash'),
	mongoose = require("mongoose"),
	ObjectId = mongoose.Types.ObjectId,
	helper = require("./helper"),
	nconf = require('nconf');

Validator.prototype.isId = function(str) {
	if (this.str.length !== 24) {
		this.error(this.errorDictionary.isId);
	}
	try {
		ObjectId.createFromHexString(this.str);
	} catch(ex) {
		this.error(this.errorDictionary.isId);
	}
	return this;
};

Validator.prototype.isObject = function(str) {
	if (!_.isObject(JSON.parse(this.str))) {
		this.error(this.errorDictionary.isObject);
	}
	return this;
};

Validator.prototype.isIdArray = function(str) {
	try {
		var val = this.str.split(',');
		if(val.length && _.isArray(val)){
			
			for(var i = 0, length = val.length; i < length; i++) {
				ObjectId.createFromHexString(val[i]);
			}
		}
	} catch(ex) {
		this.error(this.errorDictionary.isIdArray);
	}
};

Validator.prototype.isString = function(str) {
	if (!_.isString(this.str)) {
		this.error(this.errorDictionary.isString);
	}
	return this;
};

Validator.prototype.match = function(type) {
	var str = this.str;
	var result = _.filter(_.keys(nconf.get(type)), function(item) {
		return item === str;
	});

	if(result.length === 0) {
		this.error(this.errorDictionary.match);
	}
	return this;
};