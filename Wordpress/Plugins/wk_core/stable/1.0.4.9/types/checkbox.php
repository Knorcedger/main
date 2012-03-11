<?php
function wk_core_checkbox($display, $name, $translation, $default, $myvalues, $object_id = '', $object_type = 'post') {
	
	if($object_type == 'post'){
		if($object_id != '0'){
			$i = 0;
			foreach ($myvalues as $val) {
				$temp = explode('|', $val);
				$values[$i] = get_post_meta($object_id, $temp[1], true);
				$i++;
			}
		}else{
			//for each array (myvalues) val, check if default is 1 or 0
			$temp = explode('~', $default);
			for($i=0;$i<sizeof($myvalues);$i++){
				if($temp[$i] == 1){
					$temp2 = explode('|', $myvalues[$i]);
					$value = $temp2[1];
					$values[$i] = $value;
				}else{
					$values[$i] = '';
				}
			}
		}
	}else{
		//if user display then db value, or leave empty. Dont use the default value
		$user_info = get_userdata($object_id);
		$i = 0;
		foreach ($myvalues as $val) {
			$temp = explode('|', $val);
			$values[$i] = $user_info->$temp[1];
			$i++;
		}
	}

	if($display){ ?>
		<div class="<?php echo $name; ?>">
			<label for="<?php echo $name; ?>"><?php echo $translation; ?></label>
			<ul>
				<?php
				$i = 0;
				foreach ($myvalues as $val) {
					$temp = explode('|', $val);
					$var_name = $temp[0];
					$var_value = $temp[1];
					?>
						<li><input type="checkbox" name="<?php echo $var_value; ?>" value="<?php echo $var_value; ?>" <?php if($var_value == $values[$i]){echo 'checked="yes"';}?> /> <?php echo $var_name; ?></li>
				<?php
					$i++;
				}
				?>
			</ul>
		</div>
		
		<?php
	}else{
		for($i=0;$i<sizeof($myvalues);$i++){
			$temp = explode('|', $myvalues[$i]);
			if($values[$i] == $temp[1]){
				$value = $temp[1];
				echo '<input type="hidden" name="'.$value.'" value="'.$value.'" />';
			}else{
				$value = '';
				echo '<input type="hidden" name="'.$value.'" value="'.$value.'" />';
			}
		}
	}
}
?>
