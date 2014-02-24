describe('/markets/:id/edit Service', function() {
	it('should edit a market when valid data are sent (5.5.1)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				title: "Latvia" + Math.floor((Math.random()*10000)+1).toString(),
				description: "The market of Latvia is very small",
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'POST',
			url: '/v1/markets/' + localStorage.getItem('marketId1') + '/edit'
		};
		request(config, callback);
		waitsFor(function() {
			if (callback.callCount > 0) {
				return true;
			}
		});
		runs(function() {
			var response = expect(callback).toBeSuccessful(callback);
			expect(response.data).toBeMarket();
		});
	});

	describe('Parameter Validation', function() {
		
		it('should return 5501 error when title is invalid (5.5.2)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					title: {},
					description: "The market of Latvia is very small",
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/markets/' + localStorage.getItem('marketId') + '/edit'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '5501');
			});
		});

		it('should edit a market when valid data are sent (5.5.3)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					title: "Latvia" + Math.floor((Math.random()*10000)+1).toString(),
					description: "The market of Latvia is very small",
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/markets/' + localStorage.getItem('marketId') + '/edit'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '5502');
			});
		});
	});
});