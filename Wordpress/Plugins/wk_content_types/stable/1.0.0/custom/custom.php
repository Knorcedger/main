<div class="dates-fun">
	<?php
	//check if its an edit
	$dates_num = get_post_meta($object_id, 'dates_num', true);
	
	?>
		<label for="date_start">Από (π.χ. 15/6)</label>
		<input type="text" name="date_start" id="date_start" value="<?php echo get_post_meta($object_id, 'date_start', true); ?>" size="5" tabindex="10" />
		<label for="date_end">Έως (π.χ. 21/8)</label>
		<input type="text" name="date_end" id="date_end" value="<?php echo get_post_meta($object_id, 'date_end', true); ?>" size="5" tabindex="11" />
		<label>Μέρα</label>
		<ul>
			<li><input type="checkbox" id="monday" name="monday" <?php $value = get_post_meta($object_id, 'date_monday', true); if($value == 1){echo 'value="1" checked="yes"';}else{echo 'value="0"';}?> /> Δευτέρα</li>
			<li><input type="checkbox" id="tuesday" name="tuesday" <?php $value = get_post_meta($object_id, 'date_tuesday', true); if($value == 1){echo 'value="1" checked="yes"';}else{echo 'value="0"';}?> /> Τρίτη</li>
			<li><input type="checkbox" id="wednesday" name="wednesday" <?php $value = get_post_meta($object_id, 'date_wednesday', true); if($value == 1){echo 'value="1" checked="yes"';}else{echo 'value="0"';}?> /> Τετάρτη</li>
			<li><input type="checkbox" id="thursday" name="thursday" <?php $value = get_post_meta($object_id, 'date_thursday', true); if($value == 1){echo 'value="1" checked="yes"';}else{echo 'value="0"';}?> /> Πέμπτη</li>
			<li><input type="checkbox" id="friday" name="friday" <?php $value = get_post_meta($object_id, 'date_friday', true); if($value == 1){echo 'value="1" checked="yes"';}else{echo 'value="0"';}?> /> Παρασκευή</li>
			<li><input type="checkbox" id="saturday" name="saturday" <?php $value = get_post_meta($object_id, 'date_saturday', true); if($value == 1){echo 'value="1" checked="yes"';}else{echo 'value="0"';}?> /> Σάββατο</li>
			<li><input type="checkbox" id="sunday" name="sunday" <?php $value = get_post_meta($object_id, 'date_sunday', true); if($value == 1){echo 'value="1" checked="yes"';}else{echo 'value="0"';}?> /> Κυριακή</li>
		</ul>
	
		<input type="hidden" name="object_id" value="<?php echo $object_id; ?>" />
		<input type="hidden" name="object_type" value="<?php echo $object_type; ?>" />
		
		<a href="javascript:void(0);" class="button godates">Προβολή</a>
		<?php
		//check if its an edit, load the different js first
		if($dates_num != ''){
			include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/wk_content_types/custom/dates.php';
		?>
			<!--script type="text/javascript" src="/wp-content/plugins/wk_content_types/custom/dates.js"></script-->
		<?php
		}
		?>
</div>
<div class="dates-display" style="display:none;">
	<div class="all-dates"></div>
	<a href="javascript:void(0);" class="button editdates">Επεξεργασία</a>
</div>


