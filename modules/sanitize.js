var sanitize = require('validator').sanitize;

module.exports = function(model) {
	return function(req, res, next) {
		var inputField;
		var data = req.data.requestData;
		for(var i = 0, length = model.inputFields.length; i < length; i++) {
			inputField = data[model.inputFields[i]];
			inputField = inputField && sanitize(inputField).trim();
		}
		next();
	};
};