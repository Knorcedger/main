describe('/measurements/update Service', function() {

	it('should update the measurement of the current user when valid data are sent', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				data: {
					fire: 4
				},
				token: localStorage.getItem('token'),
				secret: APIKEY
			},
			type: 'POST',
			url: '/v1/measurements/update'
		};
		request(config, callback);
		waitsFor(function() {
			if (callback.callCount > 0) {
				return true;
			}
		});
		runs(function() {
			var response = expect(callback).toBeSuccessful(callback);
			expect(response.data).toBeMeasurement();
		});
	});
});