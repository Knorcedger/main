Witer.service('Authentication', function($q, Restangular) {
	return {
		login: function(username, password) {
			var deferred = $q.defer();
			
			Restangular.all('authentications').customPOST({
				username: username,
				password: CryptoJS.SHA256(password).toString()
			}, 'login')
			.then(function(result) {
				if (result.meta.statusCode === 'OK') {
					deferred.resolve(result.data)
				} else {
					deferred.reject(result.meta.statusCode);
				}
			}, function(result) {
				deferred.reject('FAIL');
			})
			
			return deferred.promise;
		},
		register: function(username, password) {
			var deferred = $q.defer();

			Restangular.all('authentications').customPOST({
				username: username,
				password: CryptoJS.SHA256(password).toString()
			}, 'register')
			.then(function(result) {
				if (result.meta.statusCode === 'OK') {
					deferred.resolve(result.data)
				} else {
					deferred.reject(result.meta.statusCode);
				}
			}, function(result) {
				deferred.reject('FAIL');
			});
			
			return deferred.promise;
		}
	}
	
});