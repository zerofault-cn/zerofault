//����ʽ�˵�����
var h;
var w;
var l;
var t;
var topMar = 1;
var leftMar = -2;
var space = 1;
var isvisible;
var MENU_SHADOW_COLOR='#ffffff';//���������˵���Ӱɫ
var global = window.document
global.fo_currentMenu = null
global.fo_shadows = new Array
function HideMenu() 
{
	var mX;
	var mY;
	var vDiv;
	var mDiv;
	if (isvisible == true)
	{
		vDiv = document.all("menuDiv");
		mX = window.event.clientX + document.body.scrollLeft;
		mY = window.event.clientY + document.body.scrollTop;
		if((mX < parseInt(vDiv.style.left))||(mX >parseInt(vDiv.style.left)+vDiv.offsetWidth)||(mY < parseInt(vDiv.style.top)-h) || (mY > parseInt(vDiv.style.top)+vDiv.offsetHeight))
		{
			vDiv.style.visibility = "hidden";
			isvisible = false;
		}
	}
}

function ShowMenu(vMnuCode,tWidth)//�µ��˵�
{
	vSrc = window.event.srcElement;
	vMnuCode = "<table id='submenu' cellspacing=1 cellpadding=1 style='width:"+tWidth+"' onmouseout='HideMenu()'><tr><td nowrap align=left>" + vMnuCode + "</td></tr></table>";

	h = vSrc.offsetHeight;
	w = vSrc.offsetWidth;
	l = vSrc.offsetLeft + leftMar;
	t = vSrc.offsetTop + topMar + h + space-2;
	vParent = vSrc.offsetParent;
	while (vParent.tagName.toUpperCase() != "BODY")
	{
		l += vParent.offsetLeft;
		t += vParent.offsetTop;
		vParent = vParent.offsetParent;
	}

	menuDiv.innerHTML = vMnuCode;
	menuDiv.style.top = t;
	menuDiv.style.left = l;
	menuDiv.style.visibility = "visible";
	isvisible = true;
    makeRectangularDropShadow(submenu, MENU_SHADOW_COLOR, 4)
}

function ShowSubMenu(vMnuCode,tWidth)//�ҵ��˵�
{
	vSrc = window.event.srcElement;
	vMnuCode = "<table id='submenu' cellspacing=0 cellpadding=0 style='width:"+tWidth+"' onmouseout='HideMenu()'><tr><td nowrap align=left>" + vMnuCode + "</td></tr></table>";

	h = vSrc.offsetHeight;
	w = vSrc.offsetWidth;
	l = vSrc.offsetLeft + leftMar+30;
	t = vSrc.offsetTop + topMar + space-2;
	vParent = vSrc.offsetParent;
	while (vParent.tagName.toUpperCase() != "BODY")
	{
		l += vParent.offsetLeft;
		t += vParent.offsetTop;
		vParent = vParent.offsetParent;
	}

	menuDiv.innerHTML = vMnuCode;
	menuDiv.style.top = t;
	menuDiv.style.left = l;
	menuDiv.style.visibility = "visible";
	isvisible = true;
    makeRectangularDropShadow(submenu, MENU_SHADOW_COLOR, 4)
}

function makeRectangularDropShadow(el, color, size)
{
	var i;
	for (i=size; i>0; i--)
	{
		var rect = document.createElement('div');
		var rs = rect.style
		rs.position = 'absolute';
		rs.left = (el.style.posLeft + i) + 'px';
		rs.top = (el.style.posTop + i) + 'px';
		rs.width = el.offsetWidth + 'px';
		rs.height = el.offsetHeight + 'px';
		rs.zIndex = el.style.zIndex - i;
		rs.backgroundColor = color;
		var opacity = 1 - i / (i + 1);
		rs.filter = 'alpha(opacity=' + (100 * opacity) + ')';
		el.insertAdjacentElement('afterEnd', rect);
		global.fo_shadows[global.fo_shadows.length] = rect;
	}
}



function _FindObj(n,d)
	{ 
	var p,i,x;  
	if(!d) d=document; 
	if((p=n.indexOf("?"))>0&&parent.frames.length) 
		{
		d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);
		}
	if(!(x=d[n])&&d.all) x=d.all[n]; 
	for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
	for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=_FindObj(n,d.layers[i].document);
	if(!x && document.getElementById) x=document.getElementById(n); return x;
	}
