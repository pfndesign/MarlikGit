function doMenu(item) {
	obj=document.getElementById(item);
	if (obj.style.display=="none") {
		obj.style.display="block";
		4
	}
	else {
		obj.style.display="none";
	}
}
function checkAll(theForm, cName, status) {
for (i=0,n=theForm.elements.length;i<n;i++)
  if (theForm.elements[i].className.indexOf(cName) !=-1) {
    theForm.elements[i].checked = status;
  }
}

