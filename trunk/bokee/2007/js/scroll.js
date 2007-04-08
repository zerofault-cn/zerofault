var stopscroll1 = false;
var stopscroll2 = false;
var stopscroll3 = false;
var scrollElem = new Array(
	document.getElementById("andyscroll1"),
	document.getElementById("andyscroll2"),
	document.getElementById("andyscroll3"));
var marqueesHeight = scrollElem[0].style.height;

scrollElem[0].onmouseover = new Function('stopscroll1 = true');
scrollElem[0].onmouseout  = new Function('stopscroll1 = false');
scrollElem[1].onmouseover = new Function('stopscroll2 = true');
scrollElem[1].onmouseout  = new Function('stopscroll2 = false');
scrollElem[2].onmouseover = new Function('stopscroll3 = true');
scrollElem[2].onmouseout  = new Function('stopscroll3 = false');
var preTop = 0;
var currentTop = 0;
var stoptime = 0;
var leftElem = new Array(
	document.getElementById("scrollmessage1"),
	document.getElementById("scrollmessage2"),
	document.getElementById("scrollmessage3"));
scrollElem[0].appendChild(leftElem[0].cloneNode(true));
scrollElem[1].appendChild(leftElem[1].cloneNode(true));
scrollElem[2].appendChild(leftElem[2].cloneNode(true));

init_srolltext();

function init_srolltext()
{
	scrollElem[0].scrollTop = 0;
	scrollElem[1].scrollTop = 0;
	scrollElem[2].scrollTop = 0;
	setInterval('scrollUp(0)', 20);//这个参数是确定滚动速度的, 数值越小, 速度越快 
	setInterval('scrollUp(1)', 20);
	setInterval('scrollUp(2)', 20);
}
function scrollUp(i)
{
	if(eval('stopscroll'+(i+1)))
	{
		return;
	}
	currentTop += 2;//设为1, 可以实现间歇式的滚动; 设为2, 则是连续滚动 
	if(currentTop == 19)
	{
		stoptime += 1;
		currentTop -= 1;
		if(stoptime == 180)
		{
			currentTop = 0;
			stoptime = 0;
		}
	}
	else
	{
		preTop = scrollElem[i].scrollTop;
		scrollElem[i].scrollTop += 1;
		if(preTop == scrollElem[i].scrollTop)
		{
			scrollElem[i].scrollTop = 0;
			scrollElem[i].scrollTop += 1;
		}
	}
}