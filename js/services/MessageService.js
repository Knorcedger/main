"use strict";

// this message object is not the same as the videos, since this is only one
// and u cant add or delete it, just read it and update it, it is like a dingleton
TwitchDownload.service("MessageService", function($rootScope) {

	var service = {
		text: "",
		type: "info"
	}

	return {
		getMessage: function() {
			return service;
		},
		setMessage: function(message) {
			service.text = message.text;
			service.type = message.type;
			$rootScope.$broadcast("messageUpdated");
		}
	};
});

// <span class="message-panel {{type}}" ng-class="{hidden: !text}" ng-controller="MessageCtrl">{{text}}</span>