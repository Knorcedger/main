<?php
function wk_submit_category($name, $translation, $object_id = '', $object_type = 'post') {
?>
<p class="<?php echo $name; ?>">
	<label for="<?php echo $name; ?>"><?php echo $translation; ?>: </label>
	<SELECT NAME="<?php echo $name; ?>">
		<?php
		//get all categories, empty or not
		$categories = get_categories( "hide_empty=0" );
		//array to save the names of cats that are childs of others
		//but save them in the array as the ids of their parents.
		//the reason is to display the childs just after the parent
		$childs = array();
		//array to save the childs ids
		$childids = array();
		foreach ($categories as $cat) {
			//check if it is has parent
			if($cat->parent != 0){
				//save child cat name and id in an array with parents id
				$childs[$cat->parent] .= $cat->name . '|';
				$childids[$cat->parent] .= $cat->cat_ID . '|';
			}
		}
		//we loop the parents and for each parent we also loop for any childs
		foreach ($categories as $cat) {
			//check if it is parent
			if($cat->parent == 0){
				$catid = $cat->cat_ID;
				$catname = $cat->name;
				?>
				<option value="<?php echo $catid; ?>" <?php if($catid == $category){echo 'selected="true"';} ?>><?php echo $catname; ?></option>
				<?php
				//display categories
				$childcats = explode('|', $childs[$cat->cat_ID]);
				$childcatids = explode('|', $childids[$cat->cat_ID]);
				//last array item is empty
				for($i = 0; $i < sizeof($childcats)-1; $i++){ ?>
					<option value="<?php echo $childcatids[$i]; ?>" <?php if($childcatids[$i] == $category){echo 'selected="true"';} ?>>---<?php echo $childcats[$i]; ?></option>
				<?php
				}
			}
		}
		?>
	</SELECT>
</p>
<?php
}
?>
