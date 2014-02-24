describe('/banks/edit Service', function() {

	it('should edit a bank when valid data are sent (6.4.1)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				title: "ING" + Math.floor((Math.random()*10000)+1).toString() + 's',
				description: "The biggest smallest bank",
				market: localStorage.getItem('marketId1'),
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'POST',
			url: '/v1/banks/'+ localStorage.getItem('bankId') + '/edit'
		};
		request(config, callback);
		waitsFor(function() {
			if (callback.callCount > 0) {
				return true;
			}
		});
		runs(function() {
			var response = expect(callback).toBeSuccessful(callback);
			expect(response.data).toBeBank();
		});
	});

	// TODO: create test to check if markets are deleted when market: '' is sent
	describe('Parameter Validation', function() {
		it('should return 6401 error when title is invalid (6.4.2)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					title: "{}",
					description: "The biggest smallest bank",
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/banks/'+ localStorage.getItem('bankId') + '/edit'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '6401');
			});
		});

		it('should return 6402 error when market is invalid (6.4.3)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					title: "Hello",
					market: '1234',
					description: "The biggest smallest bank",
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/banks/'+ localStorage.getItem('bankId') + '/edit'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '6402');
			});
		});

		it('should return 6404 error when market id is valid but does not exist in db (6.4.4)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					title: "Hello",
					market: localStorage.getItem('bankId'),
					description: "The biggest smallest bank",
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/banks/'+ localStorage.getItem('bankId') + '/edit'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '6404');
			});
		});

		it('should return 1006 error when bank id parameter  is invalid (6.4.5)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					title: "Hello",
					market: '1234',
					description: "The biggest smallest bank",
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/banks/0/edit'
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

		it('should return 6404 error when bank id parameter is valid id but does not exist in db (6.4.6)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					title: "Hello",
					market: localStorage.getItem('MarktId1'),
					description: "The biggest smallest bank",
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/banks/' + localStorage.getItem('adminToken') + '/edit'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '6404');
			});
		});
	});
});