/**
 * In this file we include tests that examine a certain variable
 */
beforeEach(function() {

	var customMatchers = {
		toBeId: function() {
			var result = true,
				value = this.actual;

			if (value.length !== 24) {
				result = false;
			}

			return result;
		},
		toBeEmail: function() {
			var result = true,
				value = this.actual;
		  	var reg_expr = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;  
  			return reg_expr.test(value);  
		},
		toBeImageType: function() {
			var result = true,
				value = this.actual;

			if (['jpeg', 'jpg', 'png', 'gif'].indexOf(value) === -1) {
				result = false;
			}

			return result;
		},
		toBeNumber: function() {
			var result = true,
				value = this.actual;

			if (!_.isNumber(value)) {
				result = false;
			}

			return result;
		},
		toBeTimestamp: function() {
			var result = true,
				value = this.actual;

			if (!value.toString().match(/^\d+$/) || value < 0) {
				result = false;
			}

			return result;
		},
		toBeNotEmptyString: function() {
			var result = true,
				value = this.actual;

			if (value === '') {
				result = false;
			}

			return result;
		},
		toExistIn: function(expected) {
			var result = true,
				value = this.actual;

			if (expected.indexOf(value) === -1) {
				result = false;
			}

			return result;
		},
		toBeCanonical: function() {
			var result = true,
				value = this.actual;

			var regex = /[^a-zα-ωάέήύίόώϊ-]/g;
			result = !regex.test(value);
			return result;
		},
		toBeString: function() {
			var result = true,
				value = this.actual;

			result = _.isString(value);

			return result;
		},
		toBeObject: function() {
			var result = true,
				value = this.actual;

			result = _.isObject(value);

			return result;
		},
		toHaveMaxLengthOf: function(maxLength) {
			var result = true,
				value = this.actual;

			result = (value.length <= maxLength);

			return result;
		},
		toBeArray: function() {
			var result = true,
				value = this.actual;

			result = _.isArray(value);

			return result;
		},
		toBeEmptyArray: function() {
			var result = true,
				value = this.actual;
			result = _.isArray(value);
			result = !value.length;

			return result;
		},
		toBeNotEmptyArray: function() {
			var result = true,
				value = this.actual;

			result = _.isArray(value);
			result = value.length;

			return result;
		},
		toBePhotoType: function() {
			var result = true,
				value = this.actual,
				validTypes = ["jpg", "jpeg", "png", "gif"];

			result = _.indexOf(validTypes, value) < 0 ? false : true;

			return result;
		},
		toBePhotoPath: function() {
			var result = true,
				value = this.actual,
				validTypes = ["jpg", "jpeg", "png", "gif"];

			result = _.indexOf(validTypes, value.split(".").pop()) < 0 ? false : true;

			return result;
		},
		toBeArrayResult: function() {
			var result = true,
				value = this.actual;
			result = _.isArray(value.items) && _.isNumber(value.total);
			return result;
		}
	};


	this.addMatchers(customMatchers);
});