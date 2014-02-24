Witer.controller('sync', function($scope, $location, $translate, user, eventPublisher) {
	$scope.$on('user.register.success', function(event, data) {
		eventPublisher.publish('toast.display', {message: $translate('sync.REGISTER_SUCCESS')});
		$location.path('/settings');
	});
	
	$scope.$on('user.register.error', function(event, data) {
		eventPublisher.publish('toast.display', {message: data.message.replace(/FirebaseSimpleLogin: /g, '')});
	});
	
	$scope.$on('user.login.success', function(event, data) {
		eventPublisher.publish('toast.display', {message: $translate('sync.LOGIN_SUCCESS')});
		$location.path('/settings');
	});
	
	$scope.$on('user.login.error', function(event, data) {
		eventPublisher.publish('toast.display', {message: data.message.replace(/FirebaseSimpleLogin: /g, '')});
	});
	
	$scope.cancel = function() {
		$location.path('/settings');
	}
	
	$scope.register = function() {
		user.register($scope.registerEmail, $scope.registerPassword);
	}
	
	$scope.login = function() {
		user.login($scope.loginEmail, $scope.loginPassword);
	}
	
	$scope.mode = 'register';
});