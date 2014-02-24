/**
 * In this file we include tests that examine an object
 */
beforeEach(function() {

	var customMatchers = {
		toHaveTheseAttributes: function(expected) {
			var result = true,
				response = this.actual;

			var keys = _.keys(response);
			var intersection = _.intersection(keys, expected);
			if (_.difference(intersection, expected).length !== 0) {
				result = false;
			}

			return result;
		},
		toBeListOf: function(endpoint) {
			var value = this.actual;

			for (var i = 0, length = value.length; i < length; i++) {
				expect(value[i])['toBe' + endpoint]();
			}

			return true;
		},
		toBeUser: function() {
			var value = this.actual;
			expect(value).toHaveTheseAttributes(['_id', 'username', 'type']);
			expect(value._id).toBeId();
			expect(value.username).toBeNotEmptyString()
			expect(value.type).toBeNotEmptyString();
			expect(value.password).toBeUndefined();
			expect(value.created).toBeUndefined();

			return true;
		},
		toBeMeasurement: function() {
			var value = this.actual;
			expect(value).toHaveTheseAttributes(['_id', 'data']);
			expect(value._id).toBeId();
// 			expect(value.data).toBeInt();

			return true;
		},
		toBeBank: function() {
			var value = this.actual;
			expect(value).toHaveTheseAttributes(['_id', 'title', 'market']);
			expect(value._id).toBeId();
			expect(value.market).toBeId();
			expect(value.title).toBeNotEmptyString();
			if (value.description) {
				expect(value.description).toBeNotEmptyString();
			}

			return true;
		},
		toBeTag: function() {
			var value = this.actual;
			expect(value).toHaveTheseAttributes(['_id', 'title']);
			expect(value._id).toBeId();
			expect(value.title).toBeNotEmptyString();

			return true;
		},
		toBeUserType: function() {
			var value = this.actual;

			expect(value).toHaveTheseAttributes(['_id', 'title']);
			expect(value._id).toBeId();
			expect(value.title).toExistIn(userTypes);

			return true;
		},
		toBeTag: function() {
			var value = this.actual;

			expect(value).toHaveTheseAttributes(['title']);
			expect(value.title).toBeString();

			return true;
		},
		toBeDocument: function() {
			var value = this.actual;

			expect(value).toHaveTheseAttributes(['title', 'topics', '_id']);
			expect(value.title).toBeString();
			expect(value.topics).toBeArray();
			expect(value._id).toBeId();

			expect(value.topics.length).toBe(2);

			for (var i = 0, length = value.topics.length; i < length; i++) {
				expect(value.topics[i]).toBeTopic();
			}

			return true;
		},
		toBeTopic: function(haveSubtopics) {
			var value = this.actual;

			if (haveSubtopics || value.subtopics) {
				expect(value).toHaveTheseAttributes(['title', 'content', 'tags', 'subtopics', '_id']);
			} else  {
				expect(value).toHaveTheseAttributes(['title', 'content', 'tags', '_id']);
			}

			expect(value.title).toBeString();
			expect(value.content).toBeString();
			expect(value.tags).toBeArray();
			for (var i = 0, length = value.tags.length; i < length; i++) {
				expect(value.tags[i]).toBeString();
			}

			if (haveSubtopics || value.subtopics) {
				expect(value.subtopics).toBeArray();
				for (var j = 0, jlength = value.subtopics.length; j < jlength; j++) {
					expect(value.subtopics[j]).toBeTopic();
				}
			}

			return true;
		},
		toBeAvatar: function() {
			var value = this.actual;

			expect(value).toHaveTheseAttributes(['path', 'size', 'type', '_id', 'created']);
			expect(value.path).toBeNotEmptyString();
			if(value.user) {
				expect(value.user).toBeId();	
			}
			expect(value.size).toBeNumber();
			expect(value.type).toBeImageType();
			expect(value._id).toBeId();
			expect(value.created).toBeTimestamp();

			return true;
		},
		toBeCountries: function() {
			var value = this.actual;

			for (var i = 0, length = value.length; i < length; i++) {
				expect(value[i]).toBeCountry();
			}

			return true;
		},
		toBeCountry: function() {
			var value = this.actual;

			expect(value).toHaveTheseAttributes(['_id', 'title']);
			expect(value._id).toBeId();
			expect(value.title).toBeNotEmptyString();

			return true;
		},
		toBeStates: function() {
			var value = this.actual;

			for (var i = 0, length = value.length; i < length; i++) {
				expect(value[i]).toBeState();
			}

			return true;
		},
		toBeState: function() {
			var value = this.actual;

			expect(value).toHaveTheseAttributes(['_id', 'title']);
			expect(value._id).toBeId();
			expect(value.title).toBeNotEmptyString();

			return true;
		},
		toBeCities: function() {
			var value = this.actual;

			for (var i = 0, length = value.length; i < length; i++) {
				expect(value[i]).toBeCity();
			}

			return true;
		},
		toBeCity: function() {
			var value = this.actual;

			expect(value).toHaveTheseAttributes(['_id', 'title']);
			expect(value._id).toBeId();
			expect(value.title).toBeNotEmptyString();

			return true;
		},
		toBeRegions: function() {
			var value = this.actual;

			for (var i = 0, length = value.length; i < length; i++) {
				expect(value[i]).toBeRegion();
			}

			return true;
		},
		toBeRegion: function() {
			var value = this.actual;

			expect(value).toHaveTheseAttributes(['_id', 'title']);
			expect(value._id).toBeId();
			expect(value.title).toBeNotEmptyString();

			return true;
		},
		toBeAddress: function() {
			var value = this.actual;

			
			if (value.city) {
				expect(value.city).toBeNotEmptyString();
			}
			if (value.number) {
				expect(value.number).toBeNotEmptyString();
			}
			if (value.street) {
				expect(value.street).toBeNotEmptyString();
			}
			if (value.zipCode) {
				expect(value.zipCode).toBeNotEmptyString();
			}

			return true;
		},
		toBeUnpopulatedAddress: function() {
			var value = this.actual;

			if (value.city) {
				expect(value.city).toBeId();
			}
			if (value.country) {
				expect(value.country).toBeId();
			}
			if (value.location) {
				expect(value.location).toBeArray();
			}
			if (value.number) {
				expect(value.number).toBeNotEmptyString();
			}
			if (value.region) {
				expect(value.region).toBeId();
			}
			if (value.state) {
				expect(value.state).toBeId();
			}
			if (value.street) {
				expect(value.street).toBeNotEmptyString();
			}
			if (value.zipCode) {
				expect(value.zipCode).toBeNotEmptyString();
			}

			return true;
		},
		toBeName: function() {
			var value = this.actual;

			if (value.firstname) {
				expect(value.firstname).toBeNotEmptyString();
			}
			if (value.lastname) {
				expect(value.lastname).toBeNotEmptyString();
			}

			return true;
		},
		toBeVenues: function() {
			var value = this.actual;

			for (var i = 0, length = value.length; i < length; i++) {
				expect(value[i]).toBeVenue();
			}

			return true;
		},
		toBeVenue: function() {
			var value = this.actual;
			expect(value).toHaveTheseAttributes(['_id', 'canonicalTitle', 'title', 'campaigns', 'categories', 'address']);
			expect(value._id).toBeId();
			expect(value.canonicalTitle).toBeCanonical();
			if (value.description) {
				expect(value.description).toBeString();
				expect(value.description).toHaveMaxLengthOf(300);
			}
			if (value.shortDescription) {
				expect(value.shortDescription).toBeString();
				expect(value.shortDescription).toHaveMaxLengthOf(35);
			}
			expect(value.title).toBeNotEmptyString();
			expect(value.campaigns).toBeCampaigns();
			expect(value.categories).toBeCategories();
			expect(value.address).toBeAddress();

			return true;
		},
		toBeLightVenues: function() {
			var value = this.actual;

			for (var i = 0, length = value.length; i < length; i++) {
				expect(value[i]).toBeLightVenue();
			}

			return true;
		},
		toBeLightVenue: function() {
			var value = this.actual;
			expect(value).toHaveTheseAttributes(['_id', 'canonicalTitle', 'description', 'title', 'categories', 'address']);
			expect(value._id).toBeId();
			expect(value.canonicalTitle).toBeCanonical();
			if (value.description) {
				expect(value.description).toBeString();
			}
			expect(value.title).toBeNotEmptyString();
			expect(value.categories).toBeCategories();
			expect(value.address).toBeAddress();

			return true;
		},
		toBeCategories: function() {
			var value = this.actual;

			for (var i = 0, length = value.length; i < length; i++) {
				expect(value[i]).toBeCategory();
			}

			return true;
		},
		toBePerformance: function() {
			var value = this.actual;

			for (var i = 0, length = value.length; i < length; i++) {
				expect(value[i].groupBy).toHaveTheseAttributes(['_id', 'points', 'count']);
				expect(value[i].groupBy.venue).toBeId();
				expect(value[i].groupBy.year).toBeNumber();
				if(value[i].groupBy.month) {
					expect(value[i].groupBy.month).toBeNumber();	
				}
				if(value[i].groupBy.day) {
					expect(value[i].groupBy.day).toBeNumber();
				}
				expect(value[i].points).toBeNumber();
				expect(value[i].count).toBeNumber();
			}

			return true;
		},
		toBeCategory: function() {
			var value = this.actual;

			expect(value).toHaveTheseAttributes(['_id', 'title', 'canonicalTitle', 'description']);
			expect(value._id).toBeId();
			expect(value.title).toBeNotEmptyString();
			expect(value.canonicalTitle).toBeCanonical();
			expect(value.description).toBeNotEmptyString();

			return true;
		},
		toBeCount: function() {
			var value = this.actual;

			expect(value).toHaveTheseAttributes(['count']);
			expect(value.count).toBeNumber();

			return true;
		},
		toBePoints: function() {
			var value = this.actual;
			expect(value).toHaveTheseAttributes(['points']);
			expect(value.points).toBeNumber();

			return true;
		},
		toBeCampaigns: function() {
			var value = this.actual;

			for (var i = 0, length = value.length; i < length; i++) {
				expect(value[i]).toBeCampaign();
			}

			return true;
		},
		toBeCampaign: function() {
			var value = this.actual;

			expect(value).toHaveTheseAttributes(['_id', 'canonicalTitle', 'checkinPoints', 'description', 'pointsPerCashUnit', 'start', 'title', 'rewards']);
			expect(value._id).toBeId();
			expect(value.canonicalTitle).toBeCanonical();
			expect(value.checkinPoints).toBeNumber();
			expect(value.description).toBeNotEmptyString();
			expect(value.pointsPerCashUnit).toBeNumber();
			expect(value.start).toBeTimestamp();
			if (value.end) {
				expect(value.end).toBeTimestamp();
			}
			expect(value.title).toBeNotEmptyString();
			expect(value.rewards).toBeRewards();

			return true;
		},
		toBeUserCampaign: function() {
			var value = this.actual;

			expect(value).toHaveTheseAttributes(['_id', 'canonicalTitle', 'checkinPoints', 'description', 'pointsPerCashUnit', 'start', 'title', 'rewards']);
			expect(value._id).toBeId();
			expect(value.canonicalTitle).toBeCanonical();
			expect(value.checkinPoints).toBeNumber();
			expect(value.description).toBeNotEmptyString();
			expect(value.pointsPerCashUnit).toBeNumber();
			expect(value.start).toBeTimestamp();
			if (value.end) {
				expect(value.end).toBeTimestamp();
			}
			expect(value.title).toBeNotEmptyString();
			expect(value.rewards).toBeRewards();

			return true;
		},
		toBeRewards: function() {
			var value = this.actual;

			for (var i = 0, length = value.length; i < length; i++) {
				expect(value[i]).toBeReward();
			}

			return true;
		},
		toBeReward: function() {
			var value = this.actual;

			expect(value).toHaveTheseAttributes(['_id', 'canonicalTitle', 'points', 'description', 'quantity', 'title']);
			expect(value._id).toBeId();
			expect(value.canonicalTitle).toBeCanonical();
			expect(value.points).toBeNumber();
			expect(value.description).toBeNotEmptyString();
			expect(value.quantity).toBeNumber();
			expect(value.title).toBeNotEmptyString();

			return true;
		},
		toBeRedemptionReward: function() {
			var value = this.actual;

			expect(value).toHaveTheseAttributes([ 'canonicalTitle', 'points', 'description', 'quantity', 'title']);
			expect(value.canonicalTitle).toBeCanonical();
			expect(value.points).toBeNumber();
			expect(value.description).toBeNotEmptyString();
			expect(value.quantity).toBeNumber();
			expect(value.title).toBeNotEmptyString();

			return true;
		},
		toBeUserCampaignPoints: function() {
			var value = this.actual;

			for (var i = 0, length = value.length; i < length; i++) {
				expect(value[i]).toBeUserCampaignPoint();
			}

			return true;
		},
		toBeUserCampaignPoint: function() {
			var value = this.actual;

			expect(value).toHaveTheseAttributes(['_id', 'campaign', 'points', 'venues']);
			expect(value._id).toBeId();
			expect(value.campaign).toBeCampaign();
			expect(value.points).toBeNumber();
			expect(value.venues).toBeLightVenues();

			return true;
		},
		toBeUserStats: function() {
			var value = this.actual;

			expect(value).toHaveTheseAttributes(['totalPoints']);
			expect(value.totalPoints).toBeNumber();

			return true;
		},
		toBeVenueRedemptions: function() {
			var value = this.actual;

			for (var i = 0, length = value.length; i < length; i++) {
				expect(value[i]).toBeVenueRedemption();
			}

			return true;
		},
		toBeVenueRedemption: function() {
			var value = this.actual;

			expect(value).toHaveTheseAttributes(['_id', 'user', 'status', 'campaign', 'venue', 'location', 'reward']);
			expect(value._id).toBeId();
			expect(value.user).toBeUser();
			expect(value.status).toBeNotEmptyString();
			expect(value.campaign).toBeCampaign();
			expect(value.venue).toBeNotEmptyString();
			expect(value.location).toBeArray();
			expect(value.reward).toBeReward();

			return true;
		},
		toBeDistanceSortedVenues: function(location) {
			var value = this.actual;
			var distance, lastDistance;
			for(var i = 0, length = value.length; i < length; i++) {
				distance = findDistance(value[i].address.location[0], value[i].address.location[1], location.lon, location.lat);
				if(!lastDistance || lastDistance < distance) {
					lastDistance = distance;
				} else {
					exit();
					break;
				}
			}

			function findDistance(lon1, lat1, lon2, lat2) {
				var R = 6371; // Radius of the earth in km
				var dLat = deg2rad(lat2-lat1);  // deg2rad below
				var dLon = deg2rad(lon2-lon1);
				var a =
				Math.sin(dLat/2) * Math.sin(dLat/2) +
				Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
				Math.sin(dLon/2) * Math.sin(dLon/2);
				var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
				var d = R * c * 1000; // Distance in m
				return d;
			}

			function deg2rad(deg) {
				return deg * (Math.PI/180);
			}

			function exit() {
				return false;
			}
			return true;
		}
	};


	this.addMatchers(customMatchers);
});