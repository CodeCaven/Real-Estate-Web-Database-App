<?php
function compare($post, $features){
	if(count($post) > count($features)){
		return false;
	}
	else
	{
		$count = 0;
		for($i = 0; $i < count($post); $i ++){
			for($j = 0; $j < count($features); $j ++){
				if($post[$i] == $features[$j]){
					$count = $count + 1;
					break;
				}
			}
		}
		
		if($count == count($post)){
			return true;
		}
		else{
			return false;
		}
	}
	
}


?>
