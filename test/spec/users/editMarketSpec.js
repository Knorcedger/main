describe('/users/editMarket Service', function() {

	it('should add a market to a client user when valid data are sent (admin token)(4.8.1)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				action: "add",
				market: localStorage.getItem('marketId3'),
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'POST',
			url: '/v1/users/' + localStorage.getItem('clientId') + '/editMarket'
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
			// TODO: check for the localStorage.getItem('marketId3') in response.data markets
		});
	});

	it('should add the market previously added to client to a member of the same company (admin run service)(4.4.3)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				firstname: 'Hello',
				markets: localStorage.getItem('marketId1') + "," + localStorage.getItem('marketId3'),
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'POST',
			url: '/v1/users/' + localStorage.getItem('memberId0') + '/edit'
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

	it('should remove a market from a client user when valid data are sent (admin token)(4.8.2)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				action: "remove",
				market: localStorage.getItem('marketId3'),
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'POST',
			url: '/v1/users/' + localStorage.getItem('clientId') + '/editMarket'
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
			// TODO: check for absense of the localStorage.getItem('marketId3') in response.data markets
		});
	});

	describe('Parameter Validation', function() {
		it('should return 1006 error when id is invalid (4.8.3)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					action: "add",
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/1234/editMarket'
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

		it('should return 4802 error when action is empty (4.8.4)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					market: localStorage.getItem('marketId3'),
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/' + localStorage.getItem('clientId') + '/editMarket'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4802');
			});
		});

		it('should return 4803 error when action is invalid (4.8.5)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					action: "xara",
					market: localStorage.getItem('marketId3'),
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/' + localStorage.getItem('memberId1') + '/editMarket'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4803');
			});
		});

		it('should return 4804 error when market parameter is empty (4.8.6)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					action: "add",
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/' + localStorage.getItem('clientId') + '/editMarket'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4804');
			});
		});

		it('should return 4805 error when market parameter is invalid (4.8.7)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					action: "add",
					market: '1234',
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/users/' + localStorage.getItem('clientId') + '/editMarket'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '4805');
			});
		});
	});
});