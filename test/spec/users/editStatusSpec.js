describe('/users/:id/editStatus Service', function() {

	it('should mark a member user as active when valid data are sent (admin token)(4.9.1)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				action: "active",
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'POST',
			url: '/v1/users/' + localStorage.getItem('memberId0') + '/editStatus'
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
			expect(response.data.status).toEqual('active');
		});
	});

	it('should mark a member user as ignored when valid data are sent (admin token)(4.9.2)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				action: "ignore",
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'POST',
			url: '/v1/users/' + localStorage.getItem('memberId1') + '/editStatus'
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
			expect(response.data.status).toEqual('ignore');
			
		});
	});

	describe('Parameter Validation', function() {
		it('should return 4901 error when id is invalid (4.9.3)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					action: "active",
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/1234/editStatus'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4901');
			});
		});

		it('should return 4902 error when action is empty (4.9.4)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/' + localStorage.getItem('memberId1') + '/editStatus'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4902');
			});
		});

		it('should return 4903 error when action is invalid (4.9.5)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					action: "xara",
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/' + localStorage.getItem('memberId1') + '/editStatus'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4903');
			});
		});

		it('should return 4904 error when user trying to update is not a member user (4.9.6)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					action: "active",
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/' + localStorage.getItem('clientId') + '/editStatus'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4904');
			});
		});
	});
});