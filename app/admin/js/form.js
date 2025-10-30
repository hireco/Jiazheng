function CheckAll(form) {
	for (var i=0;i<form.elements.length;i++) {
		var e = form.elements[i];
		if (e.name != 'chkall')
		e.checked = form.chkall.checked;
	}
}
function ifDel(delurl) {
	var truthBeTold = window.confirm("ÄúÈ·¶¨ÒªÉ¾³ýÂð£¿");
	if (truthBeTold) {
		location=delurl;
	}  else  {
		return;
	}
}