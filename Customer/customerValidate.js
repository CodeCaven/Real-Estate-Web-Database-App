function VerifyData(theForm)
{

	if(theForm.c_surname.value == "")
	{
		$("#surnameModal").modal()
		theForm.c_surname.focus();
		return false;
	}
	
	if(theForm.c_first.value == "")
	{
		
		$("#fnameModal").modal()
		theForm.c_first.focus();
		return false;
	}
	
	
	
	if(isNaN(theForm.c_pc.value))
	{
		$("#c_pc").modal()
		theForm.c_pc.focus();
		return false;
	}
	
	if(isNaN(theForm.mobile.value))
	{
		$("#cusMob").modal()
		theForm.mobile.focus();
		return false;
	}
	
	var e = document.getElementById("c_list");
	var optionSelIndex = e.options[e.selectedIndex].value;
	if (optionSelIndex == 0) {
		$("#cusDrop").modal()
		theForm.c_list.focus();
		return false;
                
    }
	
	return true;
}