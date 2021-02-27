function VerifyEmail(theForm)
{
	
	if(theForm.email.value == "")
	{
		$("#cusEmail").modal()
		theForm.email.focus();
		return false;
	}
	
	if(theForm.subject.value == "")
	{
		$("#subEmail").modal()
		theForm.subject.focus();
		return false;
	}
	
	if(theForm.message.value == "")
	{
		$("#messEmail").modal()
		theForm.message.focus();
		return false;
	}
	
	
	
	return true;
}