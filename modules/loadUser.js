require("../schemas/userSchema");
var User = require('mongoose').model('User');
require("../schemas/sessionSchema");
var Session = require('mongoose').model('Session');
var eventPublisher = require('../modules/eventPublisher');
var errorHandler = require('./errorHandler');

module.exports = function(req) {
	var session = new Session();
	var user = new User();

	req.on("User.findById.success", function(data) {
		// user that corresponds to the session is retrieved so we load the active user and move to the next middleware
		setUser(data);
	});

	req.on("User.findById.error.notFound", function(data) {
		// user that corresponds to the session is not found	
		eventPublisher.publish(req, 'request.error', 1004);
	});

	// session found, get the user
	req.on("Session.findById.success", function(data) {
		user.findById(req, data.userId, 'authenticator');
	});
	
	// session not found
	req.on("Session.findById.error.notFound", function(data) {
		errorHandler.error(req, res, 'UNKNOWN_SESSION');
	});

	if (req.data.requestData.token) {
		session.findById(req, req.data.requestData.token);
	} else {
		setUser('null');
	}

	function setUser(user) {
		req.data.activeUser = user;
		eventPublisher.publish(req, 'loadUser.success', user);
	}
};