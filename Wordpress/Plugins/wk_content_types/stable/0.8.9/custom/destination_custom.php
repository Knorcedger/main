<div class="destinations">

	<ul class="level1">
		<li>
			Επίπεδο 1<input type="text" size="25" value="" id="level1_destination0" name="level1_destination0" readonly="true"></input>
		</li>
		<li style="display:none;">
			Επίπεδο 1<input type="text" size="25" value="" id="level1_destination1" name="level1_destination1" readonly="true"></input>
		</li>
		<li style="display:none;">
			Επίπεδο 1<input type="text" size="25" value="" id="level1_destination2" name="level1_destination2" readonly="true"></input>
		</li>
		<li style="display:none;">
			Επίπεδο 1<input type="text" size="25" value="" id="level1_destination3" name="level1_destination3" readonly="true"></input>
		</li>
		<li style="display:none;">
			Επίπεδο 1<input type="text" size="25" value="" id="level1_destination4" name="level1_destination4" readonly="true"></input>
		</li>
	</ul>

	<ul class="level2">
		<li>
			Επίπεδο 2<input type="text" size="25" value="" id="level2_destination0" name="level2_destination0" readonly="true"></input>
		</li>
		<li style="display:none;">
			Επίπεδο 2<input type="text" size="25" value="" id="level2_destination1" name="level2_destination1" readonly="true"></input>
		</li>
		<li style="display:none;">
			Επίπεδο 2<input type="text" size="25" value="" id="level2_destination2" name="level2_destination2" readonly="true"></input>
		</li>
		<li style="display:none;">
			Επίπεδο 2<input type="text" size="25" value="" id="level2_destination3" name="level2_destination3" readonly="true"></input>
		</li>
		<li style="display:none;">
			Επίπεδο 2<input type="text" size="25" value="" id="level2_destination4" name="level2_destination4" readonly="true"></input>
		</li>
	</ul>	
	
	<ul class="level3">
		<li>
			<input type="text" size="25" value="" id="level3_destination0" name="level3_destination0"></input>
		</li>
		<li style="display:none;">
			<input type="text" size="25" value="" id="level3_destination1" name="level3_destination1"></input>
		</li>
		<li style="display:none;">
			<input type="text" size="25" value="" id="level3_destination2" name="level3_destination2"></input>
		</li>
		<li style="display:none;">
			<input type="text" size="25" value="" id="level3_destination3" name="level3_destination3"></input>
		</li>
		<li style="display:none;">
			<input type="text" size="25" value="" id="level3_destination4" name="level3_destination4"></input>
		</li>
	</ul>
		
		<br />
		<a href="javascript:void(0);" class="button add-destination">Add</a>
		<a href="javascript:void(0);" class="button search-destination" id="allow">Search</a>
		<a href="javascript:void(0);" class="button clear-destination">Clear</a>
		
		<input type="hidden" name="destinations" value="5" />
</div>

<?php
//it find both level 2 and leve3 destinations
$query = "SELECT wposts.post_title
				FROM wp_posts wposts, wp_postmeta wpostmeta, wp_postmeta wpostmeta2
				WHERE wposts.ID = wpostmeta.post_id AND wposts.ID = wpostmeta2.post_id
				AND 
				(
					(wpostmeta.meta_key = 'content_type' AND wpostmeta.meta_value = 'destination')
					AND (wpostmeta2.meta_key = 'level1_destination' AND wpostmeta2.meta_value != '')
				)
				AND wposts.post_status = 'publish' 
				AND wposts.post_type = 'post' 
				ORDER BY wposts.post_date DESC";
?>

