<?php
function wk_core_dropdown($display, $name, $translation, $default, $myvalues, $object_id = '', $object_type = 'post') {
	
	if($object_type == 'post'){
		if($object_id != '0'){
			$value = get_post_meta($object_id, $name, true);
		}else{
			$temp = explode('|', $myvalues[$default-1]); //-1 because arrays start by 0
			$value = $temp[1];
		}
	}else{
		//if user display then db value, or leave empty. Dont use the default value
		$user_info = get_userdata($object_id);
		$value = $user_info->$name;
	}
	
	if($display){ ?>
		<p class="<?php echo $name; ?>">
			<label for="<?php echo $name; ?>"><?php echo $translation; ?>: </label>
			<SELECT NAME="<?php echo $name; ?>">
				<?php
				if($myvalues != ''){
					foreach ($myvalues as $val) {
						$temp = explode('|', $val);
						$var_name = $temp[0];
						$var_value = $temp[1];
						?>
						<option value="<?php echo $var_value; ?>" <?php if($var_value == $value){echo 'selected="true"';}?>><?php echo $var_name; ?></option>
						<?php
					}
				}
				?>
			</SELECT>
		</p>
	
	<?php
	}else{
		echo '<input type="hidden" name="'.$name.'" value="'.$value.'" />';
	}
}
?>
