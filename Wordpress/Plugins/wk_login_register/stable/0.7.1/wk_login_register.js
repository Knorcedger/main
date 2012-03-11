/**
 * @author knorcedger
 */

jQuery.validator.addMethod("englishlettersonly", function(value, element) {
	return this.optional(element) || /^[a-z, ,0-9,!,@,#,$,%,^,&,*,(,),_,-,=,+]+$/i.test(value);
}, "Δεν επιτρέπονται ελληνικοί χαρακτήρες!");

jQuery(document).ready(function(){
	
	jQuery().ready(function() {
		jQuery("#registerform").validate({
			rules: {
				username: {
					required: true,
					minlength: 4,
					englishlettersonly: true
				},
				email: {
					required: true,
					email: true
				},
				password: {
					required: true,
					minlength: 4
				}
			},
			messages: {
				username: {
					required: "Πρέπει να συμπληρώσετε ένα όνομα.",
					minlength: jQuery.format("Τουλάχιστον {0} χαρακτήρες απαιτούνται!")
				},
				email: {
					required: "Απαιτείται ένα έγκυρο email.",
					email: "Απαιτείται ένα έγκυρο email."
				},
				password: {
					required: "Πρέπει να συμπληρώσετε τον επιθυμητό κωδικό.",
					minlength: jQuery.format("Τουλάχιστον {0} χαρακτήρες απαιτούνται!")
				}
			}
		})
	})
});

