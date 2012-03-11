jQuery(document).ready(function($) {
	
    //hide all item details
    $("#items .edit-item .item-details").css("display", "none");
    
    //open edit item
    $("#items .edit-item a.title").click(function(){
    	var item_details = $(this).next();
    	item_details.slideToggle();
    });
    
    
    //used to allow add only once
    var added = 0;
    $("#items .add-item .add-item-link").click(function(){
    	if(added == 0){
    		$('<div class="item-details add-item-details"><form id="item-details-form" action="/wp-content/plugins/wk_cms/save.php" method="post"><div class="title item-detail">Τίτλος</div><input class="regular-text title" type="text" value="" name="title" /><div class="slug item-detail">Slug</div><input class="regular-text slug" type="text" value="" name="slug" /><div class="description item-detail">Περιγραφή</div><textarea class="large-text description" cols="10" rows="3" name="description"></textarea><div class="photo">Εικόνα</div><a class="button photo">Αλλαγή</a><input class="button-primary" type="submit" value="Αποθήκευση" name="Submit"/></form></div>').insertAfter(this);
    	}
    	added = 1;
    });
});
