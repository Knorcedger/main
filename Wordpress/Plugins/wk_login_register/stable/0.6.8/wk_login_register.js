/**
 * @author knorcedger
 */

<script type="text/javascript">
jQuery(document).ready(function(){
	
	jQuery().ready(function() {
		jQuery("#registerform").validate({
			rules: {
				username: {
					required: true,
					minlength: 4
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
</script>
