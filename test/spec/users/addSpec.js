var company;
describe('/users/add Service', function() {

	it('should create a member user when valid data are sent (4.3.1)', function() {
		var callback = jasmine.createSpy();
		var email = 'member@mail.com';

		localStorage.setItem('email', email);
		localStorage.setItem('password', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4');
		var config = {
			data: {
				firstname: 'xara',
				lastname: 'skoura',
				password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
				repeatpassword: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
				email: localStorage.getItem('email'),
				type: 'member',
				street: 'Salaminas',
				number: '10',
				city: 'Athens',
				zipCode: '17675',
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'POST',
			url: '/v1/users/add'
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

	it('should create an editor user when valid data are sent (4.3.1)', function() {
		var callback = jasmine.createSpy();
		var email = 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com';

		localStorage.setItem('email', email);
		localStorage.setItem('password', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4');
		var config = {
			data: {
				firstname: 'xara',
				lastname: 'skoura',
				password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
				repeatpassword: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
				email: localStorage.getItem('email'),
				type: 'editor',
				street: 'Salaminas',
				number: '10',
				city: 'Athens',
				zipCode: '17675',
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'POST',
			url: '/v1/users/add'
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

	it('should create a second editor user in order to delete afterwards (4.3.2)', function() {
		var callback = jasmine.createSpy();

		var config = {
			data: {
				firstname: 'xara',
				lastname: 'skoura',
				password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
				repeatpassword: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
				email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
				type: 'editor',
				street: 'Salaminas',
				number: '10',
				city: 'Athens',
				zipCode: '17675',
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'POST',
			url: '/v1/users/add'
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
			localStorage.setItem('toDeleteId', response.data._id);
		});
	});

	it('should create an account manager user when valid data are sent (4.3.3)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				firstname: 'account manager1',
				lastname: 'account manager1 lastname',
				password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
				repeatpassword: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
				email: Math.floor((Math.random()*10000)+1).toString() + localStorage.getItem('email'),
				type: 'accountManager',
				street: 'Salaminas',
				number: '10',
				city: 'Athens',
				zipCode: '17675',
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'POST',
			url: '/v1/users/add'
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

	it('should create a client user when valid data are sent (4.3.4)', function() {
		var callback = jasmine.createSpy();
		var email = 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com';
		company = "company" + Math.floor((Math.random()*10000)+1).toString();

		localStorage.setItem('clientEmail', email);
		var config = {
			data: {
				firstname: 'xara',
				lastname: 'skoura',
				password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
				repeatpassword: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
				email: email,
				markets: [localStorage.getItem('marketId1')],
				company: company,
				type: 'client',
				street: 'Salaminas',
				number: '10',
				city: 'Athens',
				zipCode: '17675',
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'POST',
			url: '/v1/users/add'
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
			localStorage.setItem('clientId', response.data._id);
			localStorage.setItem('companyId', response.data._id);
		});
	});

	describe('Parameter Validation', function() {

		it('should return 4301 error when email is empty (4.3.5)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					repeatpassword: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					email: '',
					type: 'editor',
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4301');
			});
		});

		it('should return 4302 error when email is invalid (4.3.6)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					repeatpassword: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					email: '1234',
					type: 'editor',
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4302');
			});
		});

		it('should return 4303 error when password is empty (4.3.7)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					password: '',
					repeatpassword: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'editor',
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4303');
			});
		});

		it('should return 4304 error when password is invalid (4.3.8)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					password: {},
					repeatpassword: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'editor',
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4304');
			});
		});

		it('should return 4305 error when password is less than 64 chars (4.3.9)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					password: '1234',
					repeatpassword: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'editor',
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4305');
			});
		});

		it('should return 4306 error when repeat password is empty (4.3.10)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					repeatpassword: '',
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'editor',
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4306');
			});
		});

		it('should return 4307 error when repeat password is invalid (4.3.11)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					repeatpassword: {},
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'editor',
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4307');
			});
		});

		it('should return 4308 error when repeat password is less than 64 chars (4.3.12)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					repeatpassword: '1234',
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'editor',
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4308');
			});
		});

		it('should return 4309 error when password is different than repeat password (4.3.13)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					repeatpassword: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f6',
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'editor',
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4309');
			});
		});

		it('should return 4310 error when type is empty (4.3.14)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					repeatpassword: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: '',
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4310');
			});
		});

		it('should return 4311 error when type is invalid (4.3.15)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					repeatpassword: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: {},
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4311');
			});
		});

		it('should return 4311 error when type is invalid (4.3.16)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					repeatpassword: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'xara',
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4311');
			});
		});

		it('should return 4312 error when type is client and company is empty (4.3.17)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					repeatpassword: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'client',
					company: '',
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4312');
			});
		});

		it('should return 4313 error when type is client and company is invalid (4.3.18)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					repeatpassword: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'client',
					company: {},
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4313');
			});
		});

		it('should return 4314 error when type is client and markets parameter is empty (4.3.19)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					repeatpassword: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'client',
					company: '1234',
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4314');
			});
		});

		it('should return 4315 error when type is client and markets parameter is invalid (4.3.20)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					repeatpassword: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'client',
					company: '1234',
					markets: 1234,
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4315');
			});
		});

		it('should return 4316 error when firstname is empty (4.3.21)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: '',
					lastname: 'skoura',
					password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					repeatpassword: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'editor',
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4316');
			});
		});

		it('should return 4317 error when firstname is invalid (4.3.22)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: {},
					lastname: 'skoura',
					password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					repeatpassword: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'editor',
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4317');
			});
		});

		it('should return 4318 error when lastname is empty (4.3.23)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: '',
					password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					repeatpassword: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'editor',
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4318');
			});
		});

		it('should return 4319 error when lastname is invalid (4.3.24)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: {},
					password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					repeatpassword: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'editor',
					street: 'Salaminas',
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4319');
			});
		});

		it('should return 4320 error when street is invalid (4.3.25)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					repeatpassword: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'editor',
					street: {},
					number: '10',
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4320');
			});
		});

		it('should return 4321 error when number is invalid (4.3.26)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					repeatpassword: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'editor',
					street: 'Salaminas',
					number: {},
					city: 'Athens',
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4321');
			});
		});

		it('should return 4322 error when zipCode is invalid (4.3.27)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					repeatpassword: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'editor',
					street: 'Salaminas',
					number: '1',
					city: 'Athens',
					zipCode: {},
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4322');
			});
		});

		it('should return 4323 error when city is invalid (4.3.28)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					firstname: 'xara',
					lastname: 'skoura',
					password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					repeatpassword: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'editor',
					street: 'Salaminas',
					number: '1',
					city: {},
					zipCode: '17675',
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4323');
			});
		});

		it('should return 4324 error when city is invalid (4.3.29)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					repeatpassword: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					email: 'user' + Math.floor((Math.random()*10000)+1).toString() + '@mail.com',
					type: 'client',
					street: 'Salaminas',
					company: company,
					number: '1',
					city: 'Hello',
					zipCode: '17675',
					markets: [localStorage.getItem('marketId1')],
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4324');
			});
		});
	});
});