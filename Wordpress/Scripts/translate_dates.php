<?php 

function translate_dates($date, $first = 0){
	$months_en = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
	$days_en = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
	if($first == 0){
		$months_gr = array('Ιανουαρίου', 'Φεβρουαρίου', 'Μαρτίου', 'Απριλίου', 'Μαΐου', 'Ιουνίου', 'Ιουλίου', 'Αυγούστου', 'Σεπτεμβρίου', 'Οκτωβρίου', 'Νοεμβρίου', 'Δεκεμβρίου');
	}else{
		$months_gr = array('Ιανουαριος', 'Φεβρουαριος', 'Μαρτιος', 'Απριλιος', 'Μαιος', 'Ιουνιος', 'Ιουλιος', 'Αυγουστος', 'Σεπτεμβριος', 'Οκτωβριος', 'Νοεμβριος', 'Δεκεμβριος');
	}
	$days_gr = array('Κυριακή', 'Δευτέρα', 'Τρίτη', 'Τετάρτη', 'Πέμπτη', 'Παρασκευή', 'Σάββατο');
	for($i = 0; $i < 12; $i++){
		$date = str_replace($months_en[$i], $months_gr[$i], $date);
	}
	for($i = 0; $i < 7; $i++){
		$date = str_replace($days_en[$i], $days_gr[$i], $date);
	}
	$date = str_replace('am', 'π.μ.', $date);
	$date = str_replace('pm', 'μ.μ.', $date);
	
	return $date;
}

?>
