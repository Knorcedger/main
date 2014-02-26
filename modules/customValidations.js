var validator = require('validator');
var _ = require('lodash');

module.exports = function() {
	validator.extend('isId', function (value) {
		var checkForHexRegExp = new RegExp("^[0-9a-fA-F]{24}$");
		return checkForHexRegExp.test(value);
	});
}