describe('/documents/create Service', function() {
	
	describe('validations', function() {

	});
	
	describe('valid requests', function() {
		it('should create a document when valid data are sent (2.4.1)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					secret: '1234'
				},
				type: 'POST',
				url: '/v1/documents/create'
			};
			config.data = JSON.stringify(config.data);
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeSuccessful(callback);
				expect(response.data).toBeDocument();
			});
		});
	});

});