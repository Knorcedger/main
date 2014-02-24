describe('/documents/update Service', function() {
	
	// describe('validations', function() {
	// 	it('should create a document when valid data are sent (2.3.1)', function() {
	// 		var callback = jasmine.createSpy();
	// 		var config = {
	// 			data: {
	// 				title: Math.random().toString(36).substring(7),
	// 				topics: [
	// 					{
	// 						title: Math.random().toString(36).substring(7),
	// 						content: Math.random().toString(36).substring(2),
	// 						tags: [Math.random().toString(36).substring(7), Math.random().toString(36).substring(7)]
	// 					},
	// 					{
	// 						title: Math.random().toString(36).substring(7),
	// 						content: Math.random().toString(36).substring(2),
	// 						tags: [Math.random().toString(36).substring(7), Math.random().toString(36).substring(7)]
	// 					}
	// 				],
	// 				secret: '1234'
	// 			},
	// 			type: 'POST',
	// 			url: '/v1/documents/add'
	// 		};
	// 		config.data = JSON.stringify(config.data);
	// 		request(config, callback);
	// 		waitsFor(function() {
	// 			if (callback.callCount > 0) {
	// 				return true;
	// 			}
	// 		});
	// 		runs(function() {
	// 			var response = expect(callback).toBeSuccessful(callback);
	// 			expect(response.data).toBeDocument();
	// 			localStorage.setItem('documentId', response.data._id);
	// 		});
	// 	});
	// });
	
	describe('valid requests', function() {
		it('should update a document when valid data are sent (3.4.2)', function() {
			var callback = jasmine.createSpy();
			var config = {
				data: {
					document: {
						title: Math.random().toString(36).substring(7),
						topics: [
							{
								title: Math.random().toString(36).substring(7),
								content: Math.random().toString(36).substring(2),
								tags: [Math.random().toString(36).substring(7), Math.random().toString(36).substring(7)]
							},
							{
								title: Math.random().toString(36).substring(7),
								content: Math.random().toString(36).substring(2),
								tags: [Math.random().toString(36).substring(7), Math.random().toString(36).substring(7)]
							}
						]
					},
					secret: '1234'
				},
				type: 'POST',
				url: '/v1/documents/' + localStorage.getItem('documentId') + '/update'
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