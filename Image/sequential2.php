<?php
function find2($array, $target)
{
	for ($i = 0; $i < count($array); $i++)
	{
		if($array[$i] == $target)
		{
			return $i;
		}
	}
	return -1;
}


?>