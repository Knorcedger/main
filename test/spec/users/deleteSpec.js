describe('/users/:id/delete Service', function() {

	it('should delete a user when valid data are sent (4.6.1)', function() {
		var callback = jasmine.createSpy();

		var config = {
			data: {
				token: localStorage.getItem('adminToken'),
				secret: APIKEY
			},
			type: 'POST',
			url: '/v1/users/' + localStorage.getItem('toDeleteId') + '/delete'
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
			expect(response.data).toBeUser;
		});
	});

	describe('Parameter Validation', function() {
		it('should return 1006 error when id parameter is invalid (4.6.2)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					token: localStorage.getItem('adminToken'),
					secret: APIKEY
				},
				type: 'POST',
				url: '/v1/users/1324/delete'
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