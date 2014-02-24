exports.publish = function(req, eventName, data, info) {
	GLOBAL.log(eventName, data);
	if (eventName.indexOf('.error') !== -1) {
		req.emit('req.error', eventName);
	}

	req.emit(eventName, data);
};