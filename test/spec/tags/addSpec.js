describe('/tags/add Service', function() {
	it('should create a tag when valid data are sent (7.1.1)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				'title': Math.random().toString(36).substring(7),
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'POST',
			url: '/v1/tags/add'
		}
		request(config, callback);
		waitsFor(function() {
			if (callback.callCount > 0) {
				return true;
			}
		});
		runs(function() {
			var response = expect(callback).toBeSuccessful(callback);
			expect(response.data).toBeTag();
			localStorage.setItem('tagId', response.data._id);
		});
	});

	describe('Parameter Validation', function() {
		it('should return 7101 error when title is empty (7.1.2)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/tags/add'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '7101');
			});
		});
	});

});