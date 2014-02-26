describe('/measurements/add Service', function() {

	it('should add a measurement for a user when valid data are sent', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				data: {
					fire: 3
				},
				userId: localStorage.getItem('userId'),
				token: localStorage.getItem('token'),
				secret: APIKEY
			},
			type: 'POST',
			url: '/v1/measurements/add'
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
			
			it('should return userId.INVALID_ID when no userId is sent', function() {
				var callback = jasmine.createSpy();
				var config = {
					data: {
						data: {},
						token: localStorage.getItem('token'),
						secret: APIKEY
					},
					type: 'POST',
					url: '/v1/measurements/add'
				};
				request(config, callback);
				waitsFor(function() {
					if (callback.callCount > 0) {
						return true;
					}
				});
				runs(function() {
					var response = expect(callback).toBeErrorful(callback, 'userId.INVALID_ID');
				});
			});
			
			it('should return userId.INVALID_ID when a bad userId is sent', function() {
				var callback = jasmine.createSpy();
				var config = {
					data: {
						data: {},
						userId: '530c185ec74',
						token: localStorage.getItem('token'),
						secret: APIKEY
					},
					type: 'POST',
					url: '/v1/measurements/add'
				};
				request(config, callback);
				waitsFor(function() {
					if (callback.callCount > 0) {
						return true;
					}
				});
				runs(function() {
					var response = expect(callback).toBeErrorful(callback, 'userId.INVALID_ID');
				});
			});
			
			it('should return userId.INVALID_ID when a not existing userId is sent', function() {
				var callback = jasmine.createSpy();
				var config = {
					data: {
						data: {},
						userId: '530c185ec999999999999999',
						token: localStorage.getItem('token'),
						secret: APIKEY
					},
					type: 'POST',
					url: '/v1/measurements/add'
				};
				request(config, callback);
				waitsFor(function() {
					if (callback.callCount > 0) {
						return true;
					}
				});
				runs(function() {
					var response = expect(callback).toBeErrorful(callback, 'userId.NOT_EXIST');
				});
			});
		});
	});
	
	describe('Permissions test', function() {
		it('should return INVALID_SESSION error when no token is sent', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					data: {},
					secret: APIKEY
				},
				type: 'POST',
				url: '/v1/measurements/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, 'INVALID_SESSION');
			});
		});
		
		it('should return INVALID_SESSION error when invalid token is sent', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					data: {},
					token: 'dfsdfsdfsd',
					secret: APIKEY
				},
				type: 'POST',
				url: '/v1/measurements/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, 'INVALID_SESSION');
			});
		});
	});
});