<script type="text/javascript" src="/wp-content/plugins/wk_core/types/autocomplete/jquery.autocomplete.pack.js"></script>
<link rel="stylesheet" type="text/css" href="/wp-content/plugins/wk_core/types/autocomplete/jquery.autocomplete.css" media="screen" />
<script type="text/javascript" src="/wp-content/plugins/wk_core/types/autocomplete/jquery.bgiframe.min.js"></script>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		
		//count the level2 results we found by the searches
		var count_results = 0;
		
		<?php
		if($_GET['post'] != ''){
		?>
			load_data();
		<?php
		}
		?>
		
		//Φτιάξε τα autocomplete
		var data = '<?php global $wpdb; $result = $wpdb->get_results($query); foreach ($result as $val){echo $val->post_title . "|";} ?>'.split("|");
		$("#level3_destination0").autocomplete(data, {matchContains: true});
		$("#level3_destination1").autocomplete(data, {matchContains: true});
		$("#level3_destination2").autocomplete(data, {matchContains: true});
		$("#level3_destination3").autocomplete(data, {matchContains: true});
		$("#level3_destination4").autocomplete(data, {matchContains: true});
		
		//Εμφάνισε τα επιπλέον πεδία για τα level3 destinations
		var destination_id_display = 1;
		$(".add-destination").click(function(){
			$("div.destinations ul.level3 li:eq("+destination_id_display+")").show();
			destination_id_display++;
		});
		

		//Στην αναζήτηση...
		$(".search-destination").click(function(){
			//for some reason, everything happens twice, so we stop this with this
			if($(this).attr("id") == 'allow'){
				$(this).attr("id", "disallow");
				//the normal code
				//search for the input destinations
				//start from count_results to not search for previous input again //changed to 0 because level2 destinations can be removed and
				//new destinations will be added in this input
				for(var i=0; i<5; i++){
					var destination_input = $("#level3_destination"+i).val();
					//search only if we have input
					if(destination_input != ''){
						$.post('/wp-content/plugins/wk_content_types/custom/find_destination_data.php', {destination_input: destination_input, field_id: i, post_id: ""},
							function(data){
								//check if this level1 destination is unique
								//unique is used to check if a level2 destination already exists
								var unique = 1;
								for(var k=0; k<5; k++){
									var old = $("#level1_destination"+k).val();
									//...check if this destination exists
									if(old == data.level1_destination){
										unique = 0;
									}
								}
								//if its unique
								if(unique == 1){
									//run through all the level1 fields
									for(var k=0; k<5; k++){
										var old = $("#level1_destination"+k).val();
										//and when u find the first thats empty, add our value and break
										if(old == ''){
											$("#level1_destination"+k).val(data.level1_destination);
											$("div.destinations ul.level1 li:eq("+k+")").show();
											break;
										}
									}
								}
								//check if he entered a level2 or a level3 destination
								if(data.level2_destination != ''){
									//for all the previous level2 destination...
									var limit = parseInt(count_results)+1;
									//unique is used to check if a level2 destination already exists
									var unique = 1;
									for(var j=0; j<limit; j++){
										var old = $("#level2_destination"+j).val();
										//...check if this destination exists
										if(data.level2_destination == old){
											unique = 0;
										}
									}
									if(unique == 1){
										//and display it
										$("#level2_destination"+count_results).val(data.level2_destination);
										$("div.destinations ul.level2 li:eq("+count_results+")").show();
										count_results++;
									}
								}else{
									//add the input as a level 2 destination
									$("#level2_destination"+count_results).val(data.destination_input);
									$("div.destinations ul.level2 li:eq("+count_results+")").show();
									//clear level 3 field
									$("#level3_destination"+data.field_id).val('');
									count_results++;
								}
							}, "json"
						);
					}
				}
			}else{
				$(this).attr("id", "allow");
			}
		});
		
		//load data when on edit page
		function load_data(){
			//for some reason, everything happens twice, so we stop this with this
			if($(".search-destination").attr("id") == 'allow'){
				$(".search-destination").attr("id", "disallow");
				//the normal code
				$.post('/wp-content/plugins/wk_content_types/custom/find_destination_data.php', {destination_input: "", field_id: "", post_id: "<?php echo $_GET['post']; ?>"},
					function(data){
						if(data.level1_destination0 != ''){
							$("#level1_destination0").val(data.level1_destination0);
							$("div.destinations ul.level1 li:eq(0)").show();
						}
						if(data.level1_destination1 != ''){
							$("#level1_destination1").val(data.level1_destination1);
							$("div.destinations ul.level1 li:eq(1)").show();
						}
						if(data.level1_destination2 != ''){
							$("#level1_destination2").val(data.level1_destination2);
							$("div.destinations ul.level1 li:eq(2)").show();
						}
						if(data.level1_destination3 != ''){
							$("#level1_destination3").val(data.level1_destination3);
							$("div.destinations ul.level1 li:eq(3)").show();
						}
						if(data.level1_destination4 != ''){
							$("#level1_destination4").val(data.level1_destination4);
							$("div.destinations ul.level1 li:eq(4)").show();
						}
						if(data.level2_destination0 != ''){
							$("#level2_destination0").val(data.level2_destination0);
							$("div.destinations ul.level2 li:eq(0)").show();
						}
						if(data.level2_destination1 != ''){
							$("#level2_destination1").val(data.level2_destination1);
							$("div.destinations ul.level2 li:eq(1)").show();
						}
						if(data.level2_destination2 != ''){
							$("#level2_destination2").val(data.level2_destination2);
							$("div.destinations ul.level2 li:eq(2)").show();
						}
						if(data.level2_destination3 != ''){
							$("#level2_destination3").val(data.level2_destination3);
							$("div.destinations ul.level2 li:eq(3)").show();
						}
						if(data.level2_destination4 != ''){
							$("#level2_destination4").val(data.level2_destination4);
							$("div.destinations ul.level2 li:eq(4)").show();
						}
						if(data.level3_destination0 != ''){
							$("#level3_destination0").val(data.level3_destination0);
							$("div.destinations ul.level2 li:eq(0)").show();
							count_results = 1;
						}
						if(data.level3_destination1 != ''){
							$("#level3_destination1").val(data.level3_destination1);
							$("div.destinations ul.level2 li:eq(1)").show();
							count_results = 2;
						}
						if(data.level3_destination2 != ''){
							$("#level3_destination2").val(data.level3_destination2);
							$("div.destinations ul.level2 li:eq(2)").show();
							count_results = 3;
						}
						if(data.level3_destination3 != ''){
							$("#level3_destination3").val(data.level3_destination3);
							$("div.destinations ul.level2 li:eq(3)").show();
							count_results = 4;
						}
						if(data.level3_destination4 != ''){
							$("#level3_destination4").val(data.level3_destination4);
							$("div.destinations ul.level2 li:eq(4)").show();
							count_results = 5;
						}
					}, "json"
				);
			}else{
				$(".search-destination").attr("id", "allow");
			}
		}
		
		$(".clear-destination").click(function(){
			$("#level1_destination").val('');
			for(i=0; i<5; i++){
				$("#level1_destination"+i).val('');
				$("#level2_destination"+i).val('');
				$("#level3_destination"+i).val('');
				if(i != 0){
					$("#level1_destination"+i).parent().hide();
					$("#level2_destination"+i).parent().hide();
					$("#level3_destination"+i).parent().hide();
				}
			}
			count_results = 0;
		});
		
	});
</script>
