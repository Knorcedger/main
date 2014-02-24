var token;

describe('/tags/:id Service', function() {

	// describe('Parameter Validation', function() {
	// 	it('should expect a title (1.1.1)', function() {
	// 		var callback = jasmine.createSpy();
	// 		var config = {
	// 			data: {
	// 				'title': ''
	// 			}
	// 		};
	// 		config.data = JSON.stringify(config.data);
	// 		campaignsAdd(config, callback);
	// 		waitsFor(function() {
	// 			if (callback.callCount > 0) {
	// 				return true;
	// 			}
	// 		});
	// 		runs(function() {
	// 			expect(callback).toHaveBeenCalled();
	// 			var response = callback.argsForCall[0][0];
	// 			expect(response).toHaveTheseAttributes(basicStructure);
	// 			expect(response).toHaveTheseMeta([3001]);
	// 			expect(response.data).toBe(null);

	// 		});
	// 	});
	// });
	
	it('should get a tag when valid is sent (1.2.1)', function() {
		var callback = jasmine.createSpy();
		var config = {
			data: {
				'title': Math.random().toString(36).substring(7)
			},
			type: 'GET',
			url: '/v1/tags/' + localStorage.getItem('tagId')
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
			expect(response.data).toBeTag();
		});
	});

});