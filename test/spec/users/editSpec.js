describe('/users/edit Service', function() {

	it('should edit a user when all data are sent and are valid (id = self)(4.4.1)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				firstname: 'xara1',
				lastname: 'skoura1',
				oldpassword: localStorage.getItem('password'),
				newpassword: localStorage.getItem('password'),
				email: localStorage.getItem('email'),
				type: 'editor',
				street: 'Salaminas',
				number: '10',
				city: 'Athens',
				zipCode: '17675',
				secret: APIKEY,
				token: localStorage.getItem('token')
			},
			type: 'POST',
			url: '/v1/users/self/edit'
		};
		request(config, callback);
		waitsFor(function() {
			if (callback.callCount > 0) {
				return true;
			}
		});
		runs(function() {
			var response = expect(callback).toBeSuccessful(callback);
			expect(response.data).toBeUser();
		});
	});

	it('should edit a client user (id !== self)  when all data are sent and are valid  (admin run service)(4.4.2)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				firstname: 'xara1',
				lastname: 'skoura1',
				oldpassword: localStorage.getItem('password'),
				newpassword: localStorage.getItem('password'),
				email: localStorage.getItem('clientEmail'),
				street: 'Salaminas',
				number: '10',
				city: 'Athens',
				zipCode: '17675',
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'POST',
			url: '/v1/users/' + localStorage.getItem('clientId') + '/edit'
		};
		request(config, callback);
		waitsFor(function() {
			if (callback.callCount > 0) {
				return true;
			}
		});
		runs(function() {
			var response = expect(callback).toBeSuccessful(callback);
			expect(response.data).toBeUser();
		});
	});

	it('should change the first name of a member user and add a market when valid data are sent (admin run service -- add market to user)(4.4.3)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				firstname: 'hello',
				markets: localStorage.getItem('marketId1'),
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'POST',
			url: '/v1/users/' + localStorage.getItem('memberId0') + '/edit'
		};
		request(config, callback);
		waitsFor(function() {
			if (callback.callCount > 0) {
				return true;
			}
		});
		runs(function() {
			var response = expect(callback).toBeSuccessful(callback);
			expect(response.data).toBeUser();
		});
	});

	it('should change the first name of a member user and not remove markets only firstname is sent (admin run service -- see if markets are still there)(4.4.4)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				firstname: 'hello',
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'POST',
			url: '/v1/users/' + localStorage.getItem('memberId0') + '/edit'
		};
		request(config, callback);
		waitsFor(function() {
			if (callback.callCount > 0) {
				return true;
			}
		});
		runs(function() {
			var response = expect(callback).toBeSuccessful(callback);
			expect(response.data).toBeUser();
		});
	});

	it('should remove markets form a member user when markets parameter is empty string  (admin run service -- see if markets are gone as it should)(4.4.5)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				firstname: 'xara1',
				lastname: 'skoura1',
				street: 'Salaminas',
				markets: '',
				number: '10',
				city: 'Athens',
				zipCode: '17675',
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'POST',
			url: '/v1/users/' + localStorage.getItem('memberId0') + '/edit'
		};
		request(config, callback);
		waitsFor(function() {
			if (callback.callCount > 0) {
				return true;
			}
		});
		runs(function() {
			var response = expect(callback).toBeSuccessful(callback);
			expect(response.data).toBeUser();
			expect(response.data.markets).toEqual([]);
		});
	});

	it('should edit a user (id === member user id) when all data are sent and are valid  (admin run service)(4.4.6)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				firstname: 'xara1',
				lastname: 'skoura1',
				oldpassword: localStorage.getItem('password'),
				newpassword: localStorage.getItem('password'),
				street: 'Salaminas',
				markets: localStorage.getItem('marketId1'),
				number: '10',
				city: 'Athens',
				zipCode: '17675',
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'POST',
			url: '/v1/users/' + localStorage.getItem('memberId0') + '/edit'
		};
		request(config, callback);
		waitsFor(function() {
			if (callback.callCount > 0) {
				return true;
			}
		});
		runs(function() {
			var response = expect(callback).toBeSuccessful(callback);
			expect(response.data).toBeUser();
			expect(response.data.markets).toBeNotEmptyArray();
		});
	});

	it('should edit a user when all data (except firstname) are sent and are valid  (4.4.7)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				lastname: 'skoura1',
				oldpassword: localStorage.getItem('password'),
				newpassword: localStorage.getItem('password'),
				email: 'editor@mail.com',
				type: 'editor',
				street: 'Salaminas',
				number: '10',
				city: 'Athens',
				zipCode: '17675',
				secret: APIKEY,
				token: localStorage.getItem('token')
			},
			type: 'POST',
			url: '/v1/users/self/edit'
		};
		request(config, callback);
		waitsFor(function() {
			if (callback.callCount > 0) {
				return true;
			}
		});
		runs(function() {
			expect(callback).toHaveBeenCalled();
			var response = callback.argsForCall[0][0];
			expect(response).toHaveTheseAttributes(basicStructure);
			expect(response).toHaveTheseMeta(successMeta);
			expect(response.data).toBeUser();
		});
	});
	
	it('should edit a user when all data (except lastname) are sent and are valid  (4.4.8)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				firstname: 'xara1',
				oldpassword: localStorage.getItem('password'),
				newpassword: localStorage.getItem('password'),
				email: 'editor@mail.com',
				type: 'editor',
				street: 'Salaminas',
				number: '10',
				city: 'Athens',
				zipCode: '17675',
				secret: APIKEY,
				token: localStorage.getItem('token')
			},
			type: 'POST',
			url: '/v1/users/self/edit'
		};
		request(config, callback);
		waitsFor(function() {
			if (callback.callCount > 0) {
				return true;
			}
		});
		runs(function() {
			expect(callback).toHaveBeenCalled();
			var response = callback.argsForCall[0][0];
			expect(response).toHaveTheseAttributes(basicStructure);
			expect(response).toHaveTheseMeta(successMeta);
			expect(response.data).toBeUser();
		});
	});

	it('should edit a user when all data (except password and repeatpassword) are sent and are valid  (4.4.9)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				firstname: 'xara1',
				lastname: 'skoura1',
				email: 'editor@mail.com',
				type: 'editor',
				street: 'Salaminas',
				number: '10',
				city: 'Athens',
				zipCode: '17675',
				secret: APIKEY,
				token: localStorage.getItem('token')
			},
			type: 'POST',
			url: '/v1/users/self/edit'
		};
		request(config, callback);
		waitsFor(function() {
			if (callback.callCount > 0) {
				return true;
			}
		});
		runs(function() {
			expect(callback).toHaveBeenCalled();
			var response = callback.argsForCall[0][0];
			expect(response).toHaveTheseAttributes(basicStructure);
			expect(response).toHaveTheseMeta(successMeta);
			expect(response.data).toBeUser();
		});
	});

	it('should edit a user when all data (except email) are sent and are valid  (4.4.10)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				firstname: 'xara1',
				lastname: 'skoura1',
				oldpassword: localStorage.getItem('password'),
				newpassword: localStorage.getItem('password'),
				type: 'editor',
				street: 'Salaminas',
				number: '10',
				city: 'Athens',
				zipCode: '17675',
				secret: APIKEY,
				token: localStorage.getItem('token')
			},
			type: 'POST',
			url: '/v1/users/self/edit'
		};
		request(config, callback);
		waitsFor(function() {
			if (callback.callCount > 0) {
				return true;
			}
		});
		runs(function() {
			expect(callback).toHaveBeenCalled();
			var response = callback.argsForCall[0][0];
			expect(response).toHaveTheseAttributes(basicStructure);
			expect(response).toHaveTheseMeta(successMeta);
			expect(response.data).toBeUser();
		});
	});

	it('should edit a user when all data (except type) are sent and are valid  (4.4.11)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				firstname: 'xara1',
				lastname: 'skoura1',
				oldpassword: localStorage.getItem('password'),
				newpassword: localStorage.getItem('password'),
				email: 'editor@mail.com',
				street: 'Salaminas',
				number: '10',
				city: 'Athens',
				zipCode: '17675',
				secret: APIKEY,
				token: localStorage.getItem('token')
			},
			type: 'POST',
			url: '/v1/users/self/edit'
		};
		request(config, callback);
		waitsFor(function() {
			if (callback.callCount > 0) {
				return true;
			}
		});
		runs(function() {
			expect(callback).toHaveBeenCalled();
			var response = callback.argsForCall[0][0];
			expect(response).toHaveTheseAttributes(basicStructure);
			expect(response).toHaveTheseMeta(successMeta);
			expect(response.data).toBeUser();
		});
	});

	describe('Parameter Validation', function() {
		it('should return 4401 error when firstname is invalid (4.4.12)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: {},
					lastname: 'skoura',
					oldpassword: localStorage.getItem('password'),
					newpassword: localStorage.getItem('password'),
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'editor',
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('token')
				},
				type: 'POST',
				url: '/v1/users/self/edit'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4401');
			});
		});

		it('should return 4402 error when lastname is invalid (4.4.13)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: '!@#$',
					oldpassword: localStorage.getItem('password'),
					newpassword: localStorage.getItem('password'),
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'editor',
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('token')
				},
				type: 'POST',
				url: '/v1/users/self/edit'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4402');
			});
		});

		it('should return 4403 error when email is invalid (4.4.14)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: '',
					oldpassword: localStorage.getItem('password'),
					newpassword: localStorage.getItem('password'),
					email: {},
					type: 'editor',
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('token')
				},
				type: 'POST',
				url: '/v1/users/self/edit'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4403');
			});
		});

		it('should return 4404 error when type is invalid (4.4.15)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					oldpassword: localStorage.getItem('password'),
					newpassword: localStorage.getItem('password'),
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: {},
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('token')
				},
				type: 'POST',
				url: '/v1/users/self/edit'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4404');
			});
		});

		it('should return 4405 error when password is invalid (4.4.16)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					oldpassword: {},
					newpassword: localStorage.getItem('password'),
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'editor',
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('token')
				},
				type: 'POST',
				url: '/v1/users/self/edit'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4405');
			});
		});

		it('should return 4406 error when password is less than 64 chars (4.4.17)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					oldpassword: '1234',
					newpassword: localStorage.getItem('password'),
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'editor',
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('token')
				},
				type: 'POST',
				url: '/v1/users/self/edit'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4406');
			});
		});

		it('should return 4407 error when repeat password is invalid (4.4.18)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					oldpassword: localStorage.getItem('password'),
					newpassword: {},
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'editor',
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('token')
				},
				type: 'POST',
				url: '/v1/users/self/edit'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4407');
			});
		});

		it('should return 4408 error when repeat password is less than 64 chars (4.4.179', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					oldpassword: localStorage.getItem('password'),
					newpassword: '1234',
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'editor',
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('token')
				},
				type: 'POST',
				url: '/v1/users/self/edit'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4408');
			});
		});

		// TODO: change password tests
		
		it('should return 4410 error when street is invalid (4.4.20)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					oldpassword: localStorage.getItem('password'),
					newrepeatpassword: localStorage.getItem('password'),
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'editor',
					street: {},
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('token')
				},
				type: 'POST',
				url: '/v1/users/self/edit'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4410');
			});
		});

		it('should return 4411 error when number is invalid (4.4.21)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					oldpassword: localStorage.getItem('password'),
					newrepeatpassword: localStorage.getItem('password'),
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'editor',
					street: 'Salaminas',
					number: {},
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('token')
				},
				type: 'POST',
				url: '/v1/users/self/edit'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4411');
			});
		});

		it('should return 4412 error when city is invalid (4.4.22)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					oldpassword: localStorage.getItem('password'),
					newrepeatpassword: localStorage.getItem('password'),
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'editor',
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: {},
					secret: APIKEY,
					token: localStorage.getItem('token')
				},
				type: 'POST',
				url: '/v1/users/self/edit'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4412');
			});
		});

		it('should return 4413 error when city is invalid (4.4.23)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					oldpassword: localStorage.getItem('password'),
					newrepeatpassword: localStorage.getItem('password'),
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'editor',
					street: 'Salaminas',
					number: '10',
					city: {},
					zipCode: '1234',
					secret: APIKEY,
					token: localStorage.getItem('token')
				},
				type: 'POST',
				url: '/v1/users/self/edit'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4413');
			});
		});
	});
});