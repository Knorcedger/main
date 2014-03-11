Witer.controller("history", function($scope, measurementData, eventPublisher) {
	$scope.measurementData = measurementData;

	$scope.openModal = function(index) {
		$scope.entryIndex = index;
		eventPublisher.publish('modal.open', index);
	};
	
	$scope.delete = function() {
		$scope.measurementData.splice($scope.entryIndex, 1);
		measurements.save($scope.measurementData);
	};
});