<?php  
/* 
Plugin Name: wk_contact 
Plugin URI: http://o-some.com 
Description: A contact form
Version: 0.6.1
Author: Achilleas Tsoumitas 
Author URI: http://knorcedger.com 
*/
?>
<?php
/**
 * Displays a contact form in wordpress
 * 
 * @return 
 * @param string $language The language used in the contact form
 * @param string $sendto The address to send this email
 * @param string $from[optional] A field included in email subject to help you understand where the email came from
 * @param int $confirmation_message[optional] Display a default confimation message
 * @param string $redirect[optional] Redirect him somewhere
 * @param int $name[optional] Display field: name
 * @param int $email[optional]	Display field: email
 * @param int $subject[optional] Display field: subject
 * @param int $message[optional] Display field: message
 */
function wk_contact($language, $sendto, $from = '', $confirmation_message = 0, $redirect = '', $name = 1, $email = 1, $subject = 1, $message = 1){

	include_once 'languages/'.$language.'.php';
	
	if($_GET['status'] == 'email_sent' && $confirmation_message){ ?>
		<div class="wk_contact_sent"><?php echo $confirmation_message_txt; ?></div>
	<?php } ?>
		
	<form id="wk_contact_form" action="/wp-content/plugins/wk_contact/send.php" method="POST" accept-charset="utf-8">
		<?php if($name == 1){ ?>
			<label for="name"><?php echo $name_txt; ?></label>
			<p class="name"><input type="text" name="name" id="name" value="" size="30" class="required" /></p>
		<?php } ?>
		
		<?php if($email == 1){ ?>		
			<label for="email"><?php echo $email_txt; ?></label>
			<p class="email"><input type="text" name="email" id="email" value="" size="30" class="required email" /></p>
		<?php } ?>
		
		<?php if($subject == 1){ ?>
			<label for="subject"><?php echo $subject_txt; ?></label>
			<p class="subject"><input type="text" name="subject" id="subject" value="" size="30" class="required" /></p>	
		<?php } ?>
		
		<?php if($message == 1){ ?>
			<label for="message"><?php echo $message_txt; ?></label>
			<p class="message"><textarea type="text" name="message" id="message" value="" cols="50" rows="10" class="required"></textarea></p>
		<?php } ?>
		
		<label for="human"><?php echo $human_txt; ?> <span class="find"><?php find(); ?></span></label>
		<p class="human"><input type="text" name="human" id="human" value="" size="30" class="required" /></p>

		
		<input type="hidden" name="sendto" id="sendto" value="<?php echo $sendto; ?>" />
		<input type="hidden" name="redirect" id="redirect" value="<?php echo $redirect; ?>" />
		<input type="hidden" name="from" id="from" value="<?php echo $from; ?>" />
		<input type="hidden" name="human_result" id="human_result" value="<?php echo result(); ?>" />
				
		<input name="submit" type="submit" id="submit" disabled="disabled" value="<?php echo $send_txt; ?>" />
					
	</form> 
<?php
}

function find(){
	global $i;
	$i = rand(0, 4);
	if($i == 0){
		echo '1+2=';
	}elseif($i == 1){
		echo '1+3=';
	}elseif($i == 2){
		echo '2+2=';
	}elseif($i == 3){
		echo '2+5=';
	}elseif($i == 4){
		echo '3+2=';
	}
}
function result(){
	global $i;
	if($i == 0){
		echo '3';
	}elseif($i == 1){
		echo '4';
	}elseif($i == 2){
		echo '4';
	}elseif($i == 3){
		echo '7';
	}elseif($i == 4){
		echo '5';
	}
}
if (!is_admin()) {
	wp_enqueue_script('wk_contact', '/wp-content/plugins/wk_contact/wk_contact.js', array('jquery'));
}
?>
