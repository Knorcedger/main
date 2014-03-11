Witer.controller('sync', function($scope, $location, $translate, Restangular, Authentication, toast, activeUser, measurements) {
	
	$scope.cancel = function() {
		$location.path('/settings');
	}
	
	$scope.register = function() {
		Authentication.register($scope.registerUsername, $scope.registerPassword)
		.then(function(result) {
			$scope.mode = 'login';
			toast.display($translate('sync.REGISTER_SUCCESS'), 5000);
		}, function(result) {
			var message;
			if (result === 'FAIL') {
				message = $translate('general.FAIL')
			} else {
				message = $translate('sync.error_codes.register.' + result);
			}
			toast.display(message, 5000);
		});
	}
	
	$scope.login = function() {
		Authentication.login($scope.loginUsername, $scope.loginPassword)
		.then(function(result) {
			activeUser.set(result);
			// sync the measurements
			measurements.sync();
			toast.display($translate('sync.LOGIN_SUCCESS'), 5000);
			$location.path('/settings');
		}, function(result) {
			var message;
			if (result === 'FAIL') {
				message = $translate('general.FAIL')
			} else {
				message = $translate('sync.error_codes.login.' + result);
			}
			toast.display(message, 5000);
		});
	}
	
	$scope.mode = 'register';
});