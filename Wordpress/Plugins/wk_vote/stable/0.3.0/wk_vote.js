jQuery(document).ready(function($) {

	$(".wk_vote").click(function () {
		var post_data = $(this).attr('class');
		var loggedin = post_data.indexOf("loggedin");
		if(loggedin != -1){
			//first remove the buttons, to not let him vote twice
			var t = post_data.split(" ");
			var t2 = t[2].split("-");
			var pid = t2[1];
			$("a.post-"+pid).remove();
			$.post("/wp-content/plugins/wk_vote/vote.php", { post: post_data},
				function(data){
					$("span.post-"+data.pid).text(data.votes);
				}, "json"
			);
		}else{
			alert('please login first');
		}
	});
		
	$(".votebuttons .votedown").click(function () {
		var post_data = $(this).parent().attr('data');
		$.post("http://wrideo.com/wp-content/themes/forme/library/vote.php", { user: "<?php echo $user_ID; ?>", post: post_data} );
		$(this).parent().parent().hide("fast");
		$(this).parent().parent().next().text("Voted");
		//decrease votes
		var post_votes = $(this).parent().parent().prev().text();
		post_votes = parseInt(post_votes);
		post_votes = post_votes-1;
		$(this).parent().parent().prev().text(post_votes);
	});

})
