// NOT USED AT THE MOMENT







require("../schemas/userSchema");
var User = require('mongoose').model('User');
var db = require('../modules/db');
var eventPublisher = require('../modules/eventPublisher');

exports.create = function(req, query) {
	GLOBAL.log('User.create');
	// add the necessary fields
// 	query.type = 'user';
// 	query.created = Date.now();
	// create the user
	var user = new User(query);
	//save the user
	db.save(req, user, 'User.create');
}











exports.findOne = function(req, query, info) {
	GLOBAL.log('User.findOne', query);
	var query = User.findOne(query);
	db.exec(req, query, 'User.findOne' + (info && '.' + info || ''));
};

exports.findById = function(req, id, info) {
	GLOBAL.log('User.findById', id);
	var query = User.findById(id);
	db.exec(req, query, 'User.findById' + (info && '.' + info || ''));
};

exports.updatebyId = function(req, id, update) {
	GLOBAL.log('User.updatebyId', id);
	User.update({ _id: id }, update, { upsert: false }, function(error, result) {
		req.on('User.findById.success', function(data) {
			eventPublisher.publish(req, 'User.updatebyId.success', data);
		});
		self.findById(req, id);
	});
};

exports.findOneAndUpdate = function(req, query, update) {
	GLOBAL.log(__filename, 'User.findOneAndUpdate', query);
	var q = User.findOneAndUpdate(query, update);
	db.exec(req, q, 'User.findOneAndUpdate');
};

exports.update = function(req, query, update) {
	GLOBAL.log(__filename, 'User.update', query);
	User.update(query, update, { multi: true }, function(error, result) {
		if(!error) {
			req.on('User.find.success', function(data) {
				eventPublisher.publish(req, 'User.update.success', data);
			});

			req.on('User.find.error.notFound', function(data) {
				eventPublisher.publish(req, 'User.update.error.notFound', data);
			});
			self.find(req, query);	
		} else {
			eventPublisher.publish(req, 'User.update.error', error);
		}
	});
};

exports.add = function(req, user) {
	GLOBAL.log('User.add', user);

	user.save(function(error, result) {
		req.on('User.findById.success', function(data) {
			eventPublisher.publish(req, 'User.add.success', data);
		});
		self.findById(req, result._id);
	});
};

exports.findByIdAndRemove = function(req, id) {
	GLOBAL.log('User.findByIdAndRemove', id);
	var query = User.findByIdAndRemove(id);
	db.exec(req, query, 'User.findByIdAndRemove');
};

exports.find = function(req, query) {
	GLOBAL.log('User.find', query);
	var query = User.find(query);
	db.exec(req, query, 'User.find');
};

exports.addavatar = function(req, photo, id) {
	GLOBAL.log('User.addavatar', id);
	var model = this;

	req.on('User.updatebyId.success', function(data) {
		eventPublisher.publish(req, 'User.addavatar.success', data);
	});
	req.on('User.updatebyId.error', function(data) {
		eventPublisher.publish(req, 'User.addavatar.error', data);
	});
	req.on('User.updatebyId.error.notFound', function(data) {
		eventPublisher.publish(req, 'User.addavatar.error', data);
	});
	req.on('Photo.upload.error', function(data) {
		eventPublisher.publish(req, 'User.addavatar.error', data);
	});
	req.on('Photo.upload.success', function(data) {
		self.updatebyId( req, id,{
			avatar: {
				path: nconf.get('amazon').photoHostUrl + photo.name,
				originalTitle: photo.name || null,
				size: photo.size,
				type: photo.type.substring(photo.type.lastIndexOf("/") + 1),
				created: Math.round((new Date()).getTime() / 1000)
			}
		});
	});

	helper.loadPhoto(req, photo);
};