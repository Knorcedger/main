Witer.controller('input', function($scope, $rootScope, $location, $timeout, eventPublisher, measurements, dateFilter, $translate) {
	$scope.$on('cancel.click.success', function() {
		$location.path('/');
	});
	
	$scope.$on('done.click.success', function() {
		var temp = $scope.date.split('-');
		var date = new Date(temp[0], parseInt(temp[1], 10) - 1, temp[2]);
		var measurement = {
			date: date.getTime(),
			weight: parseFloat($scope.weight)
		};

		// if we add a second measurement in the same day, overwrite the previous one
		if (measurementData.length) {
			if (measurement.date !== measurementData[0].date) {
				measurementData.unshift(measurement);
			} else {
				measurementData[0].weight = measurement.weight;
			}
		}
		// find trend
		//findTrend();
		// order them by date
// 		measurementData = _.sortBy(measurementData, 'date').reverse();
		// save
		measurements.save(measurement);
// 		measurements.save(measurementData);
		eventPublisher.publish('toast.display', {message: $translate('input.ADDED')});
		// and redirect
		$location.url('/');
	});
	
	eventPublisher.publish('actionbar.showButtons');
	
	// set the default weight to the last saved value, or set to a default value of first open
	var measurementData = measurements.load();
	var limits = {};
	if (measurementData.length) {
		$scope.weight = measurementData[0].weight;
		limits.low = $scope.weight - 20;
		limits.high = $scope.weight + 20;
	} else {
		$scope.weight = 70.0;
		limits.low = 0;
		limits.high = 200;
	}
	
	//create the values to display in the dropdown
	var availableWeights = [];
	for (var i = limits.low; i < limits.high; i += 0.1) {
		i = parseFloat(i.toFixed(1));
		availableWeights.push({
			key: i,
			value: i
		});
		i = parseFloat(i);
	}
	$timeout(function() {
		$scope.availableWeights = availableWeights;
	}, 300);
		
	// set the default day to today
	$scope.date = dateFilter(new Date(), 'yyyy-MM-dd');
	
	// hide the date field for devices below
// 	if (device && parseFloat(device.version) < 4.4) {
		$scope.hideDate = true;
// 	}
	
	// set maxDate to today
	// $scope.maxDate = new Date().getFullYear() + '-' + ('0' + (new Date().getMonth() + 1)).slice(-2) + '-' + ("0" + new Date().getDate()).slice(-2);

	// Adds the trend to the latest measurement
	function findTrend() {
		if (measurementData.length !== 1) {
			var today = new Date((new Date()).getFullYear(), (new Date()).getMonth(), (new Date()).getDate()).getTime();;
			
			var total = 0;
			var weightTotal = 0;
			var weight;
			for (var i = measurementData.length - 1; i > -1; i--) {
				weight = 20 - (today - measurementData[i].date) / 1000 / 60 / 60 / 24;
				if (weight > 0) {
					total += measurementData[i].weight * weight;
					weightTotal += weight;
				}
			}
			measurementData[0].trend = parseFloat((total / weightTotal).toFixed(1));
		} else {
			measurementData[0].trend = measurementData[0].weight;
		}
	}
});