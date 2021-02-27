<?php
function find($array, $target)
{
	for ($i = 0; $i < count($array); $i++)
	{
		if($array[$i] == $target)
		{
			return true;
		}
	}
	return false;
}


?>