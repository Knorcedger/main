<style>
	div.<?php echo $name; ?>-button {
		background:transparent url(http://valums.com/wp-content/uploads/ajax-upload/button.png);
		color:#C7D92C;
		font-size:14px;
		height:29px;
		padding-top:15px;
		text-align:center;
		width:133px;
	}
</style>
<script type="text/javascript">
	jQuery(document).ready(function() {
		//get height
		var height = jQuery("div.<?php echo $name; ?>-button").css("height");
		//remove px
		height = height.replace(/px/i, "");
		//make it a number
		height = parseInt(height);
		//get padding top
		var pt = jQuery("div.<?php echo $name; ?>-button").css("padding-top");
		//remove px
		pt = pt.replace(/px/i, "");
		//make it a number
		pt = parseInt(pt);
		//get padding bottom
		var pb = jQuery("div.<?php echo $name; ?>-button").css("padding-bottom");
		//remove px
		pb = pb.replace(/px/i, "");
		//make it a number
		pb = parseInt(pb);
		//add them
		height_all = height + pt + pb;
		//jQuery("iframe#<?php echo $name; ?>").css({"height" : height_all+"px"});
						
		//get width
		var width = jQuery("div.<?php echo $name; ?>-button").css("width");
		//remove px
		width = width.replace(/px/i, "");
		//make it a number
		width = parseInt(width);
		//get padding top
		var pl = jQuery("div.<?php echo $name; ?>-button").css("padding-left");
		//remove px
		pl = pl.replace(/px/i, "");
		//make it a number
		pl = parseInt(pl);
		//get padding bottom
		var pr = jQuery("div.<?php echo $name; ?>-button").css("padding-right");
		//remove px
		pr = pr.replace(/px/i, "");
		//make it a number
		pr = parseInt(pr);
		//add them
		width_all = width + pl + pr;
		//jQuery("iframe#<?php echo $name; ?>").css({"width" : width_all+"px"});
						
		//fix input
		jQuery("iframe#avatar .<?php echo $name; ?> input").css({"font-size" : height_all+"px"});
	});
</script>