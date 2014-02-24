describe('/users/:id Service', function() {

	it('should retrieve the current user when valid data are sent (4.2.1)', function() {
		var callback = jasmine.createSpy();

		var config = {
			data: {
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'GET',
			url: '/v1/users/' + 'self'
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

	it('should retrieve the user (:id) when valid parameters are sent (4.2.2)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'GET',
			url: '/v1/users/' + localStorage.getItem('userId')
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
		it('should return 1006 error when id parameter is invalid (4.2.3)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'GET',
				url: '/v1/users/' + '1234'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '1006');
			});
		});
	});
});