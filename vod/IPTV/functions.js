var link_count=document.links.length;//ȡ��ҳ�����Ӹ���

var key2=GetCookie(window.location+'_focus');//��ʼ��������������ֵ

var uri=window.location.toString();
var filename=uri.substring(uri.lastIndexOf('/')+1);
if(GetCookie(filename+'_focus')==null)
{
	key2=0;
}
else
{
	key2=parseInt(GetCookie(filename+'_focus'));
}
function setkey2(i)
{
	key2=i;
}
if(document.all)//ȡ�����������
{
	var ie=1;
}
else
{
	var ie=0;
}
function back()//���˶���
{
	window.history.go(-1);
}
function onfoc2(key)
{
	document.links[key].focus();
}

/**********************************���ݷֱ����趨ҳ��ߴ�**********************/
var src_width=800;
if(screen.width==800)
{
	src_width=800;
}
if(screen.width==640)
{
	src_width=640;
}
/**************************************/

/*********************************����˵�����λ��***************************/
function menu_onfoc()
{
	onfoc(key2);
}
/*************************************/

/*********************************JS COOKIE FUNCTION*************************/
function SetCookie (name, value)
{
	var argv = SetCookie.arguments;
	var argc = SetCookie.arguments.length;
	var the_date = new Date("December 31, 2024");
	var expires = the_date.toGMTString();
	var path = (argc > 3) ? argv[3] : null;
	var domain = (argc > 4) ? argv[4] : null;
	var secure = (argc > 5) ? argv[5] : false;
	document.cookie = name + "=" + escape (value) +
    ((expires == null) ? "" : ("; expires=" + expires)) +
    ((path == null) ? "" : ("; path=" + path)) +
    ((domain == null) ? "" : ("; domain=" + domain)) +
    ((secure == true) ? "; secure" : "");
}
function GetCookie (name) 
{
	var arg = name + "=";
	var alen = arg.length;
	var clen = document.cookie.length;
	var i = 0;
	while (i < clen) 
	{
		var j = i + alen;
		if (document.cookie.substring(i, j) == arg)
			return getCookieVal (j);
		i = document.cookie.indexOf(" ", i) + 1;
		if (i == 0)
			break; 
	}
	return null;
}
function getCookieVal (offset)
{
	var endstr = document.cookie.indexOf (";", offset);
	if (endstr == -1)
		endstr = document.cookie.length;
	return unescape(document.cookie.substring(offset, endstr));
}
/***************************************/

/*********************************�л�ͼƬЧ��********************************/
function MM_swapImgRestore()//v3.0
{	
	var i,x,a=document.MM_sr;
	for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++)
	{
		x.src=x.oSrc;
	}
}
function MM_preloadImages()//v3.0
{
	var d=document;
	if(d.images)
	{
		if(!d.MM_p)
		{
			d.MM_p=new Array();
		}
		var i,j=d.MM_p.length,a=MM_preloadImages.arguments;
		for(i=0; i<a.length; i++)
		{
			if (a[i].indexOf("#")!=0)
			{
				d.MM_p[j]=new Image; 
				d.MM_p[j++].src=a[i];
			}
		}
	}
}
function MM_findObj(n, d)//v4.01
{
	var p,i,x;
	if(!d)
	{
		d=document;
	}
	if((p=n.indexOf("?"))>0&&parent.frames.length)
	{
		d=parent.frames[n.substring(p+1)].document;
		n=n.substring(0,p);
	}
	if(!(x=d[n])&&d.all)
	{
		x=d.all[n];
	}
	for (i=0;!x&&i<d.forms.length;i++)
	{
		x=d.forms[i][n];
	}
	for(i=0;!x&&d.layers&&i<d.layers.length;i++)
	{
		x=MM_findObj(n,d.layers[i].document);
	}
	if(!x && d.getElementById)
	{
		x=d.getElementById(n);
		return x;
	}
}

function MM_swapImage()//v3.0
{
	var i,j=0,x,a=MM_swapImage.arguments;
	document.MM_sr=new Array;
	for(i=0;i<(a.length-2);i+=3)
	{
		if ((x=MM_findObj(a[i]))!=null)
		{
			document.MM_sr[j++]=x;
			if(!x.oSrc)
			{
				x.oSrc=x.src;
			}
			x.src=a[i+2];
		}
	}
}
/**********************************************************************/

/***********************************��ʾ��̬ʱ��***********************/
var timerID = null;
var timerRunning = false;

function stopclock ()
{
	if(timerRunning)
		clearTimeout(timerID);
	timerRunning = false;
}
function startclock () 
{
	stopclock();
	showtime();
}
function initarray()
{
	this.length=initarray.arguments.length
	for(var i=0;i<this.length;i++)
	this[i+1]=initarray.arguments[i]  
}
var d=new initarray("����һ","���ڶ�","������","������","������","������","������");

function showtime () 
{
	var now = new Date();
	var years = now.getYear();
	if(navigator.appName=='Netscape')
	{
		years=years+1900;
	}
	var months = now.getMonth();
	var dates = now.getDate();
	var hours = now.getHours();
	var minutes = now.getMinutes();
	var seconds=now.getSeconds();
	var timeValue = years;
	timeValue += ((months+1 < 10) ? "-0" : "-") + (months+1);
	timeValue += ((dates < 10) ? "-0" : "-") + dates;
	timeValue += '<br>'+d[now.getDay()==0?7:now.getDay()]+'<br>';
	timeValue += ((hours < 10) ? " 0" : " ") + hours;
	timeValue += ((minutes < 10) ? ":0" : ":") + minutes;
	timeValue += ((seconds < 10) ? ":0" : ":") + seconds;
	realtimespan=document.getElementById('realtime');
	realtimespan.innerHTML=timeValue;
	timerID = setTimeout("showtime()",1000);
	timerRunning = true;
}

/**********************************************************************/