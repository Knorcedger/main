Witer.service('measurements', function($q, store, User, activeUser, Measurement) {

	var measurements;

	var methods = {
		load: function(username, password) {
			var deferred = $q.defer();
			// if measurements is defined, just return it
			if (measurements) {
				deferred.resolve(measurements);
			} else {
				if (activeUser.get()) {
					User.measurements()
					.then(function(result) {
						debugger;
					}, function(result) {
						debugger;
					});
				} else {
					measurements = store.get('measurements') && store.get('measurements').data;
					deferred.resolve(measurements);
				}
			}
			
			return deferred.promise;
		}
	};
	
	return {
		save: function(data) {
			var deferred = $q.defer();
			
			var data = {
				data: data,
				lastUpdate: Date.now()
			}
			// save to the server
			if (activeUser.get()) {
				// do update, if update fails, do add
				Measurement.update(data)
				.then(function(result) {
					if (result === 'notFound') {
						Measurement.add(data);
					}/* else {
						deferred.resolve();
					}*/
				});
			}

			measurements = data;
			store.set('measurements', data, true);
			deferred.resolve(measurements);
			
			return deferred.promise;
		},
		get: function() {
			var deferred = $q.defer();
			
			measurements = measurements && measurements.data || store.get('measurements') && store.get('measurements').data;
			deferred.resolve(measurements);
			
			return deferred.promise;
		},
		sync: function() {
			var deferred = $q.defer();
			
			// save this on q, because the promise is executed on global scope
			$q.self = this;
			
			if (!measurements && activeUser.get()) {
				User.measurements()
				.then(function(result) {
					// the user has no measurements online
					// so send the local online
					if (result === 'notFound') {
						var localMeasurements = store.get('measurements');
						var data = localMeasurements && localMeasurements.data;
						$q.self.save(data)
						.then(function(result) {
							deferred.resolve(result);
						});
					} else {
						// check local or online has the newer entry
						measurements = result.data;
						store.set('measurements', measurements, true);
						deferred.resolve(result.data);
					}
				}, function(result) {
					deferred.reject();
				});
			}/* else if (measurements) {
				deferred.resolve(measurements);
			}*/ else {
				// user is not logged in
				this.get()
				.then(function(result) {
					// cache the measurements
					measurements = result;
					// and resolve
					deferred.resolve(measurements);
				});
			}
			
			return deferred.promise;
		}
	};
	
});