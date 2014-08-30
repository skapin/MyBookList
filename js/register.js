
function ch()
{
		alert("Error");
}

 
function checkPass(pass, passConf)
{
	if(document.getElementById(pass).value == document.getElementById(passConf).value)
	{
		document.getElementById("labelPassConf").innerHTML = "Okay !";
		document.getElementById("glyphPassConf").className = "glyphicon glyphicon-success form-control-feedback";
		document.getElementById("formPassConf").className = "form-group has-success has-feedback";		
	}
	else
	{
		document.getElementById("labelPassConf").innerHTML = "Erreure entre les password !";
		document.getElementById("glyphPassConf").className = "glyphicon glyphicon-remove form-control-feedback";
		document.getElementById("formPassConf").className = "form-group has-error has-feedback";
	}
}
