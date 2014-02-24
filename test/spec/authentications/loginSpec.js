describe('/authentications/login Service', function() {

	it('should login a user when valid data are sent', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				username: localStorage.getItem('username'),
				password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
				secret: APIKEY
			},
			type: 'POST',
			url: '/v1/authentications/login'
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
			expect(response.data.token).toBeId();
			localStorage.setItem('token', response.data.token);
		});
	});

	describe('Parameter Validations', function() {
		describe('Username Validations', function() {
			
			it('should return INVALID_LENGTH error when username is empty', function() {
				var callback = jasmine.createSpy();
				var config = {
					data: {
						username: '',
						password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
						secret: APIKEY
					},
					type: 'POST',
					url: '/v1/authentications/login'
				};
				request(config, callback);
				waitsFor(function() {
					if (callback.callCount > 0) {
						return true;
					}
				});
				runs(function() {
					var response = expect(callback).toBeErrorful(callback, 'username.INVALID_LENGTH');
				});
			});

			it('should return INVALID_CHARACTER error when username is has "', function() {
				var callback = jasmine.createSpy();
				var config = {
					data: {
						username: 'sdsd"fsd',
						password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
						secret: APIKEY
					},
					type: 'POST',
					url: '/v1/authentications/login'
				};
				request(config, callback);
				waitsFor(function() {
					if (callback.callCount > 0) {
						return true;
					}
				});
				runs(function() {
					var response = expect(callback).toBeErrorful(callback, 'username.INVALID_CHARACTER');
				});
			});
		});
		
		describe('Password Validations', function() {
			
			it('should return INVALID_LENGTH error when password is empty', function() {
				var callback = jasmine.createSpy();
				var config = {
					data: {
						username: 'test',
						password: '',
						secret: APIKEY
					},
					type: 'POST',
					url: '/v1/authentications/login'
				};
				request(config, callback);
				waitsFor(function() {
					if (callback.callCount > 0) {
						return true;
					}
				});
				runs(function() {
					var response = expect(callback).toBeErrorful(callback, 'password.INVALID_LENGTH');
				});
			});

			it('should return INVALID_CHARACTER error when password length is 10', function() {
				var callback = jasmine.createSpy();
				var config = {
					data: {
						username: 'test',
						password: '03ac674216',
						secret: APIKEY
					},
					type: 'POST',
					url: '/v1/authentications/login'
				};
				request(config, callback);
				waitsFor(function() {
					if (callback.callCount > 0) {
						return true;
					}
				});
				runs(function() {
					var response = expect(callback).toBeErrorful(callback, 'password.INVALID_LENGTH');
				});
			});
		});
	});
	
	describe('More tests', function() {
			
		it('should return WRONG_DATA error when username does not exist', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					username: 'kolokithoopoulos',
					password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
					secret: APIKEY
				},
				type: 'POST',
				url: '/v1/authentications/login'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, 'WRONG_DATA');
			});
		});
		
		it('should return WRONG_DATA error when the password is wrong', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					username: localStorage.getItem('username'),
					password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f!',
					secret: APIKEY
				},
				type: 'POST',
				url: '/v1/authentications/login'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, 'WRONG_DATA');
			});
		});
	});
});