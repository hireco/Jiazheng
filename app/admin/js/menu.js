function showDiv(objID,imgID)
{
	x = document.getElementById(objID);
	if (x.style.display == "none")
	{
		x.style.display = "block";
	}
	else
	{
		x.style.display = "none";
	}
}