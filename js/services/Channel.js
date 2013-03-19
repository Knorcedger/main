"use strict";

TwitchDownload.service("Channel", function($rootScope) {

	var Channel = null;

	/**
	 * Sets the channel
	 */
	function setChannel(data) {
		if (!angular.equals(Channel, data)) {
			console.log("channel.updated", data);
			Channel = data;
			/*$cookieStore.put("User", data);
			if (!data) {
				$cookieStore.put("UserTimeout", null);
			} else {
				$cookieStore.put("UserTimeout", Math.round((new Date()).getTime() / 1000));
			}*/
			$rootScope.$broadcast("channel.updated");
		}
	}

	return {
		set: function(data) {
			if (data) {
				setChannel(data);
			}
		},
		get: function() {
			return Channel;
		},
		remove: function() {
			setChannel(null);
		}
	}
});