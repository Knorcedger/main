<?php  
/* 
Plugin Name: wk_login_register 
Plugin URI: http://knorcedger.com 
Description: A login/register system
Version: 0.8.1
Author: Achilleas Tsoumitas
Author URI: http://knorcedger.com 
*/
?>
<?php
/**
 * Displays the login form
 * 
 * @example wk_login('gr', 0, 0, '', '/login');
 * 
 * @return 
 * @param string $language
 * @param string $already_loggedin_message[optional]
 * @param string $account_activation[optional]
 * @param string $redirect_success[optional]
 * @param string $redirect_fail[optional]
 */
function wk_login($language, $already_loggedin_message = '1', $account_activation = '0', $redirect_success = '', $redirect_fail = ''){
	
	include 'languages/'.$language.'.php';
	
	global $current_user;
	get_currentuserinfo();
	
	if(!$current_user->ID){ ?>
		<form id="loginform" action="<?php echo get_option('home'); ?>/wp-content/plugins/wk_login_register/login.php" method="post">
			
    		<p class="username">
    			<label for="username"><?php echo $username_txt; ?></label>
				<input type="text" name="username" id="username" value="<?php echo wp_specialchars(stripslashes($current_user->user_login), 1) ?>" size="30" />
			</p>

			<p class="password">
				<label for="password"><?php echo $password_txt; ?></label>
				<input type="password" name="password" id="password" size="30" />
			</p>
			
    		<p class="remember">
    			<label for="remember"><?php echo $remember_txt; ?></label>
				<input name="remember" id="remember" type="checkbox" checked="checked" value="forever" />
			</p>
    		
			<input type="hidden" name="redirect_success" value="<?php echo $redirect_success; ?>" />
            <input type="hidden" name="redirect_fail" value="<?php echo $redirect_fail; ?>" />
            <input type="hidden" name="account_activation" value="<?php echo $account_activation; ?>" />

			<input name="submit" type="submit" id="submit" tabindex="3" value="<?php echo $connect_txt; ?>" />
		</form>
	<?php }else{
		if($already_loggedin_message){
			echo $already_loggedin_message_txt;
		}else{
			//echo nothing
		}
	}
}
/**
 * Displays the register form
 * 
 * @example wk_register('gr', 'author', 1, '0', '', '/register', 'first_name|Όνομα,last_name|Επίθετο,phone|Τηλέφωνο');
 * 
 * @return 
 * @param string $language
 * @param string $role [administrator, editor, author, contributor, subscriber]
 * @param int $email_notification[optional]
 * @param string $account_activation[optional]
 * @param string $redirect_success[optional]
 * @param string $redirect_fail[optional]
 * @param string $additional[optional]
 */
function wk_register($language, $role, $email_notification = 0, $account_activation = '0', $redirect_success = '', $redirect_fail = '', $additional = ''){ ?>

	<?php include 'languages/'.$language.'.php'; ?>
	
	<form id="registerform" action="<?php echo get_option('home'); ?>/wp-content/plugins/wk_login_register/register.php" method="post">
		
		<p class="username">
			<label for="username"><?php echo $username_txt; ?></label>
			<input type="text" name="username" id="username" value="" size="30" tabindex="1" />
		</p>

		<p class="email">
			<label for="email"><?php echo $email_txt; ?></label>
			<input type="text" name="email" id="email" value="" size="30" tabindex="2" />
		</p>

		<p class="password">
			<label for="password"><?php echo $password_txt; ?></label>
			<input type="password" name="password" id="password" value="" size="30" tabindex="3" />
		</p>
		
		<?php
		$fields = explode(',', $additional);
		//k=3 is used for the tabindex, because we already have up to 3
		$k = 3;
		if($additional != ''){
			foreach($fields as $field){
				$k++;
				$temp = explode('|', $field);
				$field_name = $temp[0];
				$field_txt = $temp[1];
			?>
				<p class="<?php echo $field_name; ?>">
					<label for="<?php echo $field_name; ?>"><?php echo $field_txt; ?></label>
					<input type="text" name="<?php echo $field_name; ?>" id="<?php echo $field_name; ?>" value="" size="30" tabindex="<?php echo $k; ?>" />
				</p>
		<?php
			}
		}
		?>	

		<input type="hidden" name="role" value="<?php echo $role; ?>" />
		<input type="hidden" name="email_notification" value="<?php echo $email_notification; ?>" />
		<input type="hidden" name="redirect_success" value="<?php echo $redirect_success; ?>" />
		<input type="hidden" name="redirect_fail" value="<?php echo $redirect_fail; ?>" />
		<input type="hidden" name="account_activation" value="<?php echo $account_activation; ?>" />
		
		<input name="submit" type="submit" id="submit" tabindex="<?php if($additional != ''){echo $k+1;}else{echo '4';} ?>" value="<?php echo $register_txt; ?>" />
	</form>
<?php
}
//load javascripts needed
if (!is_admin()) {
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery.validate.pack', '/wp-content/plugins/wk_login_register/jquery.validate.pack.js');
	wp_enqueue_script('wk_login_register', '/wp-content/plugins/wk_login_register/wk_login_register.js');
}
?>
