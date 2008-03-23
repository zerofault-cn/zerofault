function adjustfooter()
{
//	document.getElementById('footer').style.top=
//	alert(document.getElementById('top').style.height);
}

document.onload=adjustfooter();




document.body.onmousemove=quicktitle;
document.body.onmouseover=gettitle;
document.body.onmouseout=restoretitle;

var temptitle='';

function gettitle()
{
//	alert(document.documentElement.scrollTop);
	if(event.srcElement.title && (event.srcElement.title!='' || (event.srcElement.title=='' && temptitle!=''))) 
	{
	//	titlelayer.style.left=event.x+document.documentElement.scrollLeft;
	//	titlelayer.style.top=event.y+document.documentElement.scrollTop;
		titlelayer.style.visibility='visible';
		temptitle=event.srcElement.title;
		event.srcElement.title='';
		titlelayer.innerText=temptitle;
	}
}

function quicktitle() 
{
	
	if(titlelayer.style.visibility=='visible') 
	{
		if(event.x>800)
		{
			titlelayer.style.left=event.x-120+document.documentElement.scrollLeft;
		}
		else
		{
			titlelayer.style.left=event.x+8+document.documentElement.scrollLeft;
		}
		titlelayer.style.top=event.y-60+document.documentElement.scrollTop;
	}
}

function restoretitle() 
{
	event.srcElement.title=temptitle;
	temptitle='';
	titlelayer.style.visibility='hidden';
}