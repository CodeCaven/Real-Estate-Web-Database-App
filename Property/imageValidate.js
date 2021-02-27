function formcheck(form){
	var file = form.userfile.value;
	 
	if (file.length == 0)
	{
		document.getElementById("check").style.color = "green";
		document.getElementById("check").innerHTML = "Please enter a file";
		return false;
	}
	
	file = file.toUpperCase();
	var jpeg = file.indexOf(".JPG");
	var png = file.indexOf(".PNG");
	if (jpeg == -1 && png == -1)
	{
		document.getElementById("check").style.color = "red";
		document.getElementById("check").innerHTML = "Please enter only valid image files" ;
		return false;
	}
	return true;
}

