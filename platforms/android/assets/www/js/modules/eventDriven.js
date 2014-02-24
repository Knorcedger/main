/**
 * An angular module that helps you to create consistent Collections
 * It is currently used to consume an API, but it' functionality can probably be extended in the future
 *
 * @author Achilleas Tsoumitas
 * @version 1.1.0
 *
 * eventDriven is intented to be used as a helper to create Angular Services
 * that will behave like Collections. It provides helpers to make http (ajax) requests
 * and access the local and session storage.
 *
 * Configuration
 *
 * edProvider can be used to config eventDriven
 * edProvider.config({
		cacheLocation: 'local',
		config: {
			url: 'http://pl-development.herokuapp.com/v1',
			params: {
				secret: "abcd",
			},
			timeout: 5000
		}
	});
 *
 * The available attributes to configure can be seen in the example above
 * cacheLocation can be either local or session, 
 * and the config object contains the main/common url part of the API (each API request
 * defines the rest of the url)
 * params are the parameters that will always be sent with each request
 * and the global timeout for al requests is also set (default is 5000)
 *
 * Classes created with eventDriven are actually services, so we place them inside the
 * service folder but we create a new folder called classes inside.
 * Each class must inject the ed service and call: var user = new ed.Class().extend(options);
 * The options object must have a type attribute, that must be the same as the filename, classname
 * We must notice that we use PascalCase for the class name.
 * Another options attribute can be the _formatter function that takes the request params as a param
 * We use this function to format the data before each request that this class makes
 * Then, the rest of the options attributes are functions of the API
 * Each API function will include something like the following
 * campaigns: {
 * 	this.http({
			action: 'campaigns',
			method: 'GET',
			caching: {
				active: true,
				remove: ['Venues.get', 'self']
			},
			config: {
				url: '/users/self/campaigns',
				params: options && options.params
			}
		});
	}
 *
 * In this example, we create a campaigns method, in this method, we can execute any code we want,
 * and we will also make the http request. The http method takes an object as param that needs an action, 
 * which must be the same as the function name, we must define the http type (method: GET, POST, DELETE, PUT)
 * If we want the response to be cached, we add a caching object and active true. If we want to delete a cache entry
 * we must use the remove attribute. Each request is cached like "endPoint.action", so we also delete it that way
 * except if we want to delete the same request that we use self. One might wonder why we want to decache
 * and recache a request on the same moment. Thats because we want to leave the cache, for someone
 * that access it directly using the browserStorage.
 * The config object contains only the url and params objects. The url is API url that we must call
 * (this url part is added to the url part we defined in the edProvider config)
 * and the params are the request params.
 * We can also define a timeout attribute to overwrite the timeout for this request.
 *
 * How to call this class
 *
 * user.campaigns(options);
 * The options object can contain the params attribute (request params) and an id attribute,
 * which is an id that we might need to add to the request url (e.g. /venues/id/edit)
 *
 * EventDriven uses the eventPublisher module to publish events for every action that you make
 * BrowserStorage is also used to access the storage.
 *
 */

var eventDriven = angular.module('eventDriven', ['eventPublisher', 'browserStorage']);

eventDriven.options = {};

