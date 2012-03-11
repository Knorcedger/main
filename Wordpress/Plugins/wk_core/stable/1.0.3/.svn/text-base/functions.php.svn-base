<?php
function check_user_level($level){
	if($level == 5){
		if(current_user_can('read')){
			return 1;
		}
	}elseif($level == 4){
		if(current_user_can('edit_posts')){
			return 1;
		}
	}elseif($level == 3){
		if(current_user_can('publish_posts')){
			return 1;
		}
	}elseif($level == 2){
		if(current_user_can('publish_pages')){
			return 1;
		}
	}elseif($level == 1){
		if(current_user_can('import')){
			return 1;
		}
	}else{
		return 0;
	}
}
?>