<script type="text/javascript">
	jQuery(document).ready(function($) {
	
	
		$(".godates").click(function(){
			show_dates();
		});
		
		
		$(":checkbox").click(function(){
			var prev = $(this).val();
			if(prev == 0){
				$(this).val('1');
			}else{
				$(this).val('0');
			}
		});
		
		$(".editdates").click(function(){
			$(".dates-display").hide();
			$(".dates-fun").show();
			$(".all-dates").empty();
		});
		
		function show_dates(){
			date_start = $("#date_start").val();
			date_end = $("#date_end").val();
			monday = $("#monday").val();
			tuesday = $("#tuesday").val();
			wednesday = $("#wednesday").val();
			thursday = $("#thursday").val();
			friday = $("#friday").val();
			saturday = $("#saturday").val();
			sunday = $("#sunday").val();
			//calculate
			temp = date_start.split("/");
			date_start_day = temp[0];
			date_start_month = temp[1] - 1;
			temp2 = date_end.split("/");
			date_end_day = temp2[0];
			date_end_month = temp2[1] - 1;
			
			
			d = new Date();
			//t = findDay(d.getFullYear(), date_start_month, date_start_day);
			//alert(t);
			//check if we change year
			if(date_start_month <= date_end_month){
				main_date_loop(d.getFullYear());
			}else{
				//2 loops, one for each year
				temp = date_end_month
				temp2 = date_end_day;
				date_end_month = 11;
				date_end_day = 31;
				main_date_loop(d.getFullYear());
				//second loop
				date_start_day = 1;
				date_start_month = 0;
				date_end_month = temp;
				date_end_day = temp2;
				the_year = d.getFullYear()+1;
				main_date_loop(the_year);
			}
			
			//show
			$(".dates-fun").hide();
			$(".dates-display").show();
		}
		
		function daysInMonth(iMonth, iYear){
			return 32 - new Date(iYear, iMonth, 32).getDate();
		}
		
		function findDay(year, month, date){
			return new Date(year, month, date).getDay();
		}
		
		function main_date_loop(the_year){
			//alert(date_start_month+"  "+date_end_month);
			//count the number of dates
			var dates_num = 0;
			//loop the months
			for(i = date_start_month; i <= date_end_month; i++){
				//find the days of this month
				days_num = daysInMonth(i, the_year);
				//find where to start looping for the days
				if(i == date_start_month){
					var jstart = date_start_day;
				}else if(i == date_end_month){
					var jstart = 1;
				}else{
					var jstart = 1;
				}
				//if we only loop one month, or we loop the last month
				if(date_start_month == date_end_month || i == date_end_month){
					var days_num = date_end_day;
				}
				//alert(i);
				//alert('jstart'+jstart);
				//loop the days
				for(j = jstart; j <= days_num; j++){
					//alert(j);
					var l = findDay(the_year, i, j);
					//alert('l='+l);
					var real_month = i+1;
					if(monday == 1 && l == 1){
						var thediv = '<div class="a-date"><span class="a-day">Δευτέρα <input type="text" size="3" value="'+j+'/'+real_month+'" id="date'+dates_num+'" name="date'+dates_num+'"></input></span><input type="text" size="3" value="" id="date_seats'+dates_num+'" name="date_seats'+dates_num+'"></input></div>';
						$(thediv).appendTo(".all-dates");
						dates_num++;
					}else if(tuesday == 1 && l == 2){
						var thediv = '<div class="a-date"><span class="a-day">Τρίτη <input type="text" size="3" value="'+j+'/'+real_month+'" id="date'+dates_num+'" name="date'+dates_num+'"></input></span><input type="text" size="3" value="" id="date_seats'+dates_num+'" name="date_seats'+dates_num+'"></input></div>';
						$(thediv).appendTo(".all-dates");
						dates_num++;
					}else if(wednesday == 1 && l == 3){
						var thediv = '<div class="a-date"><span class="a-day">Τετάρτη <input type="text" size="3" value="'+j+'/'+real_month+'" id="date'+dates_num+'" name="date'+dates_num+'"></input></span><input type="text" size="3" value="" id="date_seats'+dates_num+'" name="date_seats'+dates_num+'"></input></div>';
						$(thediv).appendTo(".all-dates");
						dates_num++;
					}else if(thursday == 1 && l == 4){
						var thediv = '<div class="a-date"><span class="a-day">Πέμπτη <input type="text" size="3" value="'+j+'/'+real_month+'" id="date'+dates_num+'" name="date'+dates_num+'"></input></span><input type="text" size="3" value="" id="date_seats'+dates_num+'" name="date_seats'+dates_num+'"></input></div>';
						$(thediv).appendTo(".all-dates");
						dates_num++;
					}else if(friday == 1 && l == 5){
						var thediv = '<div class="a-date"><span class="a-day">Παρασκευή <input type="text" size="3" value="'+j+'/'+real_month+'" id="date'+dates_num+'" name="date'+dates_num+'"></input></span><input type="text" size="3" value="" id="date_seats'+dates_num+'" name="date_seats'+dates_num+'"></input></div>';
						$(thediv).appendTo(".all-dates");
						dates_num++;
					}else if(saturday == 1 && l == 6){
						var thediv = '<div class="a-date"><span class="a-day">Σάββατο <input type="text" size="3" value="'+j+'/'+real_month+'" id="date'+dates_num+'" name="date'+dates_num+'"></input></span><input type="text" size="3" value="" id="date_seats'+dates_num+'" name="date_seats'+dates_num+'"></input></div>';
						$(thediv).appendTo(".all-dates");
						dates_num++;
					}else if(sunday == 1 && l == 0){
						var thediv = '<div class="a-date"><span class="a-day">Κυριακή <input type="text" size="3" value="'+j+'/'+real_month+'" id="date'+dates_num+'" name="date'+dates_num+'"></input></span><input type="text" size="3" value="" id="date_seats'+dates_num+'" name="date_seats'+dates_num+'"></input></div>';
						$(thediv).appendTo(".all-dates");
						dates_num++;
					}
				}
			}
			//add the hidden field dates_num, date_monday, date_tuesday... they include 0 or 1 to indicate the checkbox, to recreate the dates by js
			$('<input type="hidden" size="3" value="'+dates_num+'" id="dates_num" name="dates_num"></input>').appendTo(".all-dates");
			date_start = $("#date_start").val();
			date_end = $("#date_end").val();
			monday = $("#monday").val();
			tuesday = $("#tuesday").val();
			wednesday = $("#wednesday").val();
			thursday = $("#thursday").val();
			friday = $("#friday").val();
			saturday = $("#saturday").val();
			sunday = $("#sunday").val();
			$('<input type="hidden" size="3" value="'+date_start+'" id="date_start" name="date_start"></input>').appendTo(".all-dates");
			$('<input type="hidden" size="3" value="'+date_end+'" id="date_end" name="date_end"></input>').appendTo(".all-dates");
			$('<input type="hidden" size="3" value="'+monday+'" id="date_monday" name="date_monday"></input>').appendTo(".all-dates");
			$('<input type="hidden" size="3" value="'+tuesday+'" id="date_tuesday" name="date_tuesday"></input>').appendTo(".all-dates");
			$('<input type="hidden" size="3" value="'+wednesday+'" id="date_wednesday" name="date_wednesday"></input>').appendTo(".all-dates");
			$('<input type="hidden" size="3" value="'+thursday+'" id="date_thursday" name="date_thursday"></input>').appendTo(".all-dates");
			$('<input type="hidden" size="3" value="'+friday+'" id="date_monday" name="date_friday"></input>').appendTo(".all-dates");
			$('<input type="hidden" size="3" value="'+saturday+'" id="date_saturday" name="date_saturday"></input>').appendTo(".all-dates");
			$('<input type="hidden" size="3" value="'+sunday+'" id="date_sunday" name="date_sunday"></input>').appendTo(".all-dates");
		}
		
	})
</script>
