<?php function CleanSQL($query){
	$query = str_replace("'","''", $query);
	return $query;

}
?>

