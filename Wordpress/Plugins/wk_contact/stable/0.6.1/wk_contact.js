jQuery(document).ready(function($) {
	$("input#human").change(function () {
		var result = $("input#human_result").attr("value");
		var input = $("input#human").attr("value");
		if(input == result){
			var text = $("input#submit").attr("value");
			$("input#submit").replaceWith('<input name="submit" type="submit" id="submit" value="'+text+'" />');
		}else{
			$("input#human").css("border", "2px solid #FF0000");
		}
	});
});
