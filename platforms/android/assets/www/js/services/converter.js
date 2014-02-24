Witer.service('converter', function(preferences) {
	return {
		toKg: function (value) {
			var result = value;
			if (preferences.get().weightUnit.code === 'lb') {
				result = result * 0.453592;
			}
			
			return result;
		},
		toM: function(value) {
			var result = value;
			if (preferences.get().heightUnit.code === 'ft') {
				result = result / 3.2808;
			}
			
			return result;
		}
	}
});