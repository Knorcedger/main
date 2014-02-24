var preferences = angular.module('preferences', []);

// available preferences
preferences.service('availablePreferences', function() {
	return {
		languages: [{
			title: 'English',
			code: 'en_US'
		}],
		dateFormats: ['MM/dd/yyyy', 'dd/MM/yyyy'],
		weightUnits: [{
			title: 'Pounds',
			code: 'lb'
		}, {
			title: 'Kilograms',
			code: 'kg'
		}],
		heightUnits: [{
			title: 'Feet',
			code: 'ft'
		}, {
			title: 'Meters',
			code: 'm'
		}],
		energyUnits: [{
			title: 'Kilocalories',
			code: 'kcal'
		}, {
			title: 'Kilojoule',
			code: 'kJ'
		}]
	};
});

preferences.provider('preferences', {
	// selected preferences
	selected: {},
	$get: function($rootScope, browserStorage) {
		return {
			// contains the preferences as a simple object
			_raw: {},
			// just returns raw
			get: function() {
				return this._raw;
			},
			set: function(setting, value) {
				this._raw[setting] = value;
				browserStorage.local.save('preferences', this._raw);
				$rootScope.preferences = this._raw;
			}
		};
	}
}).run(function($rootScope, preferences, availablePreferences, browserStorage) {
	// load preferences
	var pref = browserStorage.local.load('preferences');
	// on first load, set defaults
	if (!pref) {
		// default preferences
		pref = {
			language: availablePreferences.languages[0],
			dateFormat: availablePreferences.dateFormats[0],
			weightUnit: availablePreferences.weightUnits[0],
			heightUnit: availablePreferences.heightUnits[0]
		};
		browserStorage.local.save('preferences', pref);
	}
	// save them on the service
	preferences._raw = pref;
	// save on rootScope
	$rootScope.preferences = pref;
});