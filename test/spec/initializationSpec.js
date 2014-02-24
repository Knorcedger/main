describe('Initialization', function() {

	it('should reset the DB (1.0.0)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				secret: APIKEY
			},
			type: 'Get',
			url: '/v1/services/resetDb'
		};
		request(config, callback);
		waitsFor(function() {
			if (callback.callCount > 0) {
				return true;
			}
		});
		runs(function() {
			var response = expect(callback).toBeSuccessful(callback);
			expect(response.data).toBeNotEmptyString();
		});
	});

	it('should login as admin to use his token at later tests (1.0.1)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				username: 'admin@mail.com',
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
			localStorage.setItem('adminToken', response.data.token);
		});
	});
});