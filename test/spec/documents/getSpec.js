describe('/documents/:id Service', function() {
	
	describe('validations', function() {
		it('should return error when invalid id length is sent (3.2.1)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					secret: APIKEY
				},
				type: 'GET',
				url: '/v1/documents/sdfwe23233'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '3201');
			});
		});
	});

	describe('valid requests', function() {
		it('should get a document when valid id is sent (3.2.1)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					secret: APIKEY
				},
				type: 'GET',
				url: '/v1/documents/' + localStorage.getItem('documentId')
			};
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