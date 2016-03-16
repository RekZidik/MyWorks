// JavaScript Document
function evalPwd(s)
{
	var cmpx = 0;
	
	if (s.length >= 6)
	{
		cmpx++;
		
		if (s.search("[A-Z]") != -1)
		{
			cmpx++;
		}
		
		if (s.search("[0-9]") != -1)
		{
			cmpx++;
		}
		
		if (s.length >= 8 || s.search("[\x20-\x2F\x3A-\x40\x5B-\x60\x7B-\x7E]") != -1)
		{
			cmpx++;
		}
	}
	
	if (cmpx == 0)
	{
		document.getElementById("weak").className = "nrm";
		document.getElementById("medium").className = "nrm";
		document.getElementById("strong").className = "nrm";
	}
	else if (cmpx == 1)
	{
		document.getElementById("weak").className = "red";
		document.getElementById("medium").className = "nrm";
		document.getElementById("strong").className = "nrm";
	}
	else if (cmpx == 2)
	{
		document.getElementById("weak").className = "yellow";
		document.getElementById("medium").className = "yellow";
		document.getElementById("strong").className = "nrm";
	}
	else
	{
		document.getElementById("weak").className = "green";
		document.getElementById("medium").className = "green";
		document.getElementById("strong").className = "green";
	}
}