function _ShowHideLayers()
	{ 
	var i,p,v,obj,args=_ShowHideLayers.arguments;
	for (i=0; i<(args.length-2); i+=3) 
	if ((obj=_FindObj(args[i]))!=null) 
		{ v=args[i+2];
		if (obj.style) 
			{
			obj=obj.style; v=(v=='show')?'visible':(v='hide')?'hidden':v; 
			}
		obj.visibility=v; 
		}
	}
function _MouseOverMenu(ObjName,ObjSubMenuName)
	{ 
	if (!ObjName.contains(event.fromElement)) 
		{ 
		ObjName.style.cursor = 'hand'; 
		ObjName.background = 'images/menu_bg_up.jpg'; 
		_ShowHideLayers(ObjSubMenuName,'','show')
		}
	}
function _MouseOutMenu(ObjName,ObjSubMenuName)
	{
	if (!ObjName.contains(event.toElement))
		{ 
		ObjName.style.cursor = 'default'; 
		ObjName.background = 'images/menu_bg_down.jpg'; 
		_ShowHideLayers(ObjSubMenuName,'','hide')
		}
	} 


var tips="<a href='/phpbbs/utilities/calendar.htm' target=_blank>��������</a><br><a target=_blank href='/phpbbs/utilities/block.html'>����˹����</a><br><a href='/phpbbs/utilities/eatapple.html'>��ƻ��</a><br><a href='/phpbbs/utilities/brick.html'>��ש����Ϸ</a><br><a href='/phpbbs/utilities/earthquake.html' target=_blank>����</a><br><a href='/javascripttest/magic_painting.htm'>ħ����ɫ</a><br><a href='/javascripttest/turningover.htm'>��ͼ��Ϸ</a><br><a href='/phpbbs/utilities/pic_game.htm'>ƴͼ��Ϸ</a><br><a href='/javascripttest/hit_the_dot.htm'>�������</a><br><a href='/javascripttest/runner.htm'>�з����</a><br><a href='/javascripttest/calculator.htm'>������</a><br><a href='/javascripttest/checkall.htm'>����ɨ��</a><br><a href='/phpbbs/utilities/ipsearch.php'>IP��ַ��ѯ</a><br><a href='/phpbbs/utilities/mobilesearch.php'>�ֻ������ز�ѯ</a>";

var link="<a href='http://202.115.32.24' target=_blank>��������¥</a><br><a href='http://202.115.48.148' target=_blank>������ɫ�ǿ�</a><br><a href='http://bbs.uestc.edu.cn' target=_blank>���ӿƴ�һ������</a><br><a href='http://bbs.pku.edu.cn' target=_blank>����δ��BBS</a><br><a href='http://bbs3w.tsinghua.edu.cn' target=_blank>ˮľ�廪</a><br><a href='http://bbs.nju.edu.cn' target=_blank>�Ͼ���ѧС�ٺ�</a><br><a href=# onmouseover=ShowMenu(music,60)>Music</a>";

var bbs="<a href='http://202.115.32.24' target=_blank>��������¥</a><br><a href='http://202.115.48.148' target=_blank>������ɫ�ǿ�</a><br><a href='http://bbs.uestc.edu.cn' target=_blank'>���ӿƴ�һ������</a><br><a href='http://bbs.pku.edu.cn' target=_blank>����δ��BBS</a><br><a href='http://bbs3w.tsinghua.edu.cn' target=_blank>ˮľ�廪</a><br><a href='http://bbs.nju.edu.cn' target=_blank>�Ͼ���ѧС�ٺ�</a>";

var computer="<a href='http://www.buynow.com.cn' target=_blank>���Ի�</a><br><a href='http://www.westd.net' target=_blank>����IT��</a><br><a href='http://www.oakpc.com' target=_blank>������</a><br><a href='http://www.pconline.com.cn' target=_blank>̫ƽ�������</a><br><a href='http://www.zol.com.cn' target=_blank>�йش�����</a><br><a href='http://www.mydrivers.com' target=_blank>����֮��</a>";

var music="<a href='http://music.popv.net' target=_blank>��ά����վ</a><br><a href='http://51music.dhs.org' target=_blank>��ҪMUSIC</a><br><a href='http://www.51lrc.com' target=_blank>��Ҫ���</a><br><a href='http://popmusic.dhs.org' target=_blank>������������(��ͣ)</a><br><a href='http://music.ahnan.com' target=_blank>ʮһ��</a><br><a href=# onmouseover=ShowMenu(computer,60)>Computer</a>";

