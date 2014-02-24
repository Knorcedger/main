Witer.controller('main', function($scope, $window, $location, eventPublisher) {
	
	// redirect the homepage (its /index.html on mobile)
	if (!$location.$$path || $location.$$path === '/index.html') {
		$location.path('/').replace();
	}
	
	$scope.menu = [{
		'title': 'menu.OVERVIEW',
		'icon': '',
		'url': '/'
	}, {
		'title': 'menu.ADD',
		'icon': '',
		'url': '/input'
	}, {
		'title': 'menu.HISTORY',
		'icon': '',
		'url': '/history'
	}, {
		'title': 'menu.SETTINGS',
		'icon': '',
		'url': '/settings'
	}];
	
	var modalIsOpen = false;
	$scope.$on('modal.open.success', function() {
		modalIsOpen = true;
	});
	
	$scope.$on('modal.close.success', function() {
		modalIsOpen = false;
	});
	
	var actionbarIsOpen = false;
	$scope.$on('actionbar.open.success', function() {
		actionbarIsOpen = true;
	});
	
	$scope.$on('actionbar.close.success', function() {
		actionbarIsOpen = false;
	});
	
	document.addEventListener("backbutton", onBackKeyDown, false);

	function onBackKeyDown() {
		// if a modal is open, close it
		if (modalIsOpen) {
			eventPublisher.publish('modal.close');
		// if the main menu is open, close it
		} else if (actionbarIsOpen) {
			eventPublisher.publish('actionbar.close');
		} else {
			// if we are not in homepage, just go back, else, close the app
			if ($location.path() !== '/') {
				$window.history.back();
			} else {
				navigator.app.exitApp();
			}
		}
	}
	
	$scope.openActionbar = function() {
		eventPublisher.publish('actionbar.open');
	};
	
	$scope.closeActionbar = function() {
		eventPublisher.publish('actionbar.close');
	};
});