eventDriven.provider('ed', {
	config: function(options) {
		eventDriven.options = options;
	},
	$get: function($http, $injector, $rootScope, eventPublisher, browserStorage) {
	
		this.config = {};
		
		var Class = function() {};
		
		Class.prototype.extend = function(options) {
			// find the final config based on eventDriven options and this Class instantiation options
			// first, reset the config
			this.config = angular.copy(eventDriven.options.config);
			// then apply this Class's config
			var finalConfig = angular.extend(this.config || {}, options.config);
			// apply the rest of the given options
			angular.extend(this, options);
			// set the config
			this.config = finalConfig;
			return this;
		};
		
		/**
		 * Performs an http request
		 * @param  {Object} optiosns
		 * Options params
		 * @param {String} action Required. The name of the action that is currently performed
		 * @param {String} method Required. GET or POST
		 * @param {Object} config The params that will be sent to the server
		 */
		Class.prototype.http = function(options) {
			// setup a config object that inludes data that will be transfered inside the $http
			var config = {
				method: options.method,
				CollectionType: this.type,
				CollectionAction: options.action,
				caching: options.caching
			};
			
			// find the final config
			var params = angular.extend({}, this.config.params, options.config.params);
			config = angular.extend({}, this.config, options.config, config);
			config.params = params;
			
			// check if the Class has a formatter
			if (this._formatter) {
				config.params = this._formatter(config.params);
			}
			
			config.url = findUrl(this.config, options.config);
			config.identifier = config.params.identifier !== undefined && '.' + config.params.identifier || '';
			delete config.params.identifier;
			
			//check for cache
			var response;
			if (options.caching) {
				if ((options.caching.active && !options.caching.remove) || (options.caching.active && options.caching.remove && options.caching.remove.indexOf('self') === -1)) {
					response = cache.search(config);
				}
			}
			
			if (!response) {
				request(config);
			}
		};
		
		// find the final url
		function findUrl(classConfig, optionsConfig) {
			var url;
			if (optionsConfig && optionsConfig.url) {
				if (optionsConfig.url.substr(0, 4) === 'http') {
					url = optionsConfig.url;
				} else {
					url = classConfig.url + optionsConfig.url;
				}
			}
			
			return url;
		}
		
		var cache = {
			search: function(config) {
				var response = browserStorage[eventDriven.options.cacheLocation].load(config.CollectionType + '.' + config.CollectionAction);
				if (response) {
					eventPublisher.publish(response.config.CollectionType + '.' + response.config.CollectionAction + '.success' + config.identifier, response.data);
				}
				// remove cache
				if (config.caching.remove) {
					cache.remove(config.caching.remove);
				}
				
				return response;
			},
			remove: function(removes) {
				for (var i = 0, length = removes.length; i < length; i++) {
					browserStorage[eventDriven.options.cacheLocation].remove(removes[i]);
				}
			}
		};
		
		function request(config) {
			$http(config).then(function(response) {
				if (response && response.data && response.data.meta && response.data.meta.statusCode === 200) {
					// cache
					if (response.config.caching) {
						if (response.config.caching.remove) {
							cache.remove(response.config.caching.remove);
						}
						// save it to storage if we were told to do it
						if (response.config.caching && response.config.caching.active) {
							browserStorage[eventDriven.options.cacheLocation].save(response.config.CollectionType + '.' + response.config.CollectionAction, response);
						}
					}
					eventPublisher.publish(response.config.CollectionType + '.' + response.config.CollectionAction + '.success' + config.identifier, response.data);
				} else if (response && response.data && response.data.meta && response.data.meta.statusCode !== 200) {
					eventPublisher.publish(response.config.CollectionType + '.' + response.config.CollectionAction + '.error' + config.identifier, response.data);
				}
			}, function(response) {
				eventPublisher.publish(response.config.CollectionType + '.' + response.config.CollectionAction + '.fail' + config.identifier, response);
			});
		}
		
		/*Class.prototype.findWhere = function(options) {
			// load from storage
			var data = browserStorage[eventDrivenOptions.storage].load(options.where);
			if (data) {
				data = data.data;
				
				findMatch(data, options);
			} else {
				var originalOptions = _.cloneDeep(options);
				// if no cache exists, call the ajax request
				// and then call the original action again
				var object = options.where.split('.')[0];
				var action = options.where.split('.')[1];
				// inject the class
				var Class = $injector.get(object);
				// add a new identifier
				options.config.params.identifier = 'internal';
				Class[action](options.config);
				// this.http(options).call(Class);
				$rootScope.$on(options.where + '.success.internal', function(event, data) {
					delete $rootScope.$$listeners[options.where + '.success.internal'];
					Class[options.action](originalOptions.config);
				});
			}
		};*/
		
		function findMatch(data, options) {
			// the object must match all params
			var requiredMatches = Object.keys(options.config.params).length;
			var matched = 0, object;
			for (var i = 0, length = data.length; i < length; i++) {
				matched = 0;
				for (var param in options.config.params) {
					if (param === 'identifier') {
						matched++;
					} else if (data[i][param] === options.config.params[param]) {
						matched++;
					}
						}
				if (requiredMatches === matched) {
					object = options.where.split('.')[0];
					// find the identifier
					var identifier = options.config.params.identifier && '.' + options.config.params.identifier || '';
					eventPublisher.publish(object + '.' + options.action + '.success' + identifier, data[i]);
				}
			}
		}
		
		Class.prototype.formData = function(options) {

			var config = {
				method: options.method,
				CollectionType: this.type,
				CollectionAction: options.action,
				Info: options.config.params && options.config.params.info
			};
			for (var param in eventDriven.options.config.params) {
				options.config.params.append(param, eventDriven.options.config.params[param]);
			}
			var ActiveUser = $injector.get('ActiveUser');
			var activeUser = ActiveUser.get();
			options.config.params.append('token', activeUser && activeUser.token);

			$.ajax({
				url: eventDriven.options.config.url + options.config.url,
				data: options.config.params,
				processData: false,
				contentType: false,
				type: 'POST',
				success: function(response){
					if (response && response.meta && response.meta.statusCode === 200) {
						eventPublisher.publish(config.CollectionType + '.' + config.CollectionAction + '.success' + (config.Info || ''), response);
					} else {
						eventPublisher.publish(config.CollectionType + '.' + config.CollectionAction + '.error' + (config.Info || ''), response);
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					eventPublisher.publish(config.CollectionType + '.' + config.CollectionAction + '.fail' + config.Info, textStatus);
				}
			});
		};
			
		/**
		 * Access to local and session storage
		 * @param  {Object} options
		 * Options params
		 * @param {String} action Required. The name of the action that is currently performed
		 * @param {String} location Required. local or session
		 * @param {String} method Required. load, save, remove, clear
		 * @param {String} key The key that we will manipulate
		 * @param {} value The value that will be inserted to the specified key
		 * @param {Number} expiration The time in ms that the key will be stored
		 * @param {Boolean} supress Supress events
		 * @return {} The browserStorage result
		 */
		Class.prototype.browserStorage = function(options) {
			var response = browserStorage[options.location][options.method](options.key, options.value, options.expiration);
			if (!options.supress) {
				eventPublisher.publish(this.type + '.' + options.action + '.success', response);
			}
			return response;
		};
		
		return {
			config: this.config,
			Class: Class
		};
	}
});