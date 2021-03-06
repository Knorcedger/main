<?php  
/* 
Plugin Name: wk_navigation
Plugin URI: http://thinkdesquared.com 
Description: A navigation plugin
Version: 0.1.0
Author: Achilleas Tsoumitas 
Author URI: http://knorcedger.com 
*/
?>
<?php
/**
 * Displays a contact form in wordpress
 * 
 * @return 
 * @param string $language The language used in the contact form
 * @param string $posts_num The total number of the posts
 * @param string $mode[optional] Which mode to use. Mode 1 works for greek chars in url
 */
function wk_contact($language, $posts_num, $mode = 1){

	if($mode == 0){
		//find the page for the navigation
		$temp = explode("/page/", $_SERVER['REQUEST_URI']);

		if($temp[1] != ''){
			$temp2 = explode("/", $temp[1]);
			$paged = $temp2[0];
		}else{
			$paged = 1;
		}
		//create some vars for the pagination
		$temp = explode('page/', $_SERVER['REQUEST_URI']);
		if($temp[0] == ''){
			$url = '/';
		}else{
			$temp = explode('?', $temp[0]);
			$url = $temp[0];
		}
		$temp = explode('?', $_SERVER['REQUEST_URI']);
		if($temp[1] != ''){
			$addon = '?'.$temp[1];
		}else{
			$addon = '';
		}
		//for pagination
		$limit_down = $paged*10 - 10;
		$limit_up = $paged*10;
	?>
	
		<div id="wp-pagenavi">
			<span class="pages">Σελίδα <?php echo $paged; ?> από <?php $last_page = intval($posts_num/10); $last_page++; echo $last_page; ?></span>
			<span class="navi-choices">
				<a href="<?php echo $url.$addon; ?>" title="« Πρώτη Σελίδα">« Πρώτη</a>
				<a href="<?php if($paged <= 2){echo $url.$addon;}else{$new_paged = $paged-1; echo $url.'page/'.$new_paged.'/'.$addon;} ?>">«</a>
				<?php
				if($paged < 4){
					$start = 1;
				}else{
					$start = $paged-1;
				}
				if($last_page - $paged >3){
					$end = $paged + 3;
				}else{
					$end = $last_page+1;
				}
				for($i=$start; $i<$end; $i++){
					if($i == $paged){
				?>
						<span class="current"><?php echo $paged; ?></span>
				<?php
					}else{
				?>
						<a href="<?php if($i != 1){echo $url.'page/'.$i.'/'.$addon;}else{echo $url.$addon;} ?>" title="<?php echo $i; ?>"><?php echo $i; ?></a>
				<?php
					}
				}
				?>
				<a href="<?php if($paged != $last_page){$new_paged = $paged+1; echo $url.'page/'.$new_paged.'/'.$addon;}else{echo $_SERVER['REQUEST_URI'];} ?>">»</a>
				<a href="<?php if($last_page != 1){echo $url.'page/'.$last_page.'/'.$addon;}else{echo $url.$addon;} ?>" title="Τελευταία Σελίδα »">Τελευταία »</a>
			</span> <!-- close navi-choices -->
		</div> <!-- close wp-pagenavi -->
	
	<?php
	}else{
		$paged = $_GET['page'];
		if($paged == ''){
			$paged = 1;
		}
		$temp = explode('/?page=', $_SERVER['REQUEST_URI']);
		if($temp[0] == ''){
			$url = '/';
		}else{
			$url = $temp[0];
		}
		
		//for pagination
		$limit_down = $paged*10 - 10;
		$limit_up = $paged*10;
	?>
		<div id="wp-pagenavi">
			<span class="pages">Σελίδα <?php echo $paged; ?> από <?php $last_page = intval($posts_num/10); $last_page++; echo $last_page; ?></span>
			<span class="navi-choices">
				<a href="<?php echo $url; ?>" title="« Πρώτη Σελίδα">« Πρώτη</a>
				<a href="<?php if($paged <= 2){echo $url;}else{$new_paged = $paged-1; echo $url.'/?page='.$new_paged;} ?>">«</a>
				<?php
				if($paged < 4){
					$start = 1;
				}else{
					$start = $paged-1;
				}
				if($last_page - $paged >3){
					$end = $paged + 3;
				}else{
					$end = $last_page+1;
				}
				for($i=$start; $i<$end; $i++){
					if($i == $paged){
				?>
						<span class="current"><?php echo $paged; ?></span>
				<?php
					}else{
				?>
						<a href="<?php if($i != 1){echo $url.'/?page='.$i;}else{echo $url;} ?>" title="<?php echo $i; ?>"><?php echo $i; ?></a>
				<?php
					}
				}
				?>
				<a href="<?php if($paged != $last_page){$new_paged = $paged+1; echo $url.'/?page='.$new_paged;}else{echo $_SERVER['REQUEST_URI'];} ?>">»</a>
				<a href="<?php if($last_page != 1){echo $url.'/?page='.$last_page;}else{echo $url;} ?>" title="Τελευταία Σελίδα »">Τελευταία »</a>
			</span> <!-- close navi-choices -->
		</div> <!-- close wp-pagenavi -->
	<?php
	}
}
?>
