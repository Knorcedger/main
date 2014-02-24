beforeEach(function() {

	var customMatchers = {
		toHaveTheseMeta: function(expected) {
			var result = true,
				meta = this.actual.meta;

			if (meta.statusCode !== expected.statusCode) {
				result = false;
			}

			if (meta.version === undefined) {
				result = false;
			}

			return result;
		},
		toHaveFailMeta: function(expected) {
			var result = true,
				meta = this.actual.meta;

			if (meta.statusCode === 'OK') {
				result = false;
			}
			
// 			if (!meta.errorMessage) {
// 				result = false;
// 			}

			if (meta.version === undefined) {
				result = false;
			}
			
			// must have no data
			if (this.actual.data) {
				return false;
			}

			return result;
		},
		toBeSuccessful: function(expected) {
			expect(expected).toHaveBeenCalled();
			var response = expected.argsForCall[0][0];
			expect(response).toHaveTheseAttributes(basicStructure);
			expect(response).toHaveTheseMeta(successMeta);
			// i dont know why this is used for, but based on the source code, it allows me to return the response
			this.reportWasCalled_ = true;

			return response;
		},
		toBeErrorful: function(expected, statusCode) {
			expect(expected).toHaveBeenCalled();
			var response = expected.argsForCall[0][0];
			expect(response).toHaveTheseAttributes(basicStructure);
			expect(response).toHaveFailMeta();
			expect(response.data).toBeNull();
			expect(response.meta.statusCode).toBe(statusCode);
			// i dont know why this is used for, but based on the source code, it allows me to return the response
			this.reportWasCalled_ = true;

			return response;
		}
	};

	this.addMatchers(customMatchers);


});