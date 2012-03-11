<?php
class name {
    private $name = "Fluf ";
    private function fullname($last){
        $this->name .= $last;
        echo "My full name is {$this->name}";
    }
    function showMe($last){
        $this->fullname($last);
    }
}
$new = new name;
//$new->showMe("Adamson");

class fire {
	private function init(){
		echo 'INIT';
	}
	function go() {
		echo '<br>is not';
		$this->init();
	}
}

$f = new fire;
$f->go();
//$f->init();
?>
