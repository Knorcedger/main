Witer.controller('home', function($scope, measurements, store, converter, cordovaWrapper) {
	
	var measurementData = measurements.load();
	$scope.measurementData = measurementData;
	
	var lowest = {trend: 10000};
	var highest = {trend: 0};
	var firstThisMonth = {date: 10000000000000};
	var firstThisWeek = {date: 10000000000000};
	
	if (measurementData && measurementData.length) {
		$scope.totalMeasurements = measurementData.length;
		
		var currentMonth = new Date((new Date()).getFullYear(), (new Date()).getMonth() - 1).getTime();
		var date = new Date();
		var lastWeek = date.setDate(date.getDate() - 7);
		
		for (var i = 0, length = measurementData.length; i < length; i++) {
			// find lowest
			if (measurementData[i].trend < lowest.trend) {
				lowest = measurementData[i];
			}
			// find highest
			if (measurementData[i].trend > highest.trend) {
				highest = measurementData[i];
			}
			// find the first entry of the current month
			if (measurementData[i].date > currentMonth && measurementData[i].date < firstThisMonth.date) {
				firstThisMonth = measurementData[i];
			}
			// find the first entry of the current week
			if (measurementData[i].date > lastWeek && measurementData[i].date < firstThisWeek.date) {
				firstThisWeek = measurementData[i];
			}
		}
		$scope.changeThisMonth = (measurementData[0].trend - firstThisMonth.trend).toFixed(1);
		$scope.changeThisWeek = (measurementData[0].trend - firstThisWeek.trend).toFixed(1);
		$scope.lowest = lowest;
		$scope.highest = highest;
		$scope.latest = measurementData[0].weight;
		$scope.trend = measurementData[0].trend;
		
		// total change
		$scope.total = {
			weight: (measurementData[0].weight - measurementData[measurementData.length - 1].weight).toFixed(1),
			date: measurementData[measurementData.length - 1].date
		};
		
		// BMI
		var height = store.get('height');
		if (height) {
			var weight = converter.toKg(measurementData[0].trend);
			var height = converter.toM(height);
			$scope.bmi = weight / Math.pow(height, 2);
		}
	} else {
		$scope.totalMeasurements = 0;
		$scope.lowest = '---';
		$scope.highest = '---';
		$scope.total = '---';
		$scope.changeThisMonth = 0;
		$scope.changeThisWeek = 0;
		$scope.latest = '---';
	}
	
});