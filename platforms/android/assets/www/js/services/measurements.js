Witer.service('measurements', function(ed, browserStorage, store, $firebase, firebaseUrl, activeUser) {

	var activeUser = activeUser.get();

	var measurementsRef = new Firebase(firebaseUrl + '/measurements/' + activeUser.id);
	// Automatically syncs everywhere in realtime
	var themeasurements = $firebase(measurementsRef);

	var measurements = new ed.Class().extend({
		type: 'measurements',
		config: {},
		load: function() {
			return $firebase(measurementsRef)
// 				return store.get('measurements') || [];
// 				return this.browserStorage({
// 					action: 'load',
// 					location: 'local',
// 					method: 'load',
// 					key: 'measurements'
// 				});
		},
		save: function(value) {
			themeasurements.$add(value);
			return store.set('measurements', value, true);
// 				return this.browserStorage({
// 					action: 'save',
// 					location: 'local',
// 					method: 'save',
// 					key: 'measurements',
// 					value: value
// 				});
		}
	});

	return measurements;
});