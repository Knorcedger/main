describe('/banks/add Service', function() {

	it('should create a bank when valid data are sent (6.3.1)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				title: "ING" + Math.floor((Math.random()*10000)+1).toString(),
				description: "The biggest smallest bank",
				market: localStorage.getItem('marketId1'),
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'POST',
			url: '/v1/banks/add'
		}
		request(config, callback);
		waitsFor(function() {
			if (callback.callCount > 0) {
				return true;
			}
		});
		runs(function() {
			var response = expect(callback).toBeSuccessful(callback);
			expect(response.data).toBeBank();
			localStorage.setItem('bankId', response.data._id);
		});
	});
	describe('Parameter Validation', function() {
		it('should return 6301 error when title is empty (6.3.2)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					title: "",
					description: "This bank is small and big",
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/banks/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '6301');
			});
		});

		it('should return 6302 error when title is invalid (6.3.2)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					title: {},
					market: localStorage.getItem('marketId1'),
					description: "This bank is small and big",
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/banks/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '6302');
			});
		});

		it('should return 6303 error when market is Empty (6.3.4)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					title: 'Hello',
					description: "This bank is small and big",
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/banks/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '6303');
			});
		});

		it('should return 6304 error when market is Empty (6.3.5)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					title: 'Hello',
					market: '1234',
					description: "This bank is small and big",
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/banks/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '6304');
			});
		});
	});
});