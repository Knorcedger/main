describe('/users/:id/members Service', function() {

	it('should retrieve the current users members when valid data are sent (4.7.1)', function() {
		var callback = jasmine.createSpy();

		var config = {
			data: {
				token: localStorage.getItem('clientToken'),
				secret: APIKEY

			},
			type: 'GET',
			url: '/v1/users/self/members'
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
			expect(response.data).toBeListOf('User');
		});
	});

	it('should retrieve the users (:id) members when valid parameters are sent (4.7.2)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				token: localStorage.getItem('adminToken'),
				secret: APIKEY
			},
			type: 'GET',
			url: '/v1/users/' + localStorage.getItem('clientId') + '/members'
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
			expect(response.data).toBeListOf('User');
		});
	});

	describe('Parameter Validation', function() {
		it('should return 1006 error when the id parameter is invalid (4.7.3)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					token: localStorage.getItem('adminToken'),
					secret: APIKEY
				},
				type: 'GET',
				url: '/v1/users/' + '1234' + '/members'
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

		it('should return 4701 error when self is used as id parameter but the currect user is not a client user (4.7.4)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					token: localStorage.getItem('adminToken'),
					secret: APIKEY
				},
				type: 'GET',
				url: '/v1/users/self/members'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4701');
			});
		});

		it('should return 4702 error when id parameter corresponds to a non client type user (4.7.5)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					token: localStorage.getItem('adminToken'),
					secret: APIKEY
				},
				type: 'GET',
				url: '/v1/users/' + localStorage.getItem('userId') + '/members'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4702');
			});
		});

		it('should return 4703 error when no user by the id parameter exists in database (4.7.6)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					token: localStorage.getItem('adminToken'),
					secret: APIKEY
				},
				type: 'GET',
				url: '/v1/users/52a9c43a0cc534546c00000e/members'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4703');
			});
		});
	});
});