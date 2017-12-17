function sal(form){
	for (var i = 0; i < form.elements.length; i ++)
	{
		var e = form.elements[i];
		if (e.type == 'checkbox'){
			e.checked = true;
		}
	}
}

function opal(form){
	for (var i = 0; i < form.elements.length; i ++)
	{
		var e = form.elements[i];
		if (e.type == 'checkbox'){
			if(e.checked == true) e.checked = false;
			else e.checked = true;
		}
	}
}
function clal(form)
{
	for (var i = 0; i < form.elements.length; i ++)
	{
		var e = form.elements[i];
		if (e.type == 'checkbox'){
			e.checked = false;
		}
	}
}

function FormWin(obj,winname){
	 window.open('',winname,'scrollbars=yes,width=640,height=410,resizable,scrollbars')
	 obj.target=winname
}
