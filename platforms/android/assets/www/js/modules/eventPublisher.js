/**
 * An angular service that publishes events and logs them too
 *
 * @author Achilleas Tsoumitas
 * @version 3.4.0
 *
 * @todo Port to node
 *
 * @example
 * EventPublisher.group(['Task.add', 'Task.remove'], 'Task.complete', true, 2000);
 * EventPublisher.publish("Task.add.success", {data: 1});
 * EventPublisher.publish("Task.remove.success", {data: 2});
 * It will fire Task.complete.success or Task.complete.error
 * 
 * @changelog
 * v3.4.0
 * Added the publishData directive
 *
 * v3.3.0
 * Profiling of grouped events added
 *
 * v3.2.0
 * Bug fix, and event publishing on group progress, more options added, timeout bug fix
 *
 * v3.1.0
 * It now uses $log instead of console and also logs the error stack in the debug panel
 *
 * v3.0.1
 * Bug fix that groups were not deleted
 *
 * v3.0.0
 * It became a provider. Changed the config. Code clean up
 *
 * v2.8.0
 * Groups create change and timeout event published when not the group timeout is reached
 *
 * v2.7.0
 * An event is fired if the event status is not success
 *
 * v2.6.0
 * Added the service eventPublisherOptions that will define the env config param
 *
 * v2.5.1
 * Fixed the bug that the last grouped event was fired after the group event that was defined
 * 
 * v2.5.0
 * Separated the env logic
 * 
 * v2.4.0
 * Changed broadcast to publish.
 * Cleaned the code
 * Made the first steps to easily port it to node
 * 
 * v2.3.0
 * Provider removed
 * Code optimizations
 * 
 * v2.2.0
 * It now handles errors properly
 * 
 * v2.1.0
 * Added a provider to configure the EventPublisher in app.js
 * 
 * v2.0.0
 * Now supports events on objects, on actions, on statuses and statusesInfo.
 * You can also declare the statuses that you want to be published as events
 * You can also group events into other events that will be pubslished when all grouped events are done
 *
 * v1.2.0
 * It will now broadcast the generic error and fail events only if no overwrites exist
 *
 * v1.1.0
 * It now supports error and fail events
 *
 */


var eventPublisher = angular.module('eventPublisher', []);

eventPublisher.options = {
	mode: 'debug',
	logSize: 5,
	publishProgress: false,
	timeout: 5000
};

