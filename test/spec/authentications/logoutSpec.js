describe('/authentications/logout Service', function() {

	it('should logout a user when valid token is sent (2.3.1)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				token: localStorage.getItem('adminToken'),
				secret: APIKEY
			},
			type: 'POST',
			url: '/v1/authentications/logout'
		};
		request(config, callback);
		waitsFor(function() {
			if (callback.callCount > 0) {
				return true;
			}
		});
		runs(function() {
			var response = expect(callback).toBeSuccessful(callback);
		});
	});
});