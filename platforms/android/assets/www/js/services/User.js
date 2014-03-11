Witer.service('User', function($q, Restangular) {

	return {
		measurements: function() {
			var deferred = $q.defer();
			
			Restangular.one('users', 'self').customGET('measurements')
			.then(function(result) {
				if (result.meta.statusCode === 'OK') {
					deferred.resolve(result.data)
				} else {
					deferred.reject(result.meta.statusCode);
				}
			}, function() {
				deferred.reject('FAIL');
			});
			
			return deferred.promise;
		}
	}
	
});