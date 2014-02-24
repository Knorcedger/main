describe('/authentications/register Service', function() {

	it('should register a user when valid data are sent', function() {
		var username = 'user-' + Math.random().toString(36).substring(12);
		localStorage.setItem('username', username);
		var callback = jasmine.createSpy();
		var config = {
			data: {
				username: username,
				password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
				secret: APIKEY
			},
			type: 'POST',
			url: '/v1/authentications/register'
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
					url: '/v1/authentications/register'
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
					url: '/v1/authentications/register'
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
			
			it('should return ALREADY_EXISTS error when username exists in database', function() {
				var callback = jasmine.createSpy();
				var config = {
					data: {
						username: localStorage.getItem('username'),
						password: '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',
						secret: APIKEY
					},
					type: 'POST',
					url: '/v1/authentications/register'
				};
				request(config, callback);
				waitsFor(function() {
					if (callback.callCount > 0) {
						return true;
					}
				});
				runs(function() {
					var response = expect(callback).toBeErrorful(callback, 'username.ALREADY_EXISTS');
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
					url: '/v1/authentications/register'
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
					url: '/v1/authentications/register'
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
});