function VerifyDataEntry(theForm)
{
	
	
	if(theForm.street.value == "")
	{
		$("#streetModal").modal()
		theForm.street.focus();
		return false;
	}
	
	if(theForm.suburb.value == "")
	{
		
		$("#suburbModal").modal()
		theForm.suburb.focus();
		return false;
	}
	
	if(theForm.state.value == "")
	{
		
		$("#stateModal").modal()
		theForm.state.focus();
		return false;
	}
	
	if(theForm.postcode.value == "")
	{
		
		$("#pcModal1").modal()
		theForm.postcode.focus();
		return false;
	}
	
	if(isNaN(theForm.postcode.value))
	{
		
		$("#pcModal2").modal()
		theForm.postcode.focus();
		return false;
	}
	
	var e = document.getElementById("proptypes");
	var optionSelIndex = e.options[e.selectedIndex].value;
	if (optionSelIndex == 0) {
		$("#drop").modal()
		theForm.postcode.focus();
		return false;
                
    }
	
	
	
	return true;
}