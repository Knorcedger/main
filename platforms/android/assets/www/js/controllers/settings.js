Witer.controller('settings', function($scope, $rootScope, $timeout, $translate, store, availablePreferences, preferences, activeUser, user, eventPublisher){

	$scope.$on('user.logout.success', function() {
		$scope.activeUser = activeUser.get();
		eventPublisher.publish('toast.display', {message: $translate('settings.LOGOUT_SUCCESS')});
	});

	$scope.$watch('weightUnit', function(newValue, oldValue) {
		preferences.set('weightUnit', newValue);
	});
	
	$scope.$watch('heightUnit', function(newValue, oldValue) {
		preferences.set('heightUnit', newValue);
		findHeights();
	});
	
	$scope.$watch('dateFormat', function(newValue, oldValue) {
		preferences.set('dateFormat', newValue);
	});
	
	$scope.$watch('height', function(newValue, oldValue) {
		if (newValue) {
			store.set('height', parseFloat(newValue), true);
		}
	});
	
	$scope.logout = function() {
		user.logout();
	}
	
	$scope.activeUser = activeUser.get();
	
	$scope.availablePreferences = availablePreferences;
	
	for (var i = 0, length = availablePreferences.weightUnits.length; i < length; i++) {
		if (availablePreferences.weightUnits[i].title === $rootScope.preferences.weightUnit.title) {
			$scope.weightUnit = availablePreferences.weightUnits[i];
		}
	}
	
	for (i = 0, length = availablePreferences.heightUnits.length; i < length; i++) {
		if (availablePreferences.heightUnits[i].title === $rootScope.preferences.heightUnit.title) {
			$scope.heightUnit = availablePreferences.heightUnits[i];
		}
	}
	
	for (i = 0, length = availablePreferences.dateFormats.length; i < length; i++) {
		if (availablePreferences.dateFormats[i] === $rootScope.preferences.dateFormat) {
			$scope.dateFormat = availablePreferences.dateFormats[i];
		}
	}
	
	// HEIGHT
	var limits = {
		meters: {
			low: 1.40,
			high: 2.20,
			step: 0.01,
			decimals: 2
		},
		feet: {
			low: 4.6,
			high: 7.2,
			step: 0.1,
			decimals: 1
		}
	};
	
	var availableHeights;
	
	var count = 0;
	function findHeights(change) {
		var units = $scope.heightUnit.title.toLowerCase();
		
		var height = store.get('height');
		if (count !== 0 && height) {
			if (units === 'meters') {
				height = height / 3.2808;
			} else {
				height = height * 3.2808;
			}
			store.set('height', height, true);
		}
		count++;
		if (height) {
			$scope.height = height.toFixed(limits[units].decimals);
		}
	
		//create the values to display in the dropdown
		availableHeights = [];
		for (var i = limits[units].low; i < limits[units].high; i += limits[units].step) {
			i = i.toFixed(limits[units].decimals);
			availableHeights.push({
				key: i,
				value: i
			});
			i = parseFloat(i);
		}
		$scope.availableHeights = availableHeights;
	}
	
// 	$timeout(function() {
// 		$scope.availableHeights = availableHeights;
// 	}, 300);
});