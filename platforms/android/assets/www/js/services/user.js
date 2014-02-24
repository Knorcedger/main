Witer.service('user', function($firebase, $firebaseSimpleLogin, eventPublisher, store, activeUser, firebaseUrl) {
// 	var userRef = new Firebase("https://flickering-fire-1863.firebaseio.com/tasks/knorcedger2");
//     debugger;
// 	console.log(userRef);
// 	var activeUser = $firebase(userRef);
// 	console.log(activeUser);
	
	var ref = new Firebase(firebaseUrl);
	var auth = $firebaseSimpleLogin(ref);
	
	return {
		register: function(email, password) {		
			auth.$createUser(email, password)
			.then(function(value) {
				store.set('activeUser', value, true);
				eventPublisher.publish('user.register.success', value);
			}, function(error) {
				eventPublisher.publish('user.register.error', error);
			});
		},
		login: function(email, password) {
			auth.$login('password', {
				email: email,
				password: password,
				rememberMe: true
			}).then(function(value) {
				store.set('activeUser', value, true);
				eventPublisher.publish('user.login.success', value);
			}, function(error) {
				eventPublisher.publish('user.login.error', error);
			});
		},
		logout: function() {
			if (auth.user) {
				auth.$logout();
			}
			activeUser.remove();
			eventPublisher.publish('user.logout.success');
		}
	}
	
    //$scope.tasks = $firebase(tasksRef);
	//activeUser.set({ email: 'hello@hello.com', name: 'Alex', phone: 12912912 });
	
// 	$scope.tasks = activeUser.child('tasks');
	
// 	$scope.tasks.push({
// 		text: "Logistics with Zoran"
// 	});
});