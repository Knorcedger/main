describe('General Tests', function() {
	
	describe('wrong urls', function() {
		it('should send not found when v1 is not included in the url', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					secret: APIKEY
				},
				type: 'POST',
				url: '/authentications/register'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				expect(callback).toBeErrorful(callback, 'NOT_FOUND');
			});
		});
	
		it('should send not found when a misspelled url is called', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					secret: APIKEY
				},
				type: 'POST',
				url: '/v1/authentication/register'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				expect(callback).toBeErrorful(callback, 'NOT_FOUND');
			});
		});
	});
	
	describe('apikey checks', function() {
		it('should respond with no apikey error', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {},
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
				expect(callback).toBeErrorful(callback, 'NO_APIKEY');
			});
		});
	
		it('should respond with invalid apikey error', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					secret: '4321'
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
				expect(callback).toBeErrorful(callback, 'INVALID_APIKEY');
			});
		});
	});

});