window.onresize = window.onload = function()
{
	var w,h;
	if(!!(window.attachEvent && !window.opera))
	{
		h = document.documentElement.clientHeight;
		w = document.documentElement.clientWidth;
	}
	else
	{
		h =	window.innerHeight;
		w = window.innerWidth;
	}

	var bgImg = document.getElementById('background').getElementsByTagName('img')[0];
	bgImg.width = w;
	bgImg.height= (h - 400) ;		
}			
