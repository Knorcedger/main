Witer.service('activeUser', function(store) {
	this.get = function() {
		return store.get('activeUser');
	};
	this.set = function(value) {
		return store.set('activeUser', value, true);
	}
	this.remove = function(value) {
		return store.remove('activeUser');
	}
});