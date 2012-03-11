<div class="wrap">
	<div id="icon-options-general" class="icon32">
		<br/>
	</div>
	<h2>Add/Edit Items</h2>
	<div id="items">
		<?php
		$options_serialized = get_option('wk_cms');
		$options = unserialize($options_serialized);
		$loops = sizeof($options)/5;
		for($i=0; $i<$loops; $i++){
		?>
			<div class="edit-item">
				<a href="javascript:void(0);" class="title open"><?php echo $options[$i*5+1]; ?></a>
				<div class="item-details">
				<form id="item-details-form" action="/wp-content/plugins/wk_cms/save.php" method="post">
					<div class="title item-detail">Τίτλος</div>
					<input class="regular-text title" type="text" value="<?php echo $options[$i*5+1]; ?>" name="title" />
					<div class="slug item-detail">Slug</div>
					<input class="regular-text slug" type="text" value="<?php echo $options[$i*5+2]; ?>" name="slug" />
					<div class="description item-detail">Περιγραφή</div>
					<textarea class="large-text description" cols="10" rows="3" name="description"><?php echo $options[$i*5+3]; ?></textarea>
					<div class="photo item-detail">Εικόνα</div>
					<a class="button photo">Αλλαγή</a>
					<input type="hidden" value="<?php echo $options[$i*5+0]; ?>" name="id"/>
					<input class="button-primary" type="submit" value="Αποθήκευση" name="Submit"/>
				</form>
			</div>
		</div>
		<?php
		}
		?>	
		<div class="add-item">
			<a class="button add-item-link">Add</a>
		</div>
	</div>
</div>
