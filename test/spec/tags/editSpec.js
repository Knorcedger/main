describe('/tags/:id/edit Service', function() {

	it('should edit a tag when valid data are sent (7.2.1)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				title: "ING" + Math.floor((Math.random()*10000)+1).toString() + 's',
				secret: APIKEY,
				token: localStorage.getItem('adminToken')
			},
			type: 'POST',
			url: '/v1/tags/'+ localStorage.getItem('tagId') + '/edit'
		};
		request(config, callback);
		waitsFor(function() {
			if (callback.callCount > 0) {
				return true;
			}
		});
		runs(function() {
			var response = expect(callback).toBeSuccessful(callback);
			expect(response.data).toBeTag();
		});
	});

	// TODO: create test to check if markets are deleted when market: '' is sent
	describe('Parameter Validation', function() {
		it('should return 7201 error when title is empty (7.2.2)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/tags/'+ localStorage.getItem('tagId') + '/edit'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '7201');
			});
		});

		it('should return 7202 error when request parameter id is does not correspond to an existing tag (7.2.3)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					title: "Hello",
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/tags/'+ localStorage.getItem('bankId') + '/edit'
			};
			request(config, callback);
			waitsFor(function() {
				if (callback.callCount > 0) {
					return true;
				}
			});
			runs(function() {
				var response = expect(callback).toBeErrorful(callback, '7202');
			});
		});

		it('should return 1006 error when tag id parameter  is invalid (6.4.5)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					title: "Hello",
					secret: APIKEY,
					token: localStorage.getItem('adminToken')
				},
				type: 'POST',
				url: '/v1/tags/0/edit'
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