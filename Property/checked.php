<?php function fCheck($array ,$value2)
	{
		for($i=0; $i < count($array); $i++)
		{
			if ($array[$i] == $value2)
			{
				return true;
			}
		}
		return false;

	}
	
?>