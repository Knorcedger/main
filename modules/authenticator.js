/*
Retrieves the session declared by the token parameter. Then retrieves the user by the userId
written on session document and attaches it to the req.data.parsedData
 */
var mongoose = require( 'mongoose' );
// var User = require('../models/User');
// var Session = require('../models/Session');
var eventPublisher = require('../modules/eventPublisher');

exports.authenticate = function(req, res, next) {

	req.on("User.findById.authenticator.success", function(data) {
		// user that corresponds to the session is retrieved so we load the active user and move to the next middleware
		req.data.activeUser = data;
		next();
	});

	req.on("User.findById.error.notFound", function(data) {
		// user that corresponds to the session is not found		
		req.emit('request.error', 1004);
	});

	req.on("Session.findById.success", function(data) {
		//session is retrieved or not  - if retrieved I make a query to get the user
		User.findById(req, data.userId, 'authenticator');
	});

	req.on("Session.findById.error.notFound", function(data) {
		// if session is not found then error is returned
		req.emit('request.error', 1003);
	});

	Session.findById(req, req.data.requestData.token);
};