/**
 * This directive is for opening an modal. It goes with the angular ui modal.
 *
 * This directive supports the following attributes:
 * id: The directive's id
 * 
 * Events:
 * 'open': This event if for opening the modal. The angular ui modal catches 
 * this event and it opens the modal.
 *
 */
var modal = angular.module('modal', ['eventPublisher']);
	
modal.directive('modal', function(eventPublisher) {

	return {
		restrict: 'E',
		templateUrl: 'views/modal.html',
		replace: true,
		transclude: true,
		link: function(scope, element, attrs) {

			var aid = 'modal';
			scope.modalTitle = attrs.modalTitle;

			scope.$on(aid + '.open', function() {
				element.addClass('open');
				eventPublisher.publish(aid + ".open.success");
			});

			scope.$on(aid + '.close', function() {
				close();
			});

			element.bind('click', function() {
				close();
			});

			function close() {
				element.removeClass('open');
				eventPublisher.publish(aid + ".close.success");
			}

			eventPublisher.publish(aid + ".ready.success");
		}
	};
});