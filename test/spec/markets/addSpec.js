describe('/markets/add Service', function() {
	var counter = 0;
	for( var i = 0; i < 5; i++) {
		it('should create a market when valid data are sent (5.1.1)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					title: "Latvia" + Math.floor((Math.random()*10000)+1).toString(),
					description: "The market of Latvia is very small",
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/markets/add'
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
				localStorage.setItem('marketId' + counter, response.data._id);
				counter++;
			});
		});
	}

	describe('Parameter Validation', function() {
		it('should return 5101 error when title is empty (5.1.2)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					title: "",
					description: "The market of Latvia is very very small",
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/markets/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '5101');
			});
		});

		it('should return 5102 error when title is invalid (5.1.3)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					title: {},
					description: "The market of Latvia is very small",
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/markets/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '5102');
			});
		});
	});
});