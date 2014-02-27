describe('/measurements/add Service', function() {

	it('should add a measurement for the currnt user when valid data are sent', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				data: {
					fire: 3
				},
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