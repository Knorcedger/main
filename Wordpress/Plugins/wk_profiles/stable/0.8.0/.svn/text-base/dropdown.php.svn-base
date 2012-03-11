<?php

function wk_edit_profile_dropdown($name, $translation, $allvalues) {
	global $current_user;
?>
<p class="<?php echo $name; ?>">
	<label for="<?php echo $name; ?>"><?php echo $translation; ?>: </label>
	<SELECT NAME="<?php echo $name; ?>">
		<!--option VALUE="<?php echo $current_user->$name; ?>"><?php echo $current_user->$name; ?></option-->
		<?php
		foreach ($allvalues as $val) {
			$temp = explode('|', $val);
			$var_name = $temp[0];
			$var_value = $temp[1];
			//check if this is the previously selected value
			if($current_user->$name == $var_value){
				echo "<option value=\"$var_value\" selected=\"true\">$var_name</option>";
			}else{
				echo "<option value=\"$var_value\">$var_name</option>";
			}
		}
		?>
	</SELECT>
</p>
<?php
}
?>
