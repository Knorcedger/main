describe('/markets Service', function() {

	it('should retrieve all markets that exist in database when valid data are sent (5.2.1)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'Get',
			url: '/v1/markets'
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