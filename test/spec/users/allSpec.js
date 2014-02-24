describe('/users Service', function() {

	it('should get all users when valid data are sent (4.1.2)', function() {
		var callback = jasmine.createSpy();

		var config = {
			data: {
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'GET',
			url: '/v1/users'
		};
		request(config, callback);
		waitsFor(function() {
			if (callback.callCount > 0) {
				return true;
			}
		});
		runs(function() {
			var response = expect(callback).toBeSuccessful(callback);
			expect(response.data).toBeListOf("User");
		});
	});

	it('should get all users when valid parameters are sent (4.1.2)', function() {
		var callback = jasmine.createSpy();

		var config = {
			data: {
				type: 'client',
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'GET',
			url: '/v1/users'
		};
		request(config, callback);
		waitsFor(function() {
			if (callback.callCount > 0) {
				return true;
			}
		});
		runs(function() {
			var response = expect(callback).toBeSuccessful(callback);
			expect(response.data).toBeListOf('User');
		});
	});

	describe('Parameter Validation', function() {
		it('should return 4101 error when type parameter is invalid (4.1.3)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					type: '{}',
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'GET',
				url: '/v1/users'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4101');
			});
		});
	});
});