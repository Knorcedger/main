describe('/markets/:id/banks Service', function() {

	it('should retrieve the banks that correspond to the id parameter when valid data are sent (5.4.1)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'Get',
			url: '/v1/markets/' + localStorage.getItem('marketId0') + '/banks'
		};
		request(config, callback);
		waitsFor(function() {
			if (callback.callCount > 0) {
				return true;
			}
		});
		runs(function() {
			var response = expect(callback).toBeSuccessful(callback);
			expect(response.data).toBeListOf('Bank');
		});
	});
});