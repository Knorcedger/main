describe('/users/:id/measurements Service', function() {

	it('should get the measurements for a user when valid user id is sent', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				token: localStorage.getItem('token'),
				secret: APIKEY
			},
			type: 'GET',
			url: '/v1/users/self/measurements'
		};
		request(config, callback);
		waitsFor(function() {
			if (callback.callCount > 0) {
				return true;
			}
		});
		runs(function() {
			var response = expect(callback).toBeSuccessful(callback);
			expect(response.data).toBeMeasurement();
		});
	});

	describe('Parameter Validations', function() {
		describe('UserId Validations', function() {
			
			it('should return NOT_FOUND when no userId is sent', function() {
				var callback = jasmine.createSpy();
				var config = {
					data: {
						token: localStorage.getItem('token'),
						secret: APIKEY
					},
					type: 'GET',
					url: '/v1/users//measurements'
				};
				request(config, callback);
				waitsFor(function() {
					if (callback.callCount > 0) {
						return true;
					}
				});
				runs(function() {
					var response = expect(callback).toBeErrorful(callback, 'NOT_FOUND');
				});
			});
		});
	});
	
	describe('Permissions test', function() {
		it('should return NO_PERMISSION when userId is sent is not "self"', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					token: localStorage.getItem('token'),
					secret: APIKEY
				},
				type: 'GET',
				url: '/v1/users/1234/measurements'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, 'NO_PERMISSION');
			});
		});
		
		it('should return NO_PERMISSION when userId is valid (needs "self")', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					token: localStorage.getItem('token'),
					secret: APIKEY
				},
				type: 'GET',
				url: '/v1/users/' + localStorage.getItem('userId') + '/measurements'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, 'NO_PERMISSION');
			});
		});
	});
});