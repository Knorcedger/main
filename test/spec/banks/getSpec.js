describe('/bank/:id Service', function() {

	it('should get bank by given parameter id when valid data are sent (6.2.1)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'GET',
			url: '/v1/bank/' + localStorage.getItem('bankId')
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

	describe('Parameter Validation', function() {

		it('should return 1006 error when bank id is invalid (6.1.2)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'GET',
				url: '/v1/bank/1234'
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
	});
});