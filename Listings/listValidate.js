function listCheck()
{
	var x = document.forms["listForm"].elements;
	// - 1 because button is last element
	for(i=0; i < (x.length - 1); i++)
	{
		if(x[i].value == '')
		{
			$("#listEmpty").modal()
			return false;
		}
		
		if(isNaN(x[i].value))
		{
			$("#listNumber").modal()
			return false;
		}
	}

}