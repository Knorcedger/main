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
		
</div>
<div class="dates-display" style="display:none;">
	<div class="all-dates">
		<div class="a-date headers">
			<div class="a-date headers">
				<span class="title-departure">Αναχώρηση</span><span class="title-return">Επιστροφή</span><span class="title-seats">Θέσεις</span><span class="title-sold">Πουλήθηκαν</span><span class="title-type">Είδος</span><span class="title-on-request">On request</span><span class="title-closed">Closed</span><span class="title-flight">Πτήση Αναχ.</span><span class="title-return-flight">Πτήση Επισ.</span>
			</div>
		</div>
	</div>
	<a href="javascript:void(0);" class="button add-date">Προσθήκη</a>
	<a href="javascript:void(0);" class="button editdates">Επεξεργασία</a>
</div>


<script type="text/javascript">
	jQuery(document).ready(function($) {
		
		
		<?php
		//check if its an edit, load the different js first
		if($dates_num != ''){
		?>
			recreate_dates_by_db();
		<?php
		}
		?>
	
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
			//add titles again
			$('<div class="a-date headers"><span class="title-departure">Αναχώρηση</span><span class="title-return">Επιστροφή</span><span class="title-seats">Θέσεις</span><span class="title-sold">Πουλήθηκαν</span><span class="title-type">Είδος</span><span class="title-on-request">On request</span><span class="title-closed">Closed</span><span class="title-flight">Πτήση Αναχ.</span><span class="title-return-flight">Πτήση Επισ.</span></div>').appendTo(".all-dates");
		});
		
		$(".add-date").click(function(){
			add_date();
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
				var dates = main_date_loop(d.getFullYear());
			}else{
				//2 loops, one for each year
				temp = date_end_month
				temp2 = date_end_day;
				date_end_month = 11;
				date_end_day = 31;
				var dates1 = main_date_loop(d.getFullYear());
				//second loop
				date_start_day = 1;
				date_start_month = 0;
				date_end_month = temp;
				date_end_day = temp2;
				the_year = d.getFullYear()+1;
				//if we go to a second year, dates should start from where they ended in the previous year
				var dates2 = main_date_loop(the_year, dates1);
				var dates = dates1 + dates2;
			}
			
			
			//add the hidden field dates_num, date_monday, date_tuesday... they include 0 or 1 to indicate the checkbox, to recreate the dates by js
			$('<input type="hidden" size="3" value="'+dates+'" id="dates_num" name="dates_num"></input>').appendTo(".all-dates");
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
			
			//the action to remove a date
			$("span.remove-date").click(function(){
				$(this).parent().remove();
			});
			
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
		
		function find_travel_data(date_id){
			//the data, if object_id != '', its an edit
			$.post('/wp-content/plugins/wk_content_types/custom/find_travel_data.php', {object_id: '<?php echo $_GET["post"]; ?>', date_id: date_id},
				function(data){
					
					<?php
					//first if, to check if we are on edit page, because only then we have data
					if($_GET["post"] != ''){
					?>
					//recover data only if we have data and (we use a different date_start and dates_num is not different)
					//the last two are used to prevent fetching data from db when we want to enter new data
						if(data.date != '' && $("#date_start").val() == '<?php echo get_post_meta($_GET["post"], "date_start", true); ?>' && $("#dates_num").val() == '<?php echo get_post_meta($_GET["post"], "dates_num", true); ?>'){
							$("#date"+date_id).val(data.date);
							$("#date_seats"+date_id).val(data.seats);
							$("#date_return"+date_id).val(data.date_return);
							$("#date_seats_sold"+date_id).val(data.seats_sold);
						
							if(data.type == 'allotment'){
								$("#date_type"+date_id).children("option").attr('selected', 'true');
								//alert('yes');
							}else if(data.type == 'commitment'){
						
							}
							$("#date_type"+date_id).val(data.type);
							if(data.on_request == '1'){
								$("#date_on_request"+date_id).attr('checked', 'yes');
							}
							if(data.closed == '1'){
								$("#date_closed"+date_id).attr('checked', 'yes');
							}
							$("#date_transport"+date_id).val(data.transport);
							$("#date_transport_return"+date_id).val(data.transport_return);
						}
					<?php
					}
					?>
					var all_transport_departures = data.all_transport_departures.split('|');
					$("#date_transport"+date_id).autocomplete(all_transport_departures, {matchContains: true});
					var all_transport_returns = data.all_transport_returns.split('|');
					$("#date_transport_return"+date_id).autocomplete(all_transport_returns, {matchContains: true});
				}, "json"
			);
		}
		
		function recreate_dates_by_db(){
			$(".dates-fun").hide();
			$(".dates-display").css("display", "block");
			<?php
			$object_id = $_GET["post"];
			$dates_num = get_post_meta($object_id, 'dates_num', true);
			//save the old dates_num because we need to run thorught the deleted values too to be able to save all edit data
			?>
			var dates_num = "<?php echo $dates_num; ?>";

			<?php
			for($i = 0; $i<$dates_num; $i++){
				$date = get_post_meta($object_id, 'date'.$i, true);
				if($date != ''){
					$date_return = get_post_meta($object_id, 'date_return'.$i, true);
					$date_return = get_post_meta($object_id, 'date_return'.$i, true);
					$date_return = get_post_meta($object_id, 'date_return'.$i, true);
					$date_return = get_post_meta($object_id, 'date_return'.$i, true);
					$date_return = get_post_meta($object_id, 'date_return'.$i, true);
					$date_return = get_post_meta($object_id, 'date_return'.$i, true);
			?>
					var date_id = "<?php echo $i; ?>";

					var thediv = '<div class="a-date"><span class="a-day"><input type="text" size="7" value="<?php echo $date; ?>" readonly="true" id="date'+date_id+'" name="date'+date_id+'"></input></span><span class="column-return"><input type="text" size="7" value="<?php echo $date_return; ?>" id="date_return'+date_id+'" name="date_return'+date_id+'"></input></span><span class="column-seats"><input type="text" size="3" value="" id="date_seats'+date_id+'" name="date_seats'+date_id+'"></input></span><span class="column-seats-sold"><input type="text" size="3" value="" id="date_seats_sold'+date_id+'" name="date_seats_sold'+date_id+'"></input></span><span class="column-type"><SELECT id="date_type'+date_id+'" NAME="date_type'+date_id+'"><option value="allotment" >Allotment</option><option value="commitment" >Commitment</option></SELECT></span><span class="column-on-request"><input type="checkbox" id="date_on_request'+date_id+'" name="date_on_request'+date_id+'" value="1"></input></span><span class="column-closed"><input type="checkbox" id="date_closed'+date_id+'" name="date_closed'+date_id+'" value="1"></input></span><span class="column-transport"><input type="text" size="10" value="" id="date_transport'+date_id+'" name="date_transport'+date_id+'"></input></span><span class="column-transport-return"><input type="text" size="10" value="" id="date_transport_return'+date_id+'" name="date_transport_return'+date_id+'"></input></span><span class="remove-date button">Remove</span></div>';
					//alert(thediv);
					$(thediv).appendTo(".all-dates");
					var data = find_travel_data(date_id);
			<?php
				}
			}
			?>
			//add the hidden field dates_num, date_monday, date_tuesday... they include 0 or 1 to indicate the checkbox, to recreate the dates by js
			//dates_num = date_id +1 because date_id holds the last date_id that exists and new ones should be added after that number
			//to avoid adding many empty values
			var temp = parseInt(date_id)+1
			$('<input type="hidden" size="3" value="'+temp+'" id="dates_num" name="dates_num"></input>').appendTo(".all-dates");
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
			
			//the action to remove a date
			$("span.remove-date").click(function(){
				$(this).parent().remove();
			});
			
		}
		
		function main_date_loop(the_year, date_id_start){
			//alert(all);
			//alert(date_start_month+"  "+date_end_month);
			//count the number of dates
			
			//check if we run throught a second year, then date_id_start is not 0
			if(date_id_start === undefined){
				var date_id = 0;
			}else{
				var date_id = date_id_start;
			}

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
				var temp = the_year.toString();
				var cut_year = temp.substr(2,2);
				//alert(i);
				//alert('jstart'+jstart);
				//loop the days
				for(j = jstart; j <= days_num; j++){
					//alert(j);
					var l = findDay(the_year, i, j);
					//alert('l='+l);
					var real_month = i+1;
					//check what day it is
					day_txt = '';
					if(monday == 1 && l == 1){
						day_txt = 'Δευ';
					}else if(tuesday == 1 && l == 2){
						day_txt = 'Τρι';
					}else if(wednesday == 1 && l == 3){
						day_txt = 'Τετ';
					}else if(thursday == 1 && l == 4){
						day_txt = 'Πεμ';
					}else if(friday == 1 && l == 5){
						day_txt = 'Παρ';
					}else if(saturday == 1 && l == 6){
						day_txt = 'Σαβ';
					}else if(sunday == 1 && l == 0){
						day_txt = 'Κυρ';
					}
					//if we found a day, display the fields
					if(day_txt != ''){
						//calling this function is needed for the autocomplete fields
						var data = find_travel_data(date_id);
						var thediv = '<div class="a-date"><span class="a-day"><input type="text" size="7" readonly="true" value="'+j+'/'+real_month+'/'+cut_year+'" id="date'+date_id+'" name="date'+date_id+'"></input></span><span class="column-return"><input type="text" size="7" value="" id="date_return'+date_id+'" name="date_return'+date_id+'"></input></span><span class="column-seats"><input type="text" size="3" value="" id="date_seats'+date_id+'" name="date_seats'+date_id+'"></input></span><span class="column-seats-sold"><input type="text" size="3" value="" id="date_seats_sold'+date_id+'" name="date_seats_sold'+date_id+'"></input></span><span class="column-type"><SELECT id="date_type'+date_id+'" NAME="date_type'+date_id+'"><option value="allotment" >Allotment</option><option value="commitment" >Commitment</option></SELECT></span><span class="column-on-request"><input type="checkbox" id="date_on_request'+date_id+'" name="date_on_request'+date_id+'" value="1"></input></span><span class="column-closed"><input type="checkbox" id="date_closed'+date_id+'" name="date_closed'+date_id+'" value="1"></input></span><span class="column-transport"><input type="text" size="10" value="" id="date_transport'+date_id+'" name="date_transport'+date_id+'"></input></span><span class="column-transport-return"><input type="text" size="10" value="" id="date_transport_return'+date_id+'" name="date_transport_return'+date_id+'"></input></span><span class="remove-date button">Remove</span></div>';
						//var thediv = '<div class="a-date"><span class="a-day">'+day_txt+' <input type="text" size="3" value="'+j+'/'+real_month+'" id="date'+date_id+'" name="date'+date_id+'"></input></span><span class="column-return"><input type="text" size="3" value="" id="date_return'+date_id+'" name="date_return'+date_id+'"></input></span><span class="column-seats"><input type="text" size="3" value="" id="date_seats'+date_id+'" name="date_seats'+date_id+'"></input></span><span class="column-seats-sold"><input type="text" size="3" value="" id="date_seats_sold'+date_id+'" name="date_seats_sold'+date_id+'"></input></span><span class="column-type"><SELECT id="date_type'+date_id+'" NAME="date_type'+date_id+'"><option value="allotment" >Allotment</option><option value="commitment" >Commitment</option></SELECT></span><span class="column-on-request"><input type="checkbox" id="date_on_request'+date_id+'" name="date_on_request'+date_id+'" value="1"></input></span><span class="column-closed"><input type="checkbox" id="date_closed'+date_id+'" name="date_closed'+date_id+'" value="1"></input></span><span class="column-transport"><input type="text" size="10" value="" id="date_transport'+date_id+'" name="date_transport'+date_id+'"></input></span><span class="column-transport-return"><input type="text" size="10" value="" id="date_transport_return'+date_id+'" name="date_transport_return'+date_id+'"></input></span><span class="remove-date button">Remove</span></div>';
						//alert(thediv);
						$(thediv).appendTo(".all-dates");
						date_id++;
					}
					//ready to search again
					day_txt = '';
				}
			}
			//return the date_id so that we can calculate the dates_num (we may need to add 2 date_id if we change year
			return date_id;
			
		}
		
		function add_date(){
			var dates_num = $("#dates_num").val();
			//make it a number
			dates_num = parseInt(dates_num);
			var date_id = dates_num
			var temp = dates_num+1;
			$("#dates_num").val(temp);
			//alert(dates_num);
			var data = find_travel_data(date_id);
			var thediv = '<div class="a-date"><span class="a-day"><input type="text" size="3" value="" id="date'+date_id+'" name="date'+date_id+'"></input></span><span class="column-return"><input type="text" size="3" value="" id="date_return'+date_id+'" name="date_return'+date_id+'"></input></span><span class="column-seats"><input type="text" size="3" value="" id="date_seats'+date_id+'" name="date_seats'+date_id+'"></input></span><span class="column-seats-sold"><input type="text" size="3" value="" id="date_seats_sold'+date_id+'" name="date_seats_sold'+date_id+'"></input></span><span class="column-type"><SELECT id="date_type'+date_id+'" NAME="date_type'+date_id+'"><option value="allotment" >Allotment</option><option value="commitment" >Commitment</option></SELECT></span><span class="column-on-request"><input type="checkbox" id="date_on_request'+date_id+'" name="date_on_request'+date_id+'" value="1"></input></span><span class="column-closed"><input type="checkbox" id="date_closed'+date_id+'" name="date_closed'+date_id+'" value="1"></input></span><span class="column-transport"><input type="text" size="10" value="" id="date_transport'+date_id+'" name="date_transport'+date_id+'"></input></span><span class="column-transport-return"><input type="text" size="10" value="" id="date_transport_return'+date_id+'" name="date_transport_return'+date_id+'"></input></span><span class="remove-date button">Remove</span></div>';
			$(thediv).appendTo(".all-dates");
			
			//the action to remove a date
			$("span.remove-date").click(function(){
				$(this).parent().remove();
			});
			
		}
		
	})
</script>
