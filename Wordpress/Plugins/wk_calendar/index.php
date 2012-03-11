<?php
/* 
 Plugin Name: wk_calendar
 Plugin URI: http://desquared.com
 Description: The ical calendar
 Version: 0.4.1
 Author: Achilleas Tsoumitas
 Author URI: http://knorcedger.com
 */


/**
 * The ical calendar
 * 
 * @param int $start The month we want to start. 0 is the current month
 * @param int $end The month we want to end.
 */
function wk_calendar($start, $end) {	
	
	//πέρασε ολους τους μήνες που θέλουμε να εμφανίσουμε
	for($q = $start; $q < $end+1; $q++){
		global $wpdb;
		//αν q<0 πρέπει να πάμε τόσους μήνες πίσω από τον τωρινό μήνα
		if($q < 0){
			//check αν πρέπει να πάμε ένα έτος πίσω (το q θα είναι αρνητικό)
			if(date('n') + $q < 1){
				$search_year = date('y')-1;
				$search_month = 13 + $q;
			}else{
				$search_year = date('y');
				$search_month = date('n')+$q;
			}
		}elseif($q == 0){
			$search_year = date('y');
			$search_month = date('n');
		}elseif($q > 0){
			if(date('n') + $q > 12){
				$search_year = date('y')+1;
				$search_month = date('n') + $q - 12;
			}else{
				$search_year = date('y');
				$search_month = date('n')+$q;
			}
		}
		//echo $search_year.$search_month;
		
		?>
	
		<?php 
		$today = date('j');
		//curmonth is used to display today class only in the current month
		if($q == 0){
			$curmonth = 1;
		}else{
			$curmonth = 0;
		}
		
		if($q == 0){
			$month_days = date('t');
		}else{
			$month_days = date('t', mktime(0, 0, 0, $search_month, date('d'), $search_year));
		}
		
		if($q == 0){
			$today_day = date('N');
			$first_day = $today_day - ($today-1);
			//use this to find the first day
			$i = 1;
			while ($first_day < 1){
				$first_day = ($today_day+7*$i) - ($today-1);
				$i++;
			}
		}else{
			$first_day = date('N', mktime(0, 0, 0, $search_month, 1, $search_year));
		}
		?>
		<!--script src="/wp-content/plugins/wk_calendar/js/jquery-1.3.min.js" type="text/javascript"> </script-->
		<div class="ical <?php echo 'y'.$search_year.'m'.$search_month; ?>">
			<table cellspacing="0">
				<thead>
					<tr>
						<th>Δευ</th><th>Τρι</th><th>Τετ</th>
						<th>Πεμ</th><th>Παρ</th><th>Σαβ</th>
						<th>Κυρ</th>
					</tr>
				</thead>
				<tbody>
				<?php
					//check if we need a sixth line
					if(($first_day > 5 && $month_days == 31) || ($first_day == 7 && $month_days > 29)){
						$lines = 6;
					}else{
						$lines = 5;
					}
					$colspan = 0;
					for($i = 0; $i < $lines; $i++){
						echo '<tr>'."\n";
						for($j = 0; $j < 7; $j++){
							//display colspan for the empty boxes at the start
							if($i == 0 && $j == 0 && $first_day != 1){
								//td for the first empty boxes
								$colspan = $first_day-1;
								$j = $colspan-1;
								?>
								<td class="padding" colspan="<?php echo $colspan; ?>"></td>
							<?php
							//display the colspan at the end
							}elseif($i*7+$j-$colspan == $month_days){
								$colspan = 7-$j;
								?>
								<td class="padding" colspan="<?php echo $colspan; ?>"></td>
								<?php
								break;
							}else{
								$val = $i*7+$j-($colspan-1);
							?>
								<td <?php if($val == $today && $curmonth == 1){echo ' class="today d'.$val.'"';} echo ' class="d'.$val.'"'; ?>> <?php echo $val; ?></td>
							<?php
							}
						}
						echo '</tr>'."\n";
					}
				?>
				</tbody>
				<tfoot>
					<th>Δευ</th><th>Τρι</th><th>Τετ</th>
					<th>Πεμ</th><th>Παρ</th><th>Σαβ</th>
					<th>Κυρ</th>
				</tfoot>
			</table>
		</div>
	<?php 
	}
}


/**
 * This function is used to add events on the calendar
 * 
 * @param int $year The year that the event will be held
 * @param int $month The month that the event will be held
 * @param int $day The day that the event will be held
 * @param string $title The title of the event
 * @param string $description The description of the event
 * 
 * @example wk_calendar_add_event("09", "10", "23", "Αυτός είναι ο τίτλος", "Αυτό είναι το κείμενο");
 */
function wk_calendar_add_event($year, $month, $day, $title, $description){
?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			<?php 
			//remove the newline chars because they create problems
			$description = str_replace("\n", "", $description);
			$description = str_replace("\r", "", $description);
			?>	
			var item = $(".y<?php echo $year; ?>m<?php echo $month; ?> td.d<?php echo $day; ?> ");
			var description = '<?php echo htmlspecialchars($description); ?>';
			//check if theres already an event on that date
			if(item.hasClass("date_has_event")){
				if(description != ''){
					var value = '<li><span class="title"><?php echo addslashes($title); ?></span><span class="desc"><?php echo addslashes($description); ?></span></li>';
				}else{
					var value = '<li><span class="title"><?php echo addslashes($title); ?></span></li>';
				}
				$(value).appendTo(".y<?php echo $year; ?>m<?php echo $month; ?> td.d<?php echo $day; ?> div.events ul");
			}else{
				
				item.addClass("date_has_event");
				
				//check which data input we have (not empty)
				if(description != ''){
					var value = '<div class="events"><ul><li><span class="title"><?php echo addslashes($title); ?></span><span class="desc"><?php echo addslashes($description); ?></span></li></ul></div>';
				}else{
					var value = '<div class="events"><ul><li><span class="title"><?php echo addslashes($title); ?></span></li></ul></div>';
				}
				$(value).appendTo(".y<?php echo $year; ?>m<?php echo $month; ?> td.d<?php echo $day; ?>");
			}
			
		});
	</script>
<?php
}

if (!is_admin()) {
	wp_enqueue_style("wk_calendar_css", "/wp-content/plugins/wk_calendar/css/master.css");
	//wp_enqueue_script('jquery');
	wp_enqueue_script('wk_calendar', plugins_url('wk_calendar/js/coda.js'), array('jquery'), '1.0', true);
}
?>
