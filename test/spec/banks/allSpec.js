describe('/banks Service', function() {

	it('should get all db banks when valid data are sent (6.1.1)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'GET',
			url: '/v1/banks'
		};
		request(config, callback);
		waitsFor(function() {
			if (callback.callCount > 0) {
				return true;
			}
		});
		runs(function() {
			var response = expect(callback).toBeSuccessful(callback);
			expect(response.data).toBeListOf("Bank");
		});
	});

	it('should get all banks filtered by the market id sent (6.1.2)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				market: localStorage.getItem('marketId1'),
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'GET',
			url: '/v1/banks'
		};
		request(config, callback);
		waitsFor(function() {
			if (callback.callCount > 0) {
				return true;
			}
		});
		runs(function() {
			expect(callback).toHaveBeenCalled();
			var response = callback.argsForCall[0][0];
			expect(response).toHaveTheseAttributes(basicStructure);
			expect(response).toHaveTheseMeta(successMeta);
			expect(response.data).toBeListOf("Bank");
		});
	});

	describe('Parameter Validation', function() {
		it('should return 6101 error when market id is invalid (6.1.3)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					secret: APIKEY,
					market: "1234",
					token: localStorage.getItem('adminToken')
				},
				type: 'GET',
				url: '/v1/banks'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '6101');
			});
		});
	});
});