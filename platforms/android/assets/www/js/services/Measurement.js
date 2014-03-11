Witer.service('Measurement', function($q, Restangular) {

	return {
		add: function(data) {
			var deferred = $q.defer();
			
			Restangular.all('measurements').customPOST(data, 'add')
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
		},
		update: function(data) {
			var deferred = $q.defer();
			
			Restangular.all('measurements').customPOST(data, 'update')
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