eventPublisher.provider('eventPublisher', {
	config: function(options) {
		eventPublisher.options = angular.extend(eventPublisher.options, options);
	},
	$get: function($rootScope, $timeout, $log, eventPublisherLog) {

		var Pubsub = function() {
			this.subscribers = {};
		};

		Pubsub.prototype.on = function(eventName, fn) {
			if (!_.isArray(this.subscribers[eventName])) {
				this.subscribers[eventName] = [];
			}
			this.subscribers[eventName].push(fn);
		};

		Pubsub.prototype.publish = function(event) {
			var eventName = event.object + '.' + event.action;
			for (var i = 0, length = this.subscribers[eventName] && this.subscribers[eventName].length || 0; i < length; i++) {
				this.subscribers[eventName][i].apply(this, arguments);
			}
		};

		var Private = {
			/**
			 * Default configuration
			 * @type {Object}
			 */
			suppressedEvents: [],
			groups: {},
			group: {
				create: function(events, groupTitle, suppress, timeout) {
					var pubsub = new Pubsub();
					pubsub.title = groupTitle;
					pubsub.suppress = suppress;
					pubsub.published = {};
					pubsub.profiling = {};
					pubsub.data = {};
					pubsub.progress = 0;

					for (var i = 0, length = events.length; i < length; i++) {
						pubsub.published[events[i]] = false;
						// add profiling
						if (eventPublisher.options.mode === 'debug') {
							pubsub.profiling[events[i]] = {
								start: new Date().getTime()
							};
						}
						// add events as suppressed
						if (pubsub.suppress) {
							Private.suppressedEvents.push(events[i]);
						}
						// listener
						pubsub.on(events[i], function(event, data) {
							if (event.status === 'success') {
								var eventName = event.object + '.' + event.action;
								// mark as published
								this.published[eventName] = true;
								// update progress
								if (eventPublisher.options.publishProgress) {
									this.progress = Private.group.updateProgress(this);
								}
								// update profiling
								if (eventPublisher.options.mode === 'debug') {
									this.profiling[eventName].end = new Date().getTime();
									this.profiling[eventName].time = this.profiling[eventName].end - this.profiling[eventName].start;
								}
								// save the data
								this.data[eventName] = data;
								// if all the groups events have been published
								var status = _.unique(_.values(this.published));
								if (status.length === 1 && status[0] === true) {
									// broadcast it
									Public.publish(this.title + '.success', this.data);
									// remove the group
									Private.group.remove(this.title);
								}
							} else {
								// remove the group
								Private.group.remove(this.title);
								// publish it
								Public.publish(this.title + '.error', this.data);
							}
						});
					}
					// remove the group after a timeout, we dont want unpublished events to permanently add groups
					pubsub.timeout = $timeout(function() {
						Private.group.remove(groupTitle, true);
					}, timeout || eventPublisher.options.timeout);
					
					Private.groups[groupTitle] = pubsub;
					Private.publish('eventPublisher.createGroup.success', {
						groupTitle: groupTitle,
						events: events,
						suppress: suppress
					});
				},
				remove: function(title, timeout) {
					// check if the specified group still exists
					var found = _.find(Private.groups, function(item) {
						return item.title === title;
					});
					if (found) {
						// if we came here from a timeout, publish it
						if (timeout) {
							Public.publish(title + '.timeout');
						}
						// also remove this group
						var data;
						for (var group in Private.groups) {
							if (group === title) {
								data = Private.groups[group];
								$timeout.cancel(Private.groups[group].timeout);
								delete Private.groups[group];
								break;
							}
						}
						Private.publish('eventPublisher.removeGroup.success', data);
					}
				},
				updateProgress: function(pubsub) {
					var published = 0;
					var total = 0;
					for (var event in pubsub.published) {
						if (pubsub.published[event] === true) {
							published++;
						}
						total++;
					}
					
					var clone = angular.copy(pubsub);
					clone.progress = published / total;
					Private.publish('eventPublisher.groupProgressUpdate.success', clone);
					return published / total;
				}
			},
			createEvent: function(eventName) {
				var temp = eventName.split('.');
				var Event = {
					object: temp[0],
					action: temp[1],
					status: temp[2],
					statusInfo: temp[3],
					type: eventName
				};

				return Event;
			},
			log: function(eventName, data, info) {
				var error = new Error();
				var stack = error.stack;
				
				data = data || '';
				
				$log.debug('Event', [eventName, data, info]);
				
// 				if (info) {
// 					$log.log(eventName, data, info);
// 					$log.debug(eventName, data, info, stack);
// 				} else {
// 					$log.log(eventName, data);
// 					$log.debug(eventName, data, stack);
// 				}
				eventPublisherLog.add({
					eventName: eventName,
					data: data,
					info: info,
					stack: stack
				});
			},
			publish: function(eventName, data, info) {
				if (eventPublisher.options.mode === 'debug') {
					Private.log(eventName, data, info);
				}
				$rootScope.$broadcast(eventName, data, info);
			}
		};

		var Public = {
			publish: function(eventName, data, info) {

				var Event = Private.createEvent(eventName);

				if (Private.suppressedEvents.indexOf(Event.object + '.' + Event.action) === -1) {
					Private.publish(eventName, data, info);
					// fire a generic event if the status is not success and its not a command
					if (Event.status && Event.status !== 'success') {
						Private.publish(Event.status, data, eventName);
					}
				} else {
					// remove it
					Private.suppressedEvents = _.without(Private.suppressedEvents, Event.object + '.' + Event.action);
				}
				
				// check for groups
				for (var groupTitle in Private.groups) {
					// this group get removed before this line executes. If, avoids errors
					if (Private.groups[groupTitle]) {
						Private.groups[groupTitle].publish(Event, data);
					}
				}
			},
			/**
			 * Groups events
			 * @param  {Array} events An array of the events to group
			 * @param  {String} groupTitle The event that will be fired when all grouped events are complete
			 * @param  {Boolean} suppress If you want to fire on not the grouped events
			 * @param  {Number} timeout The number in miliseconds in which the group will be deleted
			 */
			group: {
				create: function(events, groupTitle, suppress, timeout) {
					Private.group.create(events, groupTitle, suppress, timeout);
				},
				remove: function(title) {
					Private.group.remove(title);
				}
			}
		};

		return Public;
	}
});

eventPublisher.factory('eventPublisherLog', function() {
	var eventHistory = [];

    return {
		add: function(data) {
			eventHistory.push(data);
			if (eventHistory.length > eventPublisher.options.logSize) {
				eventHistory.splice(0, 1);
			}
		},
		all: function() {
			return eventHistory;
		}
	};
});

eventPublisher.directive('publishData', function(eventPublisher) {
	return {
		restrict: 'A',
		scope: {
			event: '@publishEventType',
			eventName: '@publishEventName',
			data: '=publishData'
		},
		link: function(scope, element, attrs) {
			element.on(scope.event, function() {
				eventPublisher.publish(scope.eventName, scope.data);
			});
		}
	};
});