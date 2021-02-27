<?php function money($value1)
	{
		$value1 = (string)$value1;
		$value1 = strrev($value1);
		
		$new = "";
		
		for ($i=0; $i < strlen($value1); $i++)
		{
			$new = $new.$value1[$i];
			if(($i + 1)%3 == 0)
			{
				if(($i + 1) != strlen($value1))
				{
					$new = $new.",";
				}
				
			}
		}
		$new = $new."$";
		$new = strrev($new);
		return $new;
	}
?>