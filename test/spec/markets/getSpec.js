describe('/markets/:id Service', function() {

	it('should retrieve a market by id (id param) when valid data are sent (5.3.1)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'Get',
			url: '/v1/markets/' + localStorage.getItem('marketId0')
		};
		request(config, callback);
		waitsFor(function() {
			if (callback.callCount > 0) {
				return true;
			}
		});
		runs(function() {
			var response = expect(callback).toBeSuccessful(callback);
			expect(response.data).toBeListOf('Market');
		});